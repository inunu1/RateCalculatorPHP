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
        //管理画面にプレイヤーを全件表示
        $results = Result::all();

        //return view('results/index');
        return view('results/index', ['results' =>$results]);
    } 

    //会員登録画面に遷移するメソッド
    public function showCreateForm()
    {
        return view('results/create');
    }

    //会員登録時に動くメソッド
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'winner_id' => 'required|string|max:255',
            'loser_id'  => 'required|string|max:255',
            'game_date' => 'required|date',
        ]);

        // 勝者と敗者のレーティングを取得
        $winner = Player::find($validatedData['winner_id']);
        $loser = Player::find($validatedData['loser_id']);

        // 結果を保存
        Result::create([
            'winner_id' => $validatedData['winner_id'],
            'loser_id'  => $validatedData['loser_id'],
            'winner_rate' => $winner->rating,           // 勝者のレート
            'loser_rate'  => $loser->rating,            // 敗者のレート
            'game_date'   => $validatedData['game_date'],   // 対局日時
            'calcrate_flag' => false,                   // 初期はレーティング計算未
        ]);

        return redirect()->route('players.create')->with('success', '会員が登録されました。');
    }
}
