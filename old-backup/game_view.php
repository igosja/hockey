<?php

/**
 * @var $auth_date_block_gamecomment integer
 * @var $auth_date_block_comment integer
 * @var $auth_user_id integer
 */

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `championship_country_id`,
               `championship_division_id`,
               `game_guest_auto`,
               `game_guest_forecast`,
               `game_guest_optimality_1`,
               `game_guest_optimality_2`,
               `game_guest_penalty`,
               `game_guest_penalty_1`,
               `game_guest_penalty_2`,
               `game_guest_penalty_3`,
               `game_guest_penalty_over`,
               `game_guest_power`,
               `game_guest_power_percent`,
               `game_guest_score`,
               `game_guest_score_1`,
               `game_guest_score_2`,
               `game_guest_score_3`,
               `game_guest_score_over`,
               `game_guest_score_bullet`,
               `game_guest_shot`,
               `game_guest_shot_1`,
               `game_guest_shot_2`,
               `game_guest_shot_3`,
               `game_guest_shot_over`,
               `game_guest_style_1_id`,
               `game_guest_style_2_id`,
               `game_guest_style_3_id`,
               `game_guest_teamwork_1`,
               `game_guest_teamwork_2`,
               `game_guest_teamwork_3`,
               `game_home_auto`,
               `game_home_forecast`,
               `game_home_optimality_1`,
               `game_home_optimality_2`,
               `game_home_penalty`,
               `game_home_penalty_1`,
               `game_home_penalty_2`,
               `game_home_penalty_3`,
               `game_home_penalty_over`,
               `game_home_power`,
               `game_home_power_percent`,
               `game_home_score`,
               `game_home_score_1`,
               `game_home_score_2`,
               `game_home_score_3`,
               `game_home_score_over`,
               `game_home_score_bullet`,
               `game_home_shot`,
               `game_home_shot_1`,
               `game_home_shot_2`,
               `game_home_shot_3`,
               `game_home_shot_over`,
               `game_home_style_1_id`,
               `game_home_style_2_id`,
               `game_home_style_3_id`,
               `game_home_teamwork_1`,
               `game_home_teamwork_2`,
               `game_home_teamwork_3`,
               `game_played`,
               `game_stadium_capacity`,
               `game_ticket`,
               `game_visitor`,
               `guest_mood`.`mood_id` AS `guest_mood_id`,
               `guest_mood`.`mood_name` AS `guest_mood_name`,
               `guest_national`.`national_id` AS `guest_national_id`,
               `guest_country`.`country_name` AS `guest_national_name`,
               `guest_national`.`national_power_vs` AS `guest_national_power_vs`,
               `guest_rude_1`.`rude_name` AS `guest_rude_1_name`,
               `guest_rude_2`.`rude_name` AS `guest_rude_2_name`,
               `guest_rude_3`.`rude_name` AS `guest_rude_3_name`,
               `guest_style_1`.`style_name` AS `guest_style_1_name`,
               `guest_style_2`.`style_name` AS `guest_style_2_name`,
               `guest_style_3`.`style_name` AS `guest_style_3_name`,
               `guest_tactic_1`.`tactic_name` AS `guest_tactic_1_name`,
               `guest_tactic_2`.`tactic_name` AS `guest_tactic_2_name`,
               `guest_tactic_3`.`tactic_name` AS `guest_tactic_3_name`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_mood`.`mood_id` AS `home_mood_id`,
               `home_mood`.`mood_name` AS `home_mood_name`,
               `home_national`.`national_id` AS `home_national_id`,
               `home_country`.`country_name` AS `home_national_name`,
               `home_national`.`national_power_vs` AS `home_national_power_vs`,
               `home_rude_1`.`rude_name` AS `home_rude_1_name`,
               `home_rude_2`.`rude_name` AS `home_rude_2_name`,
               `home_rude_3`.`rude_name` AS `home_rude_3_name`,
               `home_style_1`.`style_name` AS `home_style_1_name`,
               `home_style_2`.`style_name` AS `home_style_2_name`,
               `home_style_3`.`style_name` AS `home_style_3_name`,
               `home_tactic_1`.`tactic_name` AS `home_tactic_1_name`,
               `home_tactic_2`.`tactic_name` AS `home_tactic_2_name`,
               `home_tactic_3`.`tactic_name` AS `home_tactic_3_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `schedule_date`,
               `schedule_season_id`,
               `stadium_name`,
               `stadium_team`.`team_id` AS `stadium_team_id`,
               `stage_id`,
               `stage_name`,
               `tournamenttype_id`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `national` AS `guest_national`
        ON `game_guest_national_id`=`guest_national`.`national_id`
        LEFT JOIN `country` AS `guest_country`
        ON `guest_national`.`national_country_id`=`guest_country`.`country_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `national` AS `home_national`
        ON `game_home_national_id`=`home_national`.`national_id`
        LEFT JOIN `country` AS `home_country`
        ON `home_national`.`national_country_id`=`home_country`.`country_id`
        LEFT JOIN `schedule`
        ON `game_schedule_id`=`schedule_id`
        LEFT JOIN `tournamenttype`
        ON `schedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `schedule_stage_id`=`stage_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `team` AS `stadium_team`
        ON `stadium_team`.`team_stadium_id`=`stadium_id`
        LEFT JOIN `mood` AS `guest_mood`
        ON `game_guest_mood_id`=`guest_mood`.`mood_id`
        LEFT JOIN `mood` AS `home_mood`
        ON `game_home_mood_id`=`home_mood`.`mood_id`
        LEFT JOIN `rude` AS `guest_rude_1`
        ON `game_guest_rude_1_id`=`guest_rude_1`.`rude_id`
        LEFT JOIN `rude` AS `guest_rude_2`
        ON `game_guest_rude_2_id`=`guest_rude_2`.`rude_id`
        LEFT JOIN `rude` AS `guest_rude_3`
        ON `game_guest_rude_3_id`=`guest_rude_3`.`rude_id`
        LEFT JOIN `rude` AS `home_rude_1`
        ON `game_home_rude_1_id`=`home_rude_1`.`rude_id`
        LEFT JOIN `rude` AS `home_rude_2`
        ON `game_home_rude_2_id`=`home_rude_2`.`rude_id`
        LEFT JOIN `rude` AS `home_rude_3`
        ON `game_home_rude_3_id`=`home_rude_3`.`rude_id`
        LEFT JOIN `style` AS `guest_style_1`
        ON `game_guest_style_1_id`=`guest_style_1`.`style_id`
        LEFT JOIN `style` AS `guest_style_2`
        ON `game_guest_style_2_id`=`guest_style_2`.`style_id`
        LEFT JOIN `style` AS `guest_style_3`
        ON `game_guest_style_3_id`=`guest_style_3`.`style_id`
        LEFT JOIN `style` AS `home_style_1`
        ON `game_home_style_1_id`=`home_style_1`.`style_id`
        LEFT JOIN `style` AS `home_style_2`
        ON `game_home_style_2_id`=`home_style_2`.`style_id`
        LEFT JOIN `style` AS `home_style_3`
        ON `game_home_style_3_id`=`home_style_3`.`style_id`
        LEFT JOIN `tactic` AS `guest_tactic_1`
        ON `game_guest_tactic_1_id`=`guest_tactic_1`.`tactic_id`
        LEFT JOIN `tactic` AS `guest_tactic_2`
        ON `game_guest_tactic_2_id`=`guest_tactic_2`.`tactic_id`
        LEFT JOIN `tactic` AS `guest_tactic_3`
        ON `game_guest_tactic_3_id`=`guest_tactic_3`.`tactic_id`
        LEFT JOIN `tactic` AS `home_tactic_1`
        ON `game_home_tactic_1_id`=`home_tactic_1`.`tactic_id`
        LEFT JOIN `tactic` AS `home_tactic_2`
        ON `game_home_tactic_2_id`=`home_tactic_2`.`tactic_id`
        LEFT JOIN `tactic` AS `home_tactic_3`
        ON `game_home_tactic_3_id`=`home_tactic_3`.`tactic_id`
        LEFT JOIN `championship`
        ON (`game_home_team_id`=`championship_team_id`
        AND `schedule_season_id`=`championship_season_id`)
        WHERE `game_id`=$num_get
        LIMIT 1";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(MYSQLI_ASSOC);

if (0 == $game_array[0]['game_played'])
{
    redirect('/game_preview.php?num=' . $num_get);
}

if ($data = f_igosja_request_post('data'))
{
    if (isset($auth_user_id) && isset($data['text']) && $auth_date_block_gamecomment < time() && $auth_date_block_comment < time())
    {
        $text = htmlspecialchars($data['text']);
        $text = trim($text);

        if (!empty($text))
        {
            $publish = true;

            $sql = "SELECT `gamecomment_text`,
                           `gamecomment_user_id`
                    FROM `gamecomment`
                    WHERE `gamecomment_game_id`=$num_get
                    ORDER BY `gamecomment_id` DESC
                    LIMIT 1";
            $check_sql = f_igosja_mysqli_query($sql);

            if (0 != $check_sql->num_rows)
            {
                $check_array = $check_sql->fetch_all(MYSQLI_ASSOC);

                if ($auth_user_id == $check_array[0]['gamecomment_user_id'] && $text == $check_array[0]['gamecomment_text'])
                {
                    $publish = false;
                }
            }

            if ($publish)
            {
                $sql = "INSERT INTO `gamecomment`
                        SET `gamecomment_date`=UNIX_TIMESTAMP(),
                            `gamecomment_game_id`=$num_get,
                            `gamecomment_text`=?,
                            `gamecomment_user_id`=$auth_user_id";
                $prepare = $mysqli->prepare($sql);
                $prepare->bind_param('s', $text);
                $prepare->execute();
                $prepare->close();

                f_igosja_session_front_flash_set('success', 'Комментарий успешно сохранён.');
            }
            else
            {
                f_igosja_session_front_flash_set('error', 'Нельзя писать подряд два одинаковых комментария.');
            }
        }
    }

    refresh();
}

$home_team_id       = (int) $game_array[0]['home_team_id'];
$home_national_id   = (int) $game_array[0]['home_national_id'];
$guest_team_id      = (int) $game_array[0]['guest_team_id'];
$guest_national_id  = (int) $game_array[0]['guest_national_id'];

$sql = "SELECT `lineup_age`,
               `lineup_assist`,
               `lineup_pass`,
               `lineup_penalty`,
               `lineup_plus_minus`,
               `lineup_power_change`,
               `lineup_score`,
               `lineup_shot`,
               `lineup_power_nominal`,
               `lineup_power_real`,
               `name_name`,
               `player_id`,
               `position_id`,
               `position_short`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `lineup`
        ON `player_id`=`lineup_player_id`
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        WHERE `lineup_game_id`=$num_get
        AND `lineup_team_id`=$home_team_id
        AND `lineup_national_id`=$home_national_id
        ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
$home_sql = f_igosja_mysqli_query($sql);

$home_array = $home_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `lineup_age`,
               `lineup_assist`,
               `lineup_pass`,
               `lineup_penalty`,
               `lineup_plus_minus`,
               `lineup_power_change`,
               `lineup_score`,
               `lineup_shot`,
               `lineup_power_nominal`,
               `lineup_power_real`,
               `name_name`,
               `player_id`,
               `position_id`,
               `position_short`,
               `surname_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `lineup`
        ON `player_id`=`lineup_player_id`
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        WHERE `lineup_game_id`=$num_get
        AND `lineup_team_id`=$guest_team_id
        AND `lineup_national_id`=$guest_national_id
        ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
