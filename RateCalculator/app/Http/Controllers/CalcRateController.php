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
            $results[$row->player_id] = [
            'latest_rate' => $row->latest_rate,
            'has_game_experience' => boolval($row->has_game_experience)
            ];
        }

        // 未計算の対局結果を取得する
        $falseResults = Result::where('calcrate_flag', false)->get();

        // 未計算の対局結果を1件ずつ計算する
        foreach ($falseResults as $falseResult) {
            dump($falseResult->id);
            // 勝者と敗者のIDを取得
            $winner_id = $falseResult->winner_id;
            $loser_id = $falseResult->loser_id;
        
            // 勝者と敗者のレートを取得
            $winner_rate = $results[$winner_id]['latest_rate'] ?? Player::find($winner_id)->rating;
            $loser_rate = $results[$loser_id]['latest_rate'] ?? Player::find($loser_id)->rating;
        
            // フラグを取得
            $winner_has_experience = $results[$winner_id]['has_game_experience'] ?? false;
            dump($winner_has_experience);
            $loser_has_experience = $results[$loser_id]['has_game_experience'] ?? false;
            dump($loser_has_experience);
            //レーティング計算開始断面時点の勝者側が過去に対局してた場合
            if ($winner_has_experience) {
                //過去の対局からレーティング計算開始断面の勝者にとってひとつ前の対局結果を一行取得する
                $targetResultId = $falseResult->id; // 対象の対局IDを指定

                $previousResult = DB::table('results as r1')
                    ->join('results as r2', 'r1.winner_id', '=', 'r2.winner_id')
                    ->where('r1.id', '=', $targetResultId)
                    ->where('r2.game_date', '<', DB::raw('(SELECT game_date FROM results WHERE id = ' . $targetResultId . ')'))
                    ->orderBy('r2.game_date', 'desc')
                    ->select('r2.*')
                    ->first();
                dump($previousResult);
                //ひとつ前の対局結果からR計算し現在のR断面を出す
                list($new_winner_rate, $new_loser_rate) = $calcRateHelper->calcRate($previousResult->winner_rate, $previousResult->loser_rate);
                
                list($new_winner_rate, $new_loser_rate) = $calcRateHelper->calcRate($new_winner_rate, $loser_rate);
                
                $falseResult->winner_rate = $new_winner_rate;
            } else {
                // 初対戦の場合はレート計算結果を保存する（必要に応じて意図を調整）
                list($new_winner_rate, $new_loser_rate) = $calcRateHelper->calcRate($winner_rate, $loser_rate);
                $falseResult->winner_rate = $new_winner_rate;
            }
            
            //レーティング計算開始断面時点の敗者側が過去に対局してた場合
            if ($loser_has_experience) {
                $targetResultId = $falseResult->id; // 対象の対局IDを指定

                $previousResult = DB::table('results as r1')
                    ->join('results as r2', 'r1.loser_id', '=', 'r2.loser_id')
                    ->where('r1.id', '=', $targetResultId)
                    ->where('r2.game_date', '<', DB::raw('(SELECT game_date FROM results WHERE id = ' . $targetResultId . ')'))
                    ->orderBy('r2.game_date', 'desc')
                    ->select('r2.*')
                    ->first();
                dump($previousResult);
                list($new_winner_rate, $new_loser_rate) = $calcRateHelper->calcRate($previousResult->winner_rate, $previousResult->loser_rate);
                
                list($new_winner_rate, $new_loser_rate) = $calcRateHelper->calcRate($winner_rate, $new_loser_rate);
                
                $falseResult->loser_rate = $new_loser_rate;
            } else {
                // 初対戦の場合も計算結果を保存する
                $falseResult->loser_rate = $new_loser_rate;
            }

            $falseResult->calcrate_flag = true;
            $falseResult->save();
        
            // 最新のレートを連想配列に更新
            $results[$winner_id]['latest_rate'] = $new_winner_rate;
            $results[$loser_id]['latest_rate'] = $new_loser_rate;
        
            // フラグを保持
            $results[$winner_id]['has_game_experience'] = true;
            $results[$loser_id]['has_game_experience'] = true;
        }

        // Playerテーブルから、レート計算をしたプレイヤーのエンティティを取得
        $players = Player::whereIn('id', array_keys($results))->get();

        // playersのレートを最新レートで更新
        foreach ($players as $player) {
            if (isset($results[$player->id])) {
                $player->rating = $results[$player->id]['latest_rate']; // 配列から整数値を取得
                $player->save();
            }
        }

        // リダイレクトする
        //return redirect()->route('results.index')->with('success', 'レーティング計算が完了しました。');
    }
}
