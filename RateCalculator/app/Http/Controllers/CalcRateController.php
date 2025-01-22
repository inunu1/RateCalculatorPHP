<?php

namespace App\Http\Controllers;

use App\Helpers\CalcRateHelper;
use App\Models\Player;
use App\Models\Result;

class CalcRateController extends Controller
{
    public function index()
    {
        // レート計算ヘルパーのインスタンスを生成
        $calcRateHelper = new CalcRateHelper();

        // 未計算の対局結果を取得（ゲーム日時順）
        $unprocessedResults = Result::where('calcrate_flag', false)
            ->orderBy('game_date', 'asc')
            ->get();

        foreach ($unprocessedResults as $result) {
            $winnerId = $result->winner_id;
            $loserId = $result->loser_id;
            dump($result->id);

            // 勝者のレートを取得（過去の対局がない場合は初期レート）
            $previousWinnerResult = Result::where(function ($query) use ($winnerId) {
                $query->where('winner_id', $winnerId)
                      ->orWhere('loser_id', $winnerId);
            })
            ->where('game_date', '<', $result->game_date)
            ->orderBy('game_date', 'desc')
            ->first();

            $winnerRate = $previousWinnerResult
            // 過去の対局がある場合はPlayerテーブルのratingを使用
            ? $calcRateHelper->calcRate($previousWinnerResult->winner_rate, $previousWinnerResult->loser_rate)[0]
            // 初期レート
            : Player::find($winnerId)->regist_rating;

            // 敗者のレートを取得（過去の対局がない場合は初期レート）
            $previousLoserResult = Result::where(function ($query) use ($loserId) {
                $query->where('winner_id', $loserId)
                      ->orWhere('loser_id', $loserId);
            })
            ->where('game_date', '<', $result->game_date)
            ->orderBy('game_date', 'desc')
            ->first();

            $loserRate = $previousLoserResult
            ? $calcRateHelper->calcRate($previousWinnerResult->winner_rate, $previousWinnerResult->loser_rate)[1]
            : Player::find($loserId)->regist_rating; // 初期レート

            // 対局開始時点のレートを保存
            $result->winner_rate = $winnerRate;
            $result->loser_rate = $loserRate;

            // 対局開始時点のレートでレート計算を実施
            list($newWinnerRate, $newLoserRate) = $calcRateHelper->calcRate($winnerRate, $loserRate);

            // 計算済みフラグを更新
            $result->calcrate_flag = true;
            $result->save();

            // Playersテーブルの最新レートを更新
            $winner = Player::find($winnerId);
            $loser = Player::find($loserId);

            $winner->rating = $newWinnerRate;
            dump($winner->rating);
            $winner->save();

            $loser->rating = $newLoserRate;
            dump($loser->rating);
            $loser->save();
        }

        return response()->json(['message' => 'レート計算が完了しました。']);
    }
}