$guest_sql = f_igosja_mysqli_query($sql);

$guest_array = $guest_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT `country_name`,
               `event_guest_score`,
               `event_home_score`,
               `event_minute`,
               `event_player_assist_1_id`,
               `event_player_assist_2_id`,
               `event_player_penalty_id`,
               `event_player_score_id`,
               `event_second`,
               `eventtextbullet_text`,
               `eventtextgoal_text`,
               `eventtextpenalty_text`,
               `eventtype_id`,
               `eventtype_text`,
               `name_assist_1`.`name_name` AS `name_assist_1_name`,
               `name_assist_2`.`name_name` AS `name_assist_2_name`,
               `name_penalty`.`name_name` AS `name_penalty_name`,
               `name_score`.`name_name` AS `name_score_name`,
               `national_id`,
               `surname_assist_1`.`surname_name` AS `surname_assist_1_name`,
               `surname_assist_2`.`surname_name` AS `surname_assist_2_name`,
               `surname_penalty`.`surname_name` AS `surname_penalty_name`,
               `surname_score`.`surname_name` AS `surname_score_name`,
               `team_id`,
               `team_name`
        FROM `event`
        LEFT JOIN `eventtextbullet`
        ON `event_eventtextbullet_id`=`eventtextbullet_id`
        LEFT JOIN `eventtextgoal`
        ON `event_eventtextgoal_id`=`eventtextgoal_id`
        LEFT JOIN `eventtextpenalty`
        ON `event_eventtextpenalty_id`=`eventtextpenalty_id`
        LEFT JOIN `eventtype`
        ON `event_eventtype_id`=`eventtype_id`
        LEFT JOIN `team`
        ON `event_team_id`=`team_id`
        LEFT JOIN `national`
        ON `event_national_id`=`national_id`
        LEFT JOIN `country`
        ON `national_country_id`=`country_id`
        LEFT JOIN `player` AS `player_score`
        ON `event_player_score_id`=`player_score`.`player_id`
        LEFT JOIN `name` AS `name_score`
        ON `player_score`.`player_name_id`=`name_score`.`name_id`
        LEFT JOIN `surname` AS `surname_score`
        ON `player_score`.`player_surname_id`=`surname_score`.`surname_id`
        LEFT JOIN `player` AS `player_assist_1`
        ON `event_player_assist_1_id`=`player_assist_1`.`player_id`
        LEFT JOIN `name` AS `name_assist_1`
        ON `player_assist_1`.`player_name_id`=`name_assist_1`.`name_id`
        LEFT JOIN `surname` AS `surname_assist_1`
        ON `player_assist_1`.`player_surname_id`=`surname_assist_1`.`surname_id`
        LEFT JOIN `player` AS `player_assist_2`
        ON `event_player_assist_2_id`=`player_assist_2`.`player_id`
        LEFT JOIN `name` AS `name_assist_2`
        ON `player_assist_2`.`player_name_id`=`name_assist_2`.`name_id`
        LEFT JOIN `surname` AS `surname_assist_2`
        ON `player_assist_2`.`player_surname_id`=`surname_assist_2`.`surname_id`
        LEFT JOIN `player` AS `player_penalty`
        ON `event_player_penalty_id`=`player_penalty`.`player_id`
        LEFT JOIN `name` AS `name_penalty`
        ON `player_penalty`.`player_name_id`=`name_penalty`.`name_id`
        LEFT JOIN `surname` AS `surname_penalty`
        ON `player_penalty`.`player_surname_id`=`surname_penalty`.`surname_id`
        WHERE `event_game_id`=$num_get
        ORDER BY `event_minute` ASC, `event_second` ASC";
