<?php

include (__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    redirect('/wrong_page.php');
}

$sql = "SELECT `game_guest_forecast`,
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
               `game_guest_teamwork_1`,
               `game_guest_teamwork_2`,
               `game_guest_teamwork_3`,
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
               `game_home_teamwork_1`,
               `game_home_teamwork_2`,
               `game_home_teamwork_3`,
               `game_played`,
               `game_stadium_capacity`,
               `game_ticket`,
               `game_visitor`,
               `guest_mood`.`mood_name` AS `guest_mood_name`,
               `guest_rude`.`rude_name` AS `guest_rude_name`,
               `guest_style`.`style_name` AS `guest_style_name`,
               `guest_tactic`.`tactic_name` AS `guest_tactic_name`,
               `guest_team`.`team_id` AS `guest_team_id`,
               `guest_team`.`team_name` AS `guest_team_name`,
               `home_mood`.`mood_name` AS `home_mood_name`,
               `home_rude`.`rude_name` AS `home_rude_name`,
               `home_style`.`style_name` AS `home_style_name`,
               `home_tactic`.`tactic_name` AS `home_tactic_name`,
               `home_team`.`team_id` AS `home_team_id`,
               `home_team`.`team_name` AS `home_team_name`,
               `shedule_date`,
               `stadium_name`,
               `stadium_team`.`team_id` AS `stadium_team_id`,
               `stage_name`,
               `tournamenttype_name`
        FROM `game`
        LEFT JOIN `team` AS `guest_team`
        ON `game_guest_team_id`=`guest_team`.`team_id`
        LEFT JOIN `team` AS `home_team`
        ON `game_home_team_id`=`home_team`.`team_id`
        LEFT JOIN `shedule`
        ON `game_shedule_id`=`shedule_id`
        LEFT JOIN `tournamenttype`
        ON `shedule_tournamenttype_id`=`tournamenttype_id`
        LEFT JOIN `stage`
        ON `shedule_stage_id`=`stage_id`
        LEFT JOIN `stadium`
        ON `game_stadium_id`=`stadium_id`
        LEFT JOIN `team` AS `stadium_team`
        ON `stadium_team`.`team_stadium_id`=`stadium_id`
        LEFT JOIN `mood` AS `guest_mood`
        ON `game_guest_mood_id`=`guest_mood`.`mood_id`
        LEFT JOIN `mood` AS `home_mood`
        ON `game_home_mood_id`=`home_mood`.`mood_id`
        LEFT JOIN `rude` AS `guest_rude`
        ON `game_guest_rude_id`=`guest_rude`.`rude_id`
        LEFT JOIN `rude` AS `home_rude`
        ON `game_home_rude_id`=`home_rude`.`rude_id`
        LEFT JOIN `style` AS `guest_style`
        ON `game_guest_style_id`=`guest_style`.`style_id`
        LEFT JOIN `style` AS `home_style`
        ON `game_home_style_id`=`home_style`.`style_id`
        LEFT JOIN `tactic` AS `guest_tactic`
        ON `game_guest_tactic_id`=`guest_tactic`.`tactic_id`
        LEFT JOIN `tactic` AS `home_tactic`
        ON `game_home_tactic_id`=`home_tactic`.`tactic_id`
        WHERE `game_id`=$num_get
        LIMIT 1";
$game_sql = f_igosja_mysqli_query($sql);

if (0 == $game_sql->num_rows)
{
    redirect('/wrong_page.php');
}

$game_array = $game_sql->fetch_all(1);

if (0 == $game_array[0]['game_played'])
{
    redirect('/game_preview.php?num=' . $num_get);
}

$sql = "SELECT `lineup_age`,
               `lineup_assist`,
               `lineup_pass`,
               `lineup_penalty`,
               `lineup_plus_minus`,
               `lineup_score`,
               `lineup_shot`,
               `lineup_power_nominal`,
               `lineup_power_real`,
               `name_name`,
               `player_id`,
               `position_id`,
               `position_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `lineup`
        ON `player_id`=`lineup_player_id`
        LEFT JOIN `game`
        ON (`lineup_game_id`=`game_id`
        AND `lineup_team_id`=`game_home_team_id`)
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        LEFT JOIN `team`
        ON `lineup_team_id`=`team_id`
        WHERE `game_id`=$num_get
        ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
$home_sql = f_igosja_mysqli_query($sql);

$home_array = $home_sql->fetch_all(1);

$sql = "SELECT `lineup_age`,
               `lineup_assist`,
               `lineup_pass`,
               `lineup_penalty`,
               `lineup_plus_minus`,
               `lineup_score`,
               `lineup_shot`,
               `lineup_power_nominal`,
               `lineup_power_real`,
               `name_name`,
               `player_id`,
               `position_id`,
               `position_name`,
               `surname_name`,
               `team_id`,
               `team_name`
        FROM `player`
        LEFT JOIN `name`
        ON `player_name_id`=`name_id`
        LEFT JOIN `surname`
        ON `player_surname_id`=`surname_id`
        LEFT JOIN `lineup`
        ON `player_id`=`lineup_player_id`
        LEFT JOIN `game`
        ON (`lineup_game_id`=`game_id`
        AND `lineup_team_id`=`game_guest_team_id`)
        LEFT JOIN `position`
        ON `lineup_position_id`=`position_id`
        LEFT JOIN `team`
        ON `lineup_team_id`=`team_id`
        WHERE `game_id`=$num_get
        ORDER BY `lineup_line_id` ASC, `lineup_position_id` ASC";
$guest_sql = f_igosja_mysqli_query($sql);

$guest_array = $guest_sql->fetch_all(1);

$sql = "SELECT `event_guest_score`,
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

$event_array = $event_sql->fetch_all(1);

include (__DIR__ . '/view/layout/main.php');