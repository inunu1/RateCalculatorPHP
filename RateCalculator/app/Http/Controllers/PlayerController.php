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
    public function create(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
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
    public function update(int $id)
    {
        $player = Player::find($id);

        return view('players/update', ['players' =>$players]);
    }
}

