<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResultController extends Controller
{
    //対局結果管理画面を表示するメソッド
    public function showIndex()
    {
        //管理画面にプレイヤーを全件表示
        //$results = Result::all();

        return view('results/index');
    } 
}
