<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
        <span class="strong">Результат</span>
        |
        <a href="/game_preview.php?num=<?= $num_get; ?>">
            Перед матчем
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <a href="/team_view.php?num=<?= $game_array[0]['home_team_id']; ?>">
                            <?= $game_array[0]['home_team_name']; ?>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <?= $game_array[0]['game_home_score']; ?>:<?= $game_array[0]['game_guest_score']; ?>
                        (<?= $game_array[0]['game_home_score_1']; ?>:<?= $game_array[0]['game_guest_score_1']; ?>
                        |
                        <?= $game_array[0]['game_home_score_2']; ?>:<?= $game_array[0]['game_guest_score_2']; ?>
                        |
                        <?= $game_array[0]['game_home_score_3']; ?>:<?= $game_array[0]['game_guest_score_3']; ?><?php
                        if ($game_array[0]['game_home_score_over'] && $game_array[0]['game_guest_score_over'])
                        {
                            print ' | ' . $game_array[0]['game_home_score_over'] . ':' . $game_array[0]['game_guest_score_over'] . ' ОТ';
                        }
                        ?><?php
                        if ($game_array[0]['game_home_score_bullet'] && $game_array[0]['game_guest_score_bullet'])
                        {
                            print ' | ' . $game_array[0]['game_home_score_bullet'] . ':' . $game_array[0]['game_guest_score_bullet'] . ' Б';
                        }
                        ?>)
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <a href="/team_view.php?num=<?= $game_array[0]['guest_team_id']; ?>">
                            <?= $game_array[0]['guest_team_name']; ?>
                        </a>
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= f_igosja_ufu_date_time($game_array[0]['shedule_date']); ?>,
        <?= $game_array[0]['tournamenttype_name']; ?>,
        <?= $game_array[0]['stage_name']; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/team_view.php?num=<?= $game_array[0]['stadium_team_id']; ?>">
            <?= $game_array[0]['stadium_name']; ?>
        </a>
        (<?= $game_array[0]['game_stadium_capacity']; ?>),
        Зрителей: <?= $game_array[0]['game_visitor']; ?>.
        Билет: <?= f_igosja_money($game_array[0]['game_ticket']); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['home_tactic_name']; ?></td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Тактика</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['guest_tactic_name']; ?></td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['home_style_name']; ?></td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Стиль</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['guest_style_name']; ?></td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['home_rude_name']; ?></td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Грубость</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['guest_rude_name']; ?></td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['home_mood_name']; ?></td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Настрой</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center"><?= $game_array[0]['guest_mood_name']; ?></td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $home_power_percent; ?>%
                </td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Соотношение сил</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $guest_power_percent; ?>%
                </td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_home_optimality']; ?>%
                </td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Оптимальность</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_guest_optimality']; ?>%
                </td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_home_teamwork_1']; ?> | <?= $game_array[0]['game_home_teamwork_2']; ?> | <?= $game_array[0]['game_home_teamwork_3']; ?>
                </td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Сыгранность</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_guest_teamwork_1']; ?> | <?= $game_array[0]['game_guest_teamwork_2']; ?> | <?= $game_array[0]['game_guest_teamwork_3']; ?>
                </td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_home_shot']; ?>
                    (<?= $game_array[0]['game_home_shot_1']; ?> | <?= $game_array[0]['game_home_shot_2']; ?> | <?= $game_array[0]['game_home_shot_3']; ?><?php if ($game_array[0]['game_home_shot_over']) { ?> | <?= $game_array[0]['game_home_shot_over']; ?><?php } ?>)
                </td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Броски</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_guest_shot']; ?>
                    (<?= $game_array[0]['game_guest_shot_1']; ?> | <?= $game_array[0]['game_guest_shot_2']; ?> | <?= $game_array[0]['game_guest_shot_3']; ?><?php if ($game_array[0]['game_guest_shot_over']) { ?> | <?= $game_array[0]['game_guest_shot_over']; ?><?php } ?>)
                </td>
            </tr>
            <tr>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_home_penalty']; ?>
                    (<?= $game_array[0]['game_home_penalty_1']; ?> | <?= $game_array[0]['game_home_penalty_2']; ?> | <?= $game_array[0]['game_home_penalty_3']; ?><?php if ($game_array[0]['game_home_penalty_over']) { ?> | <?= $game_array[0]['game_home_penalty_over']; ?><?php } ?>)
                </td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">Штрафные минуты</td>
                <td class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                    <?= $game_array[0]['game_guest_penalty']; ?>
                    (<?= $game_array[0]['game_guest_penalty_1']; ?> | <?= $game_array[0]['game_guest_penalty_2']; ?> | <?= $game_array[0]['game_guest_penalty_3']; ?><?php if ($game_array[0]['game_guest_penalty_over']) { ?> | <?= $game_array[0]['game_guest_penalty_over']; ?><?php } ?>)
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                Прогноз на матч
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center"><?= $game_array[0]['game_home_forecast']; ?></td>
                        <td class="text-center"><?= $game_array[0]['game_guest_forecast']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                Сила состава
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td class="text-center"><?= $game_array[0]['game_home_power']; ?></td>
                        <td class="text-center"><?= $game_array[0]['game_guest_power']; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th title="Позиция">П</th>
                <th>
                    <a href="/team_view.php?num=<?= $home_array[0]['team_id']; ?>">
                        <?= $home_array[0]['team_name']; ?>
                    </a>
                </th>
                <th title="Возраст">В</th>
                <th title="Номиральная сила">НС</th>
                <th title="Реальная сила">РС</th>
                <th title="Штрафные минуты">ШМ</th>
                <th title="Броски">Б</th>
                <th title="Заброшенные шайбы (Пропушенные шайбы для вратарей)">Ш</th>
                <th title="Голевые передачи">П</th>
                <th title="Плюс/минус">+/-</th>
            </tr>
            <?php foreach ($home_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <?= $item['position_name']; ?>
                    </td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_power_nominal']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_power_real']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_penalty']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_shot']; ?>
                    </td>
                    <td class="text-center">
                        <?php if (1 == $item['position_id']) { ?>
                            <?= $item['lineup_pass']; ?>
                        <?php } else { ?>
                            <?= $item['lineup_score']; ?>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_assist']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_plus_minus']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th title="Позиция">П</th>
                <th>
                    <a href="/team_view.php?num=<?= $guest_array[0]['team_id']; ?>">
                        <?= $guest_array[0]['team_name']; ?>
                    </a>
                </th>
                <th title="Возраст">В</th>
                <th title="Номиральная сила">НС</th>
                <th title="Реальная сила">РС</th>
                <th title="Штрафные минуты">ШМ</th>
                <th title="Броски">Б</th>
                <th title="Заброшенные шайбы (Пропушенные шайбы для вратарей)">Ш</th>
                <th title="Голевые передачи">П</th>
                <th title="Плюс/минус">+/-</th>
            </tr>
            <?php foreach ($guest_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <?= $item['position_name']; ?>
                    </td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_power_nominal']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_power_real']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_penalty']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_shot']; ?>
                    </td>
                    <td class="text-center">
                        <?php if (1 == $item['position_id']) { ?>
                            <?= $item['lineup_pass']; ?>
                        <?php } else { ?>
                            <?= $item['lineup_score']; ?>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_assist']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_plus_minus']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>Время</th>
                <th>Команда</th>
                <th>Тип</th>
                <th>Событие</th>
                <th>Счет</th>
            </tr>
            <?php foreach ($event_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <?= sprintf("%02d", $item['event_minute']); ?>:<?= sprintf("%02d", $item['event_second']); ?>
                    </td>
                    <td class="text-center">
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= $item['eventtype_text']; ?></td>
                    <td>
                        <?= $item['eventtextbullet_text']; ?>
                        <?= $item['eventtextgoal_text']; ?>
                        <?= $item['eventtextpenalty_text']; ?>
                        <?php if ($item['event_player_penalty_id']) { ?>
                            Удаление -
                            <a href="/player_view.php?num=<?= $item['event_player_penalty_id']; ?>">
                                <?= $item['name_penalty_name']; ?>
                                <?= $item['surname_penalty_name']; ?>
                            </a>
                        <?php } ?>
                        <?php if ($item['event_player_score_id']) { ?>
                            <?php if ($item['eventtextgoal_text']) { ?>
                                Гол -
                            <?php } ?>
                            <a href="/player_view.php?num=<?= $item['event_player_score_id']; ?>">
                                <?= $item['name_score_name']; ?>
                                <?= $item['surname_score_name']; ?>
                            </a>
                        <?php } ?>
                        <?php if ($item['event_player_assist_1_id']) { ?>
                            (<a href="/player_view.php?num=<?= $item['event_player_assist_1_id']; ?>"><?=
                                $item['name_assist_1_name']; ?>
                                <?= $item['surname_assist_1_name'];
                                ?></a><?php if ($item['event_player_assist_2_id']) { ?>,
                                <a href="/player_view.php?num=<?= $item['event_player_assist_2_id']; ?>">
                                    <?= $item['name_assist_2_name']; ?>
                                    <?= $item['surname_assist_2_name']; ?></a><?php } ?>)
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?php if (in_array($item['eventtype_id'], array(EVENTTYPE_GOAL, EVENTTYPE_BULLET))) { ?>
                            <?= $item['event_home_score']; ?>:<?= $item['event_guest_score']; ?>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>