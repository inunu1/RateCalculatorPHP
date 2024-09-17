<?php

use App\Http\Controllers\TestController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerController;

//test画面を追加してみた
Route::get('/test', [TestController::class, 'test'])->name('test');

//会員管理画面用
Route::get('/players/Manage', [PlayerController::class, 'showManage'])->name('players.manage');

//会員登録画面用
Route::post('/player/store', [PlayerController::class, 'store'])->name('player.store');
Route::get('/player/create', [PlayerController::class, 'create'])->name('players.create');

//会員削除処理
Route::post('/players/{id}/delete', [PlayerController::class, 'delete'])->name('players.delete');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
