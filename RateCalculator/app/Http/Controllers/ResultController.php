<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Player;

class ResultController extends Controller
{
    //対局結果管理画面を表示するメソッド
    public function showIndex()
    {
        //管理画面にプレイヤーを全件表示するために勝者と敗者で内部結合する
        $query = Result::with(['winner','loser']);

        $results = $query->get();

        //return view('results/index');
        return view('results/index', ['results' =>$results]);
    } 

    //対局結果登録画面に遷移するメソッド
    public function showCreateForm()
    {
        return view('results/create');
    }

    //対局結果登録時に動くメソッド
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'winner_id' => 'required|integer',
            'loser_id'  => 'required|integer',
            'game_date' => 'required|date',
        ]);

        // 勝者と敗者のレーティングを取得
        $winner = Player::find($validatedData['winner_id']);
        $loser = Player::find($validatedData['loser_id']);

        // 結果を保存
        Result::create([
            'winner_id' => $validatedData['winner_id'],
            'loser_id'  => $validatedData['loser_id'],
            'winner_rate' => $winner->rating,               // 勝者のレート
            'loser_rate'  => $loser->rating,                // 敗者のレート
            'winner_new_rate' => 2000,               // 勝者のレート
            'loser_new_rate'  => 2000,                // 敗者のレート
            'game_date'   => $validatedData['game_date'],   // 対局日時
            'calcrate_flag' => false,                       // 初期はレーティング計算未
        ]);

        // 編集した対局日時より後に行われた対局のレート計算フラグをすべてfalseに
        Result::where('game_date', '>=', $request->game_date)->update(['calcrate_flag' => false]);

        return redirect()->route('results.create')->with('success', '対局結果が登録されました');
    }

    //対局結果更新画面遷移処理
    public function edit(int $id)
    {
        $result = Result::find($id);

        return view('results/edit', ['result' =>$result]);
    }

    //対局結果更新保存処理
    public function update(int $id,Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'winner_id' => 'required|integer',
            'loser_id'  => 'required|integer',
            'game_date' => 'required|date',
        ]);
        // リクエストで飛んできた対局結果idで対局結果を抽出
        $result = Result::find($id);
        // 対局結果テーブルのwinner_idをリクエストで飛んできたものに
        $result->winner_id = $request ->winner_id;
        // 対局結果テーブルのloser_idをリクエストで飛んできたものに
        $result->loser_id = $request ->loser_id; 
        // 対局日時をリクエストで飛んできたものに
        $result->game_date = $request ->game_date;
        // レート計算フラグを未計算に
        $result->calcrate_flag = false;
        // データの保存
        $result->update();
        // 編集した対局日時より後に行われた対局のレート計算フラグをすべてfalseに
        Result::where('game_date', '>=', $result->game_date)->update(['calcrate_flag' => false]);

        return redirect()->route('results.edit',['id'=>$id])->with('success', '対局結果を更新しました。');
    }
}
