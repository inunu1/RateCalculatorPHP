<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Player;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Player::truncate();
        
        $now = Carbon::now();
        //$formattedDate = $now->format('YmdHis');
        
        $lastNames = ['秀生', '智之', '秀介'];
        $firstNames = ['緒方', '今井', '福井'];
        $rates = array(2500, 3000, 2000);
        
        for ($i = 1; $i <= 3; $i++) {
            DB::table('players')->insert([
                'id' => $i,
                'last_name' => $lastNames[$i-1],
                'first_name' => $firstNames[$i-1],
                'rating' => $rates[$i-1],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