$event_sql = f_igosja_mysqli_query($sql);

$event_array = $event_sql->fetch_all(MYSQLI_ASSOC);

if (!$page = (int) f_igosja_request_get('page'))
{
    $page = 1;
}

$limit  = 10;
$offset = ($page - 1) * $limit;

$sql = "SELECT SQL_CALC_FOUND_ROWS
               `gamecomment_date`,
               `gamecomment_id`,
               `gamecomment_text`,
               `user_id`,
               `user_login`
        FROM `gamecomment`
        LEFT JOIN `user`
        ON `gamecomment_user_id`=`user_id`
        WHERE `gamecomment_game_id`=$num_get
        ORDER BY `gamecomment_id` ASC
        LIMIT $offset, $limit";
$gamecomment_sql = f_igosja_mysqli_query($sql);

$gamecomment_array = $gamecomment_sql->fetch_all(MYSQLI_ASSOC);

$sql = "SELECT FOUND_ROWS() AS `count`";
$total = f_igosja_mysqli_query($sql);
$total = $total->fetch_all(MYSQLI_ASSOC);
$total = $total[0]['count'];

$count_page = ceil($total / $limit);

$seo_title          = ($game_array[0]['home_team_id'] ? $game_array[0]['home_team_name'] : $game_array[0]['home_national_name']) . ' - ' . ($game_array[0]['guest_team_id'] ? $game_array[0]['guest_team_name'] : $game_array[0]['guest_national_name']) . ' (' . $game_array[0]['game_home_score'] . ':' . $game_array[0]['game_guest_score'] . '). Результат матча';
$seo_description    = ($game_array[0]['home_team_id'] ? $game_array[0]['home_team_name'] : $game_array[0]['home_national_name']) . ' - ' . ($game_array[0]['guest_team_id'] ? $game_array[0]['guest_team_name'] : $game_array[0]['guest_national_name']) . ' (' . $game_array[0]['game_home_score'] . ':' . $game_array[0]['game_guest_score'] . '). Результат матча на сайте Вирутальной Хоккейной Лиги.';
$seo_keywords       = ($game_array[0]['home_team_id'] ? $game_array[0]['home_team_name'] : $game_array[0]['home_national_name']) . ' - ' . ($game_array[0]['guest_team_id'] ? $game_array[0]['guest_team_name'] : $game_array[0]['guest_national_name']) . ' ' . $game_array[0]['game_home_score'] . ':' . $game_array[0]['game_guest_score'] . ' результат матча';

include(__DIR__ . '/view/layout/main.php');