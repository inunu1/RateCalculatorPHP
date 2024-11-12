<?php

namespace App\Helpers;

use App\Models\Result;
use App\Models\Player;

class CalcRateHelper
{
    private $kFactor = 32;  // K係数（レーティング計算で使用）

    // レーティング計算を実行
    public function calcRate()
    {
        // レーティング計算フラグが false の対局結果を取得
        $results = Result::where('calcrate_flag', false)->get();

        // ループでレーティング計算を実行
        foreach ($results as $result) {
            // 勝者と敗者のレーティングを計算
            $calcResult = $this->calculateNewRatings($result->winner_id, $result->winner_rate, $result->loser_id, $result->loser_rate);
            
            // プレイヤーのレーティングを更新
            $this->updatePlayerRating($result->winner_id, $calcResult['winner']);
            $this->updatePlayerRating($result->loser_id, $calcResult['loser']);

            // 対局結果のレーティング計算フラグを更新
            $result->calcrate_flag = true;
            $result->save();
        }
    }

    // 勝者と敗者の新しいレーティングを計算
    private function calculateNewRatings($winner_id, $winner_rate, $loser_id, $loser_rate)
    {
        // 期待スコアを計算
        $expectedWinnerScore = $this->getExpectedScore($winner_rate, $loser_rate);
        $expectedLoserScore = 1 - $expectedWinnerScore;

        // 新しいレーティングを計算
        $newWinnerRating = $this->calculateNewRating($winner_rate, 1, $expectedWinnerScore);
        $newLoserRating = $this->calculateNewRating($loser_rate, 0, $expectedLoserScore);

        return [
            'winner' => round($newWinnerRating),
            'loser'  => round($newLoserRating)
        ];
    }

    // プレイヤーのレーティングを更新
    private function updatePlayerRating($player_id, $newRating)
    {
        $player = Player::find($player_id);
        if ($player) {
            $player->rating = $newRating;  // レーティングを更新
            $player->save();
        }
    }

    // レーティングを計算
    private function calculateNewRating($oldRating, $actualScore, $expectedScore)
    {
        return $oldRating + $this->kFactor * ($actualScore - $expectedScore);
    }

    // 期待されるスコアを計算
    private function getExpectedScore($rating1, $rating2)
    {
        return 1 / (1 + pow(10, ($rating2 - $rating1) / 400));
    }
}
