<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    // 一括割り当てを許可するフィールド
    protected $fillable = [
        'winner_id',
        'loser_id',
        'winner_rate',
        'loser_rate',
        'game_date',
        'rating_calculated',
    ];
}
