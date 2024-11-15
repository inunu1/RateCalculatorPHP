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
        Schema::create('players', function (Blueprint $table) {
            //会員id
            $table->increments('id');
            //姓
            $table->string('last_name',20);
            //名
            $table->string('first_name',20);
            //レーティング
            $table->integer('rating');
            //登録時レーティング
            $table->integer('regist_rating');
            //登録日と更新日
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
