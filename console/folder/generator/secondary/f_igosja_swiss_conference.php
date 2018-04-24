<?php

/**
 * Жереб за "швейцарською системою" для конференції
 * @param $team_array array список команд, котрі треба прожеребкувати
 * @param $stage_id integer
 * @return array массив з матчами
 */
function f_igosja_swiss_conference($team_array, $stage_id)
{
    if (2 == $stage_id)
    {
        $key_array = array(
            array(0, 1),
            array(22, 2),
            array(21, 3),
            array(20, 4),
            array(19, 5),
            array(18, 6),
            array(17, 7),
            array(16, 8),
            array(15, 9),
            array(14, 10),
            array(13, 11),
            array(12, 23),
        );
    }
    elseif (3 == $stage_id)
    {
        $key_array = array(
            array(2, 0),
            array(3, 22),
            array(4, 21),
            array(5, 20),
            array(6, 19),
            array(7, 18),
            array(8, 17),
            array(9, 16),
            array(10, 15),
            array(11, 14),
            array(12, 13),
            array(23, 1),
        );
    }
    elseif (4 == $stage_id)
    {
        $key_array = array(
            array(0, 3),
            array(1, 2),
            array(22, 4),
            array(21, 5),
            array(20, 6),
            array(19, 7),
            array(18, 8),
            array(17, 9),
            array(16, 10),
            array(15, 11),
            array(14, 12),
            array(13, 23),
        );
    }
    elseif (5 == $stage_id)
    {
        $key_array = array(
            array(4, 0),
            array(3, 1),
            array(5, 22),
            array(6, 21),
            array(7, 20),
            array(8, 19),
            array(9, 18),
            array(10, 17),
            array(11, 16),
            array(12, 15),
            array(13, 14),
            array(23, 2),
        );
    }
    elseif (6 == $stage_id)
    {
        $key_array = array(
            array(0, 5),
            array(1, 4),
            array(2, 3),
            array(22, 6),
            array(21, 7),
            array(20, 8),
            array(19, 9),
            array(18, 10),
            array(17, 11),
            array(16, 12),
            array(15, 13),
            array(14, 23),
        );
    }
    elseif (7 == $stage_id)
    {
        $key_array = array(
            array(6, 0),
            array(5, 1),
            array(4, 2),
            array(7, 22),
            array(8, 21),
            array(9, 20),
            array(10, 19),
            array(11, 18),
            array(12, 17),
            array(13, 16),
            array(14, 15),
            array(23, 3),
        );
    }
    elseif (8 == $stage_id)
    {
        $key_array = array(
            array(0, 7),
            array(1, 6),
            array(2, 5),
            array(3, 4),
            array(22, 8),
            array(21, 9),
            array(20, 10),
            array(19, 11),
            array(18, 12),
            array(17, 13),
            array(16, 14),
            array(15, 23),
        );
    }
    elseif (9 == $stage_id)
    {
        $key_array = array(
            array(8, 0),
            array(7, 1),
            array(6, 2),
            array(5, 3),
            array(9, 22),
            array(10, 21),
            array(11, 20),
            array(12, 19),
            array(13, 18),
            array(14, 17),
            array(15, 16),
            array(23, 4),
        );
    }
    elseif (10 == $stage_id)
    {
        $key_array = array(
            array(0, 9),
            array(1, 8),
            array(2, 7),
            array(3, 6),
            array(4, 5),
            array(22, 10),
            array(21, 11),
            array(20, 12),
            array(19, 13),
            array(18, 14),
            array(17, 15),
            array(16, 23),
        );
    }
    elseif (11 == $stage_id)
    {
        $key_array = array(
            array(10, 0),
            array(9, 1),
            array(8, 2),
            array(7, 3),
            array(6, 4),
            array(11, 22),
            array(12, 21),
            array(13, 20),
            array(14, 19),
            array(15, 18),
            array(16, 17),
            array(23, 5),
        );
    }
    elseif (12 == $stage_id)
    {
        $key_array = array(
            array(0, 11),
            array(1, 10),
            array(2, 9),
            array(3, 8),
            array(4, 7),
            array(5, 6),
            array(22, 12),
            array(21, 13),
            array(20, 14),
            array(19, 15),
            array(18, 16),
            array(17, 23),
        );
    }
    elseif (13 == $stage_id)
    {
        $key_array = array(
            array(12, 0),
            array(11, 1),
            array(10, 2),
            array(9, 3),
            array(8, 4),
            array(7, 5),
            array(13, 22),
            array(14, 21),
            array(15, 20),
            array(16, 19),
            array(17, 18),
            array(23, 6),
        );
    }
    elseif (14 == $stage_id)
    {
        $key_array = array(
            array(0, 13),
            array(1, 12),
            array(2, 11),
            array(3, 10),
            array(4, 9),
            array(5, 8),
            array(6, 7),
            array(22, 14),
            array(21, 15),
            array(20, 16),
            array(19, 17),
            array(18, 23),
        );
    }
    elseif (15 == $stage_id)
    {
        $key_array = array(
            array(14, 0),
            array(13, 1),
            array(12, 2),
            array(11, 3),
            array(10, 4),
            array(9, 5),
            array(8, 6),
            array(15, 22),
            array(16, 21),
            array(17, 20),
            array(18, 19),
            array(23, 7),
        );
    }
    elseif (16 == $stage_id)
    {
        $key_array = array(
            array(0, 15),
            array(1, 14),
            array(2, 13),
            array(3, 12),
            array(4, 11),
            array(5, 10),
            array(6, 9),
            array(7, 8),
            array(22, 16),
            array(21, 17),
            array(20, 18),
            array(19, 23),
        );
    }
    elseif (17 == $stage_id)
    {
        $key_array = array(
            array(16, 0),
            array(15, 1),
            array(14, 2),
            array(13, 3),
            array(12, 4),
            array(11, 5),
            array(10, 6),
            array(9, 7),
            array(17, 22),
            array(18, 21),
            array(19, 20),
            array(23, 8),
        );
    }
    elseif (18 == $stage_id)
    {
        $key_array = array(
            array(0, 17),
            array(1, 16),
            array(2, 15),
            array(3, 14),
            array(4, 13),
            array(5, 12),
            array(6, 11),
            array(7, 10),
            array(8, 9),
            array(22, 18),
            array(21, 19),
            array(20, 23),
        );
    }
    elseif (19 == $stage_id)
    {
        $key_array = array(
            array(18, 0),
            array(17, 1),
            array(16, 2),
            array(15, 3),
            array(14, 4),
            array(13, 5),
            array(12, 6),
            array(11, 7),
            array(10, 8),
            array(19, 22),
            array(20, 21),
            array(23, 9),
        );
    }
    elseif (20 == $stage_id)
    {
        $key_array = array(
            array(0, 19),
            array(1, 18),
            array(2, 17),
            array(3, 16),
            array(4, 15),
            array(5, 14),
            array(6, 13),
            array(7, 12),
            array(8, 11),
            array(9, 10),
            array(22, 20),
            array(21, 23),
        );
    }
    elseif (21 == $stage_id)
    {
        $key_array = array(
            array(20, 0),
            array(19, 1),
            array(18, 2),
            array(17, 3),
            array(16, 4),
            array(15, 5),
            array(14, 6),
            array(13, 7),
            array(12, 8),
            array(11, 9),
            array(21, 22),
            array(23, 10),
        );
    }
    elseif (22 == $stage_id)
    {
        $key_array = array(
            array(0, 21),
            array(1, 20),
            array(2, 19),
            array(3, 18),
            array(4, 17),
            array(5, 16),
            array(6, 15),
            array(7, 14),
            array(8, 13),
            array(9, 12),
            array(10, 11),
            array(22, 23),
        );
    }
    elseif (23 == $stage_id)
    {
        $key_array = array(
            array(22, 0),
            array(21, 1),
            array(20, 2),
            array(19, 3),
            array(18, 4),
            array(17, 5),
            array(16, 6),
            array(15, 7),
            array(14, 8),
            array(13, 9),
            array(12, 10),
            array(23, 11),
        );
    }
    elseif (24 == $stage_id)
    {
        $key_array = array(
            array(0, 23),
            array(1, 22),
            array(2, 21),
            array(3, 20),
            array(4, 19),
            array(5, 18),
            array(6, 17),
            array(7, 16),
            array(8, 15),
            array(9, 14),
            array(10, 13),
            array(11, 12),
        );
    }
    elseif (25 == $stage_id)
    {
        $key_array = array(
            array(1, 0),
            array(2, 22),
            array(3, 21),
            array(4, 20),
            array(5, 19),
            array(6, 18),
            array(7, 17),
            array(8, 16),
            array(9, 15),
            array(10, 14),
            array(11, 13),
            array(23, 12),
        );
    }
    elseif (26 == $stage_id)
    {
        $key_array = array(
            array(0, 2),
            array(22, 3),
            array(21, 4),
            array(20, 5),
            array(19, 6),
            array(18, 7),
            array(17, 8),
            array(16, 9),
            array(15, 10),
            array(14, 11),
            array(13, 12),
            array(1, 23),
        );
    }
    elseif (27 == $stage_id)
    {
        $key_array = array(
            array(3, 0),
            array(2, 1),
            array(4, 22),
            array(5, 21),
            array(6, 20),
            array(7, 19),
            array(8, 18),
            array(9, 17),
            array(10, 16),
            array(11, 15),
            array(12, 14),
            array(23, 13),
        );
    }
    elseif (28 == $stage_id)
    {
        $key_array = array(
            array(0, 4),
            array(1, 3),
            array(22, 5),
            array(21, 6),
            array(20, 7),
            array(19, 8),
            array(18, 9),
            array(17, 10),
            array(16, 11),
            array(15, 12),
            array(14, 13),
            array(2, 23),
        );
    }
    elseif (29 == $stage_id)
    {
        $key_array = array(
            array(5, 0),
            array(4, 1),
            array(3, 2),
            array(6, 22),
            array(7, 21),
            array(8, 20),
            array(9, 19),
            array(10, 18),
            array(11, 17),
            array(12, 16),
            array(13, 15),
            array(23, 14),
        );
    }
    elseif (30 == $stage_id)
    {
        $key_array = array(
            array(0, 6),
            array(1, 5),
            array(2, 4),
            array(22, 7),
            array(21, 8),
            array(20, 9),
            array(19, 10),
            array(18, 11),
            array(17, 12),
            array(16, 13),
            array(15, 14),
            array(3, 23),
        );
    }
    elseif (31 == $stage_id)
    {
        $key_array = array(
            array(7, 0),
            array(6, 1),
            array(5, 2),
            array(4, 3),
            array(8, 22),
            array(9, 21),
            array(10, 20),
            array(11, 19),
            array(12, 18),
            array(13, 17),
            array(14, 16),
            array(23, 15),
        );
    }
    elseif (32 == $stage_id)
    {
        $key_array = array(
            array(0, 8),
            array(1, 7),
            array(2, 6),
            array(3, 5),
            array(22, 9),
            array(21, 10),
            array(20, 11),
            array(19, 12),
            array(18, 13),
            array(17, 14),
            array(16, 15),
            array(4, 23),
        );
    }
    elseif (33 == $stage_id)
    {
        $key_array = array(
            array(9, 0),
            array(8, 1),
            array(7, 2),
            array(6, 3),
            array(5, 4),
            array(10, 22),
            array(11, 21),
            array(12, 20),
            array(13, 19),
            array(14, 18),
            array(15, 17),
            array(23, 16),
        );
    }
    elseif (34 == $stage_id)
    {
        $key_array = array(
            array(0, 10),
            array(1, 9),
            array(2, 8),
            array(3, 7),
            array(4, 6),
            array(22, 11),
            array(21, 12),
            array(20, 13),
            array(19, 14),
            array(18, 15),
            array(17, 16),
            array(5, 23),
        );
    }
    elseif (35 == $stage_id)
    {
        $key_array = array(
            array(11, 0),
            array(10, 1),
            array(9, 2),
            array(8, 3),
            array(7, 4),
            array(6, 5),
            array(12, 22),
            array(13, 21),
            array(14, 20),
            array(15, 19),
            array(16, 18),
            array(23, 17),
        );
    }
    elseif (36 == $stage_id)
    {
        $key_array = array(
            array(0, 12),
            array(1, 11),
            array(2, 10),
            array(3, 9),
            array(4, 8),
            array(5, 7),
            array(22, 13),
            array(21, 14),
            array(20, 15),
            array(19, 16),
            array(18, 17),
            array(6, 23),
        );
    }
    elseif (37 == $stage_id)
    {
        $key_array = array(
            array(13, 0),
            array(12, 1),
            array(11, 2),
            array(10, 3),
            array(9, 4),
            array(8, 5),
            array(7, 6),
            array(14, 22),
            array(15, 21),
            array(16, 20),
            array(17, 19),
            array(23, 18),
        );
    }
    elseif (38 == $stage_id)
    {
        $key_array = array(
            array(0, 14),
            array(1, 13),
            array(2, 12),
            array(3, 11),
            array(4, 10),
            array(5, 9),
            array(6, 8),
            array(22, 15),
            array(21, 16),
            array(20, 17),
            array(19, 18),
            array(7, 23),
        );
    }
    elseif (39 == $stage_id)
    {
        $key_array = array(
            array(15, 0),
            array(14, 1),
            array(13, 2),
            array(12, 3),
            array(11, 4),
            array(10, 5),
            array(9, 6),
            array(8, 7),
            array(16, 22),
            array(17, 21),
            array(18, 20),
            array(23, 19),
        );
    }
    elseif (40 == $stage_id)
    {
        $key_array = array(
            array(0, 16),
            array(1, 15),
            array(2, 14),
            array(3, 13),
            array(4, 12),
            array(5, 11),
            array(6, 10),
            array(7, 9),
            array(22, 17),
            array(21, 18),
            array(20, 19),
            array(8, 23),
        );
    }
    elseif (41 == $stage_id)
    {
        $key_array = array(
            array(17, 0),
            array(16, 1),
            array(15, 2),
            array(14, 3),
            array(13, 4),
            array(12, 5),
            array(11, 6),
            array(10, 7),
            array(9, 8),
            array(18, 22),
            array(19, 21),
            array(23, 20),
        );
    }
    else
        {
        $key_array = array(
            array(0, 18),
            array(1, 17),
            array(2, 16),
            array(3, 15),
            array(4, 14),
            array(5, 13),
            array(6, 12),
            array(7, 11),
            array(8, 10),
            array(22, 19),
            array(21, 20),
            array(9, 23),
        );
    }

    $game_array = array();

    foreach ($key_array as $item)
    {
        $game_array[] = array(
            'home'  => $team_array[$item[0]]['swisstable_team_id'],
            'guest' => $team_array[$item[1]]['swisstable_team_id']
        );
    }

    return $game_array;
}