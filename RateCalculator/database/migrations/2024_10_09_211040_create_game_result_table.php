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
        Schema::create('game_result', function (Blueprint $table) {
            //対局ID
            $table->increments('id');
            //勝った人のID
            $table->integer('winner_id');
            //負けた人のID
            $table->integer('loser_id');
            //対局日
            table->datetime('game_date');
            //発生レート
            $table->integer('shift_rate');
            //レーティング計算フラグ
            $table->boolean('calcrate_flag')->default(false);
            //登録日と更新日
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_result');
    }
};
