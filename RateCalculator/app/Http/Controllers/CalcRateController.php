<?php

namespace App\Http\Controllers;

use App\Helpers\CalcRateHelper;
use Illuminate\Http\Request;

class CalcRateController extends Controller
{
    // レーティング計算処理
    public function index()
    {
        // CalcRateHelperを使ってレーティング計算を実行
        $calcRateHelper = new CalcRateHelper();
        $calcRateHelper->calcRate();

        // レーティング計算後にビューを返す（適宜ビュー名を設定）
        return view('dashboard');
    }
}
