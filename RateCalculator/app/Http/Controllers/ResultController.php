<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;

class ResultController extends Controller
{
    //対局結果管理画面を表示するメソッド
    public function showIndex()
    {
        //管理画面にプレイヤーを全件表示
        $results = Result::all();

        //return view('results/index');
        return view('results/index', ['results' =>$results]);
    } 

    //会員登録画面に遷移するメソッド
    public function showCreateForm()
    {
        return view('results/create');
    }
}
