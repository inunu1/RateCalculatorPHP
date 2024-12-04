<?php

namespace App\Http\Controllers;

use App\Helpers\CalcRateHelper;
use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Result;
use Illuminate\Support\Facades\DB;

class CalcRateController extends Controller
{
    // レーティング計算処理
    public function index()
    {
        // にゅーする
        $calcRateHelper = New CalcRateHelper;
        // よくわからんSQL流す、これで現在断面の各プレイヤーのレートを取る
        $Results = DB::select($calcRateHelper->createGetCurrentRateSql());
        dump($Results);

        // 計算済みの対局結果を取得する
        

    }
}
