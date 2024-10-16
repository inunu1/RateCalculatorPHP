<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('results', function (Blueprint $table) {
            //対局結果のid
            $table->increments('id');
            //勝った人のid
            $table->string('winner_id');
            //負けた人のid
            $table->string('loser_id');
            //勝者の対局時のレート
            $table->integer('winner_rate');
            //敗者の対局時のレート
            $table->integer('loser_rate');
            //対局日時
            $table->datetime('game_date');
            //レーティング計算フラグ（trueで計算済み）
            $table->boolean('calcrate_flag')->default(false);
            //登録日列と更新日列
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('results');
    }
};
