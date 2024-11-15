<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'first_name','last_name','rating','regist_rating','registered_at','updated_at','calcrate_flag'
    ];

    protected $casts = [
        'calcrate_flag' => 'boolean',
        'registered_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    //Playerテーブルは多くの対局結果をつかさどる
    public function resultAsWinner()
    {
        return $this->hasMany(Result::class, 'winner_id');
    }
    
    public function resultAsLoser()
    {
        return $this->hasMany(Result::class, 'loser_id');
    }
}
