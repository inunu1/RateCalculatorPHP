<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Player;

class CalcRateHelper 
{
    private $kFactor = 32;

    public function calcRate()
    {
        // 対局結果を全件取得
        $results = Result::all();

        // $calcResultsを初期化
        $calcResults = [];

        // ループする
        foreach ($results as $result) {
            // 実際の計算処理呼ぶ
            $calcResult = $this->calculateNewRatings($result->winner_id, $result->winner_rate, $result->loser_id, $result->loser_rate);
            
            $calcResults = array_merge($calcResults, $calcResult);
        }

        // calcResultsの中のキーだけ取る
        $resultKeys = array_keys($calcResults);

        $players = Player::whereIn('id', $resultKeys)->get();
        foreach ($players as $player) {
            $player->rating = $calcResults[$player->id];
            $player->update();
        }
    }

    private function calculateNewRatings($winner_id, $winner_rate, $loser_id, $loser_rate) {
        $expectedScore1 = $this->getExpectedScore($winner_rate, $loser_rate);
        $expectedScore2 = 1 - $expectedScore1;

        $newRating1 = $this->calculateNewRating($winner_rate, 1, $expectedScore1);
        $newRating2 = $this->calculateNewRating($loser_rate, 0, $expectedScore2);

        return [
            $winner_id => round($newRating1),
            $loser_id => round($newRating2)
        ];
    }

    private function getExpectedScore($rating1, $rating2) {
        return 1 / (1 + pow(10, ($rating2 - $rating1) / 400));
    }

    private function calculateNewRating($oldRating, $actualScore, $expectedScore) {
        return $oldRating + $this->kFactor * ($actualScore - $expectedScore);
    }
}
