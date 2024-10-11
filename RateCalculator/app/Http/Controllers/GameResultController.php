<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameResult extends Controller
{
    //会員登録画面に遷移するメソッド
    public function showCreateForm()
    {
        return view('results/create');
    }

    //会員登録時に動くメソッド
    public function create(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'winner_id' => 'required|integer',
            'loser_id' => 'required|integer',
            'game_date' => 'required|datetime',
        ]);

        // データの保存
        GameResult::create($validatedData);

        return redirect()->route('results.create')->with('success', '対局結果が登録されました。');
    }

    //会員管理画面に遷移するメソッド
    public function showIndex()
    {
        //管理画面にプレイヤーを全件表示
        $results = GameResult::all();

        return view('results/index', ['results' =>$results]);
    } 

    //会員削除処理
    public function delete(int $id)
    {
        $result = GameResult::find($id);

        $result->delete();

        return redirect()->route('results.index')->with('success', '会員を削除しました。');
    }

    //会員情報更新処理
    public function edit(int $id)
    {
        $result = GameResult::find($id);

        return view('results/edit', ['result' =>$result]);
    }

    //
    public function update(int $id,Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'winner_id' => 'required|integer',
            'loser_id' => 'required|integer',
            'game_date' => 'required|datetime',
        ]);

        $result = GameResult::find($id);
        $result->last_name = $request ->last_name;
        $result->first_name = $request ->first_name; 
        $result->rating = $request ->rating;

        //データの保存
        $result->update();

        return redirect()->route('results.edit',['id'=>$id])->with('success', '会員情報を更新しました。');
    }
}
