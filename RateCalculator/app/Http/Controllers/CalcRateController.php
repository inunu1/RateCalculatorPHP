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
        // よくわからんSQL流す、これで現在断面の各プレイヤーのレートを取る
        $trueResults = DB::select(createGetCurrentRateSql());
        dump($trueResults);
        

    }
}
