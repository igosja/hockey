<?php

$sql = "SELECT `season_id`
        FROM `season`
        ORDER BY `season_id` DESC
        LIMIT 1";
$season_sql = f_igosja_mysqli_query($sql);

$season_array = $season_sql->fetch_all(MYSQLI_ASSOC);

$igosja_season_id = $season_array[0]['season_id'];