<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    //会員登録画面に遷移するメソッド
    public function showCreateForm()
    {
        return view('players/create');
    }
}
