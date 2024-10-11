<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    //会員登録画面に遷移するメソッド
    public function showCreateForm()
    {
        return view('players/create');
    }

    //会員登録時に動くメソッド
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'rating' => 'required|integer',
        ]);

        // データの保存
        Player::create($validatedData);

        return redirect()->route('players.create')->with('success', '会員が登録されました。');
    }

    //会員管理画面に遷移するメソッド
    public function showIndex()
    {
        //管理画面にプレイヤーを全件表示
        $players = Player::all();

        return view('players/index', ['players' =>$players]);
    } 

    //会員削除処理
    public function delete(int $id)
    {
        $player = Player::find($id);

        $player->delete();

        return redirect()->route('players.index')->with('success', '会員を削除しました。');
    }

    //会員情報更新処理
    public function edit(int $id)
    {
        $player = Player::find($id);

        return view('players/edit', ['player' =>$player]);
    }

    //
    public function update(int $id,Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'rating' => 'required|integer',
        ]);

        $player = Player::find($id);
        $player->last_name = $request ->last_name;
        $player->first_name = $request ->first_name; 
        $player->rating = $request ->rating;

        //データの保存
        $player->update();

        return redirect()->route('players.edit',['id'=>$id])->with('success', '会員情報を更新しました。');
    }
}

