<?php

namespace App\Helpers;
use App\Models\Result;
use App\Models\Player;

class CalcRateHelper
{
    public function calcRate($winner_rate, $loser_rate)
    {
        // K係数（レーティング変動の大きさを調整）
        $kFactor = 32;

        // 勝者の期待勝率を計算
        $expectedWinRateWinner = 1 / (1 + pow(10, ($loser_rate - $winner_rate) / 400));

        // 敗者の期待勝率を計算
        $expectedWinRateLoser = 1 / (1 + pow(10, ($winner_rate - $loser_rate) / 400));

        // 勝者と敗者の新しいレーティングを計算
        $new_winner_rate = $winner_rate + $kFactor * (1 - $expectedWinRateWinner);
        $new_loser_rate = $loser_rate + $kFactor * (0 - $expectedWinRateLoser);

        // 小数点を四捨五入して整数にする
        return [round($new_winner_rate), round($new_loser_rate)];
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
            calcrate_flag = FALSE
        UNION ALL
    SELECT
        loser_id AS player_id,
        loser_rate AS rate,
        game_date
    FROM
        results
    WHERE
        calcrate_flag = FALSE
    ) AS combined_rates) AS ranked_rates
        ON
            players.id = ranked_rates.player_id AND ranked_rates.rn = 1
        ORDER BY
            players.id";
    }
}
