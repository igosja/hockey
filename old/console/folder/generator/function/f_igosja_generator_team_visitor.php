<?php

/**
 * Оновлюємо рейтинг відвідуваності команд
 */
function f_igosja_generator_team_visitor()
{
    $sql = "SELECT `team_id`
            FROM `team`
            WHERE `team_id`!=0";
    $team_sql = f_igosja_mysqli_query($sql);

    $team_array = $team_sql->fetch_all(MYSQLI_ASSOC);

    foreach ($team_array as $item)
    {
        $team_id = $item['team_id'];

        $sql = "SELECT IF(COUNT(`teamvisitor_visitor`)=0, 1, COUNT(`teamvisitor_visitor`)) AS `count`,
                       IF(SUM(`teamvisitor_visitor`) IS NULL, 1, SUM(`teamvisitor_visitor`)) AS `visitor`
                FROM
                (
                    SELECT `teamvisitor_visitor`
                    FROM `teamvisitor`
                    WHERE `teamvisitor_team_id`=$team_id
                    ORDER BY `teamvisitor_id` DESC
                    LIMIT 5
                ) AS `t1`";
        $visitor_sql = f_igosja_mysqli_query($sql);

        $visitor_array = $visitor_sql->fetch_all(MYSQLI_ASSOC);

        $visitor = $visitor_array[0]['visitor'] / $visitor_array[0]['count'] * 100;

        $sql = "UPDATE `team`
                SET `team_visitor`=$visitor
                WHERE `team_id`=$team_id
                LIMIT 1";
        f_igosja_mysqli_query($sql);
    }
}