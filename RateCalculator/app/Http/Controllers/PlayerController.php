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

    //会員管理画面に遷移するメソッド
    public function showManage()
    {
        //管理画面にプレイヤーを全件表示
        $players = Player::all();

        return view('players/manage', ['players' =>$players]);
    } 
}

