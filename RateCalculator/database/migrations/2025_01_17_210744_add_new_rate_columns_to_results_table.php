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
        Schema::table('results', function (Blueprint $table) {
            // 勝者の新しいレートを追加
            $table->integer('winner_new_rate')->after('loser_rate');
            // 敗者の新しいレートを追加
            $table->integer('loser_new_rate')->after('winner_new_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('results', function (Blueprint $table) {
            // 追加した列を削除
            $table->dropColumn(['winner_new_rate', 'loser_new_rate']);
        });
    }
};
