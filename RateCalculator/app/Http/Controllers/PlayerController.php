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

    //会員登録完了画面に遷移するメソッド
    public function store(Request $request)
    {
        // バリデーション
        $validatedData = $request->validate([
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'rating' => 'required|integer',
            'calcrate_flag' => 'nullable|boolean',
        ]);

        // データの保存
        Player::create($validatedData);

        return redirect()->route('player.create')->with('success', '会員が登録されました。');
    }

    //会員管理画面に遷移するメソッド
    public function showManage()
    {
        //管理画面にプレイヤーを全件表示
        $players = Player::all();

        return view('players/manage', ['players' =>$players]);
    } 
}

