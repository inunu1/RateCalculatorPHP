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

            $previousWinnerResult = Result::where(function ($query) use ($winnerId) {
                $query->where('winner_id', $winnerId)
                      ->orWhere('loser_id', $winnerId);
            })
            ->where('game_date', '<', $result->game_date)
            ->orderBy('game_date', 'desc')
            ->first();
            
            if ($previousWinnerResult) {
                // 勝者か敗者かを判定
                if ($previousWinnerResult->winner_id == $winnerId) {
                    $role = 'winner'; // 勝者として記録
                    $winnerRate = $calcRateHelper->calcRate(
                        $previousWinnerResult->winner_rate,
                        $previousWinnerResult->loser_rate
                    )[0];
                } elseif ($previousWinnerResult->loser_id == $winnerId) {
                    $role = 'loser'; // 敗者として記録
                    $winnerRate = $calcRateHelper->calcRate(
                        $previousWinnerResult->winner_rate,
                        $previousWinnerResult->loser_rate
                    )[1];
                }
            } else {
                // 過去の対局がない場合は初期レート
                $role = null; // 対局履歴がない
                $winnerRate = Player::find($winnerId)->regist_rating;
            }
            
            dump($winnerId);
            dump($winnerRate);

            $previousLoserResult = Result::where(function ($query) use ($loserId) {
                $query->where('winner_id', $loserId)
                      ->orWhere('loser_id', $loserId);
            })
            ->where('game_date', '<', $result->game_date)
            ->orderBy('game_date', 'desc')
            ->first();
            
            if ($previousLoserResult) {
                // 敗者か勝者かを判定
                if ($previousLoserResult->winner_id == $loserId) {
                    $role = 'winner'; // 勝者として記録
                    $loserRate = $calcRateHelper->calcRate(
                        $previousLoserResult->winner_rate,
                        $previousLoserResult->loser_rate
                    )[0];
                } elseif ($previousLoserResult->loser_id == $loserId) {
                    $role = 'loser'; // 敗者として記録
                    $loserRate = $calcRateHelper->calcRate(
                        $previousLoserResult->winner_rate,
                        $previousLoserResult->loser_rate
                    )[1];
                }
            } else {
                // 過去の対局がない場合は初期レート
                $role = null; // 対局履歴がない
                $loserRate = Player::find($loserId)->regist_rating;
            }
            
            dump($loserId);
            dump($loserRate);
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
            
            $winner->save();

            $loser->rating = $newLoserRate;
            
            $loser->save();
        }

        return response()->json(['message' => 'レート計算が完了しました。']);
    }
}
