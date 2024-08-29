<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [
        'last_name', 'first_name', 'rating', 'registered_at', 'updated_at', 'calcrate_flag'
    ];

    protected $casts = [
        'calcrate_flag' => 'boolean',
        'registered_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
