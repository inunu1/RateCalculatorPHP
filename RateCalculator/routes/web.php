<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;


// Test画面
Route::get('/test', [TestController::class, 'test'])->name('test');

// 会員管理関連のルーティング
Route::prefix('players')->group(function () {
    Route::get('index', [PlayerController::class, 'showIndex'])->name('players.index');
    Route::get('create', [PlayerController::class, 'showCreateForm'])->name('players.create');
    Route::post('store', [PlayerController::class, 'store'])->name('player.store');
    Route::get('{id}/edit', [PlayerController::class, 'edit'])->name('players.edit');
    Route::post('{id}/update', [PlayerController::class, 'update'])->name('players.update');
    Route::post('{id}/delete', [PlayerController::class, 'delete'])->name('players.delete');
});

// 対局管理関連のルーティング
Route::prefix('results')->group(function () {
    Route::get('index', [ResultController::class, 'showIndex'])->name('results.index');
    Route::get('create', [ResultController::class, 'showCreateForm'])->name('results.create');
    Route::post('store', [ResultController::class, 'store'])->name('results.store');
    Route::get('{id}/edit', [ResultController::class, 'edit'])->name('results.edit');
    Route::post('{id}/update', [ResultController::class, 'update'])->name('results.update');
    Route::post('{id}/delete', [ResultController::class, 'delete'])->name('results.delete');
});

// ホーム画面
Route::get('/', function () {
    return view('welcome');
});

// ダッシュボード
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証ユーザー用のプロフィール関連ルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証関連のルート
require __DIR__.'/auth.php';
