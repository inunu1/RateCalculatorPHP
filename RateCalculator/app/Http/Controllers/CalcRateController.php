<?php

namespace App\Http\Controllers;

use App\Helpers\CalcRateHelper;
use Illuminate\Http\Request;
use App\Models\Player;

class CalcRateController extends Controller
{
    // レーティング計算処理
    public function index()
    {
        // CalcRateHelperを使ってレーティング計算を実行
        $calcRateHelper = new CalcRateHelper();
        $calcRateHelper->calcRate();

        //管理画面にプレイヤーを全件表示
        $players = Player::all();
        //管理画面にリダイレクト
        return view('players/index', ['players' =>$players]);
    }
}
