<?php

namespace App\Http\Controllers;

use App\Helpers\CalcRateHelper;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Result;
use Illuminate\Support\Facades\DB;

class CalcRateController extends Controller
{
    // レーティング計算処理
    public function index()
    {
        // CalcRateHelperクラスのインスタンスを生成
        $calcRateHelper = new CalcRateHelper();

        // レート未計算の対局を行った各プレイヤー計算開始時点のレートを取得
        $dbResults = DB::select($calcRateHelper->createGetCurrentRateSql());

        // プレイヤーIDをキーにした連想配列に変換
        $results = [];
        foreach ($dbResults as $row) {
            $results[$row->player_id] = $row->latest_rate;
        }

        // 未計算の対局結果を取得する
        $falseResults = Result::where('calcrate_flag', false)->get();

        // 未計算の対局結果を1件ずつ計算する
        foreach ($falseResults as $falseResult) {
            // 勝者と敗者のIDを取得
            $winner_id = $falseResult->winner_id;
            $loser_id = $falseResult->loser_id;

            // 勝者と敗者のレートを取得
            $winner_rate = $results[$winner_id] ?? Player::find($winner_id)->rating;
            $loser_rate = $results[$loser_id] ?? Player::find($loser_id)->rating;

            // レーティング計算実施
            list($new_winner_rate, $new_loser_rate) = $calcRateHelper->calcRate($winner_rate, $loser_rate);

            // 対局結果に計算結果を保存
            $falseResult->winner_rate = $new_winner_rate;
            $falseResult->loser_rate = $new_loser_rate;
            $falseResult->calcrate_flag = true;
            //$falseResult->save();

            // 最新のレートを連想配列に更新
            $results[$winner_id] = $new_winner_rate;
            $results[$loser_id] = $new_loser_rate;
        }

        // Playerテーブルから、レート計算をしたプレイヤーのエンティティを取得
        $players = Player::whereIn('id', array_keys($results))->get();

        // playersのレートを最新レートで更新
        foreach ($players as $player) {
            $player->rating = $results[$player->id];
            $player->save();
        }

        // リダイレクトする
        return redirect()->route('results.index')->with('success', 'レーティング計算が完了しました。');
    }
}
