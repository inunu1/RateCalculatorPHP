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
        'calcrate_flag',
    ];

    //ResultテーブルはPlayerテーブルに従属する
    public function winner()
    {
        return $this->belongsTo(Player::class, 'winner_id');
    }
    
    public function loser()
    {
        return $this->belongsTo(Player::class, 'loser_id');
    }
}
