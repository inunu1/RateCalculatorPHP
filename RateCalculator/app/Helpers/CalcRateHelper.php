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
        // calcrate_flagがtrueのレコードを古いgame_date順に取得
        $trueResults= Result::where('calcrate_flag', true)->orderBy('game_date', 'asc')->get();
        
        // calcrate_flagがfalseのレコードを古いgame_date順に取得
        $falseResults= Result::where('calcrate_flag', false)->orderBy('game_date', 'asc')->get();

        // $trueResultsの中のwinner_idとloser_idをそれぞれ抽出
        $trueResultIds = $trueResults->pluck('winner_id')->merge($trueResults->pluck('loser_id'))->unique();

        // $falseResultsの中のwinner_idとloser_idをそれぞれ抽出
        $falseResultIds = $falseResults->pluck('winner_id')->merge($falseResults->pluck('loser_id'))->unique();
    
        // 古い順にループでレーティング計算を実行
        foreach ($falseResults as $result) {

            //勝者のidが計算済みのレコードに存在するか判定
            if ($trueResultIds->contains($result->winner_id)){

            }

            //敗者のidが計算済みのレコードに存在するか判定
            if ($trueResultIds->contains($result->winner_id)){

            }

            // 勝者と敗者のレーティングを計算
            $calcResult = $this->calculateNewRatings($result->winner_id, $result->winner_rate, $result->loser_id, $result->loser_rate);
            
            // プレイヤーのレーティングを更新
            $this->updatePlayerRating($result->winner_id, $calcResult['winner']);
            $this->updatePlayerRating($result->loser_id, $calcResult['loser']);

            // 対局結果のレーティング計算フラグを更新
            $result->calcrate_flag = true;
            $result->winner_rate = $calcResult['winner'];
            $result->loser_rate = $calcResult['loser'];
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
            // $player->rating = $newRating;  // レーティングを更新
            $player->save();
        }
    }

    //引数の対局時点の両対局者のレーティングをもとに対局後の両対局者のレーティングを返す関数
    private function calcNewRate($winnerActualRate,$loserActualRate)
    {
        return $oldRating + $this->kFactor * ($actualScore - $expectedScore);
    }

    // 期待されるスコアを計算
    private function getExpectedScore($rating1, $rating2)
    {
        return 1 / (1 + pow(10, ($rating2 - $rating1) / 400));
    }

    // 期待されるスコアを計算
    public function createGetCurrentRateSql()
    {   
        return "SELECT players.id AS player_id, COALESCE(ranked_rates.latest_rate, players.rating) AS latest_rate"
        ."FROM players LEFT JOIN(SELECT player_id,
            rate AS latest_rate,
            ROW_NUMBER() OVER(
            PARTITION BY player_id
        ORDER BY
            game_date
        DESC
        ) AS rn
    FROM
        (
        SELECT
            winner_id AS player_id,
            winner_rate AS rate,
            game_date
        FROM
            results
        WHERE
            game_date < '2024-11-01 03:00:00' AND calcrate_flag = FALSE
        UNION ALL
    SELECT
        loser_id AS player_id,
        loser_rate AS rate,
        game_date
    FROM
        results
    WHERE
        game_date < '2024-11-01 03:00:00' AND calcrate_flag = FALSE
    ) AS combined_rates) AS ranked_rates
        ON
            players.id = ranked_rates.player_id AND ranked_rates.rn = 1
        ORDER BY
            players.id;";
    }
}
