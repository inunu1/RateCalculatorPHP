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
        $calcRateHelper = New CalcRateHelper;
        // レート未計算の対局を行った各プレイヤー計算開始時点のレートを取る
        $results = DB::select($calcRateHelper->createGetCurrentRateSql());
        
 
        // 未計算の対局結果を取得する、これで作った配列に計算結果を当て込んでく
        $falseResults = Result::where('calcrate_flag','=', false);
        dump($falseResults);
 
        // 未計算の対局結果を1件ずつ計算する
        foreach ($falseResults as $falseResult){
            // レーティング計算前情報の取得
            $winner_rate = $results[$winner_id];
            $loser_rate = $results[$loser_id];
            $falseResult -> winner_rate = $winner_rate;
            $falseResult -> loser_rate = $loser_rate;
            $falseResult -> calcrate_flag = true;
            
            // レーティング計算前情報の保存
            $falseResult -> save();
 
            // レーティング計算実施処理
            $calcRateHelper->calcRate($winner_rate, $loser_rate);
            
            // 連想配列の計算結果を最新のレートに更新
            $results[$winner_id] = $winner_rate;
            $results[$loser_id] = $loser_rate;
        }
 
        // Playerテーブルから、レート計算をしたプレイヤーのエンティティを取得
        $players = Player::whereIn('id', array_keys($results))->get();
 
        // playersのレートを、最新レート$resultsで更新する
        foreach ($players as $player){
            $player->rating = $results[$player->id];
            $player->save();
        }
 
        // リダイレクトする
        $result = Result::find($id);
 
        return view('results/edit', ['result' =>$result]);
    }
}