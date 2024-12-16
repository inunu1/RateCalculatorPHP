<?php

namespace App\Helpers;
use App\Models\Result;
use App\Models\Player;

class CalcRateHelper
{
    public function calcRate($winner_rate, $loser_rate)
    {
        // 1500, 1500 を返す処理を修正
        return [$winner_rate + 10, $loser_rate - 10];
    }


    // エイヤでレート未計算の対局の各対局者の計算開始時点のレートを取得する
    public function createGetCurrentRateSql()
    {   
        return "SELECT
        players.id AS player_id,
        COALESCE(ranked_rates.latest_rate, players.rating) AS latest_rate
    FROM
        players
    LEFT JOIN(
        SELECT player_id,
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
            players.id";
    }
}
