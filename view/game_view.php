<?php
/**
 * @var $auth_user_id integer
 * @var $count_page integer
 * @var $event_array array
 * @var $game_array array
 * @var $gamecomment_array array
 * @var $guest_array array
 * @var $home_array array
 * @var $num_get integer
 * @var $page integer
 * @var $total integer
 */
?>
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
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $game_array[0]['home_team_id'],
                                'team_name' => $game_array[0]['home_team_name'],
                            ),
                            array(
                                'country_name'  => $game_array[0]['home_national_name'],
                                'national_id'   => $game_array[0]['home_national_id'],
                            ),
                            false
                        ); ?>
                        <?= f_igosja_game_auto($game_array[0]['game_home_auto']); ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <?= $game_array[0]['game_home_score']; ?>:<?= $game_array[0]['game_guest_score']; ?>
                        (<?= $game_array[0]['game_home_score_1']; ?>:<?= $game_array[0]['game_guest_score_1']; ?>
                        |
                        <?= $game_array[0]['game_home_score_2']; ?>:<?= $game_array[0]['game_guest_score_2']; ?>
                        |
                        <?= $game_array[0]['game_home_score_3']; ?>:<?= $game_array[0]['game_guest_score_3']; ?><?php
                        if ($game_array[0]['game_home_score_over'] || $game_array[0]['game_guest_score_over'])
                        {
                            print ' | ' . $game_array[0]['game_home_score_over'] . ':' . $game_array[0]['game_guest_score_over'] . ' ОТ';
                        }
                        ?><?php
                        if ($game_array[0]['game_home_score_bullet'] || $game_array[0]['game_guest_score_bullet'])
                        {
                            print ' | ' . $game_array[0]['game_home_score_bullet'] . ':' . $game_array[0]['game_guest_score_bullet'] . ' Б';
                        }
                        ?>)
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center">
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $game_array[0]['guest_team_id'],
                                'team_name' => $game_array[0]['guest_team_name'],
                            ),
                            array(
                                'country_name'  => $game_array[0]['guest_national_name'],
                                'national_id'   => $game_array[0]['guest_national_id'],
                            ),
                            false
                        ); ?>
                        <?= f_igosja_game_auto($game_array[0]['game_guest_auto']); ?>
                    </div>
                </th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= f_igosja_ufu_date_time($game_array[0]['schedule_date']); ?>,
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
        Билет: <?= f_igosja_money_format($game_array[0]['game_ticket']); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <td class="col-35 text-center">
                    <span title="Первое звено"><?= $game_array[0]['home_tactic_1_name']; ?></span> |
                    <span title="Второе звено"><?= $game_array[0]['home_tactic_2_name']; ?></span> |
                    <span title="Третье звено"><?= $game_array[0]['home_tactic_3_name']; ?></span>
                </td>
                <td class="text-center">Тактика</td>
                <td class="col-35 text-center">
                    <span title="Первое звено"><?= $game_array[0]['guest_tactic_1_name']; ?></span> |
                    <span title="Второе звено"><?= $game_array[0]['guest_tactic_2_name']; ?></span> |
                    <span title="Третье звено"><?= $game_array[0]['guest_tactic_3_name']; ?></span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span title="Первое звено"><?= $game_array[0]['home_style_1_name']; ?></span> |
                    <span title="Второе звено"><?= $game_array[0]['home_style_2_name']; ?></span> |
                    <span title="Третье звено"><?= $game_array[0]['home_style_3_name']; ?></span>
                </td>
                <td class="text-center">Стиль</td>
                <td class="text-center">
                    <span title="Первое звено"><?= $game_array[0]['guest_style_1_name']; ?></span> |
                    <span title="Второе звено"><?= $game_array[0]['guest_style_2_name']; ?></span> |
                    <span title="Третье звено"><?= $game_array[0]['guest_style_3_name']; ?></span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span title="Первое звено"><?= $game_array[0]['home_rude_1_name']; ?></span> |
                    <span title="Второе звено"><?= $game_array[0]['home_rude_2_name']; ?></span> |
                    <span title="Третье звено"><?= $game_array[0]['home_rude_3_name']; ?></span>
                </td>
                <td class="text-center">Грубость</td>
                <td class="text-center">
                    <span title="Первое звено"><?= $game_array[0]['guest_rude_1_name']; ?></span> |
                    <span title="Второе звено"><?= $game_array[0]['guest_rude_2_name']; ?></span> |
                    <span title="Третье звено"><?= $game_array[0]['guest_rude_3_name']; ?></span>
                </td>
            </tr>
            <tr>
                <td class="text-center"><?= $game_array[0]['home_mood_name']; ?></td>
                <td class="text-center">Настрой</td>
                <td class="text-center"><?= $game_array[0]['guest_mood_name']; ?></td>
            </tr>
            <tr>
                <td class="text-center">
                    <?= $game_array[0]['game_home_power_percent']; ?>%
                </td>
                <td class="text-center">Соотношение сил</td>
                <td class="text-center">
                    <?= $game_array[0]['game_guest_power_percent']; ?>%
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span title="Расстановка сил по позициям"><?= $game_array[0]['game_home_optimality_1']; ?>%</span> |
                    <span title="Соотношение силы состава к ретингу команды"><?= $game_array[0]['game_home_optimality_2']; ?>%</span>
                </td>
                <td class="text-center">Оптимальность</td>
                <td class="text-center">
                    <span title="Расстановка сил по позициям"><?= $game_array[0]['game_guest_optimality_1']; ?>%</span> |
                    <span title="Соотношение силы состава к ретингу команды"><?= $game_array[0]['game_guest_optimality_2']; ?>%</span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span title="Первое звено"><?= $game_array[0]['game_home_teamwork_1']; ?>%</span> |
                    <span title="Второе звено"><?= $game_array[0]['game_home_teamwork_2']; ?>%</span> |
                    <span title="Третье звено"><?= $game_array[0]['game_home_teamwork_3']; ?>%</span>
                </td>
                <td class="text-center">Сыгранность</td>
                <td class="text-center">
                    <span title="Первое звено"><?= $game_array[0]['game_guest_teamwork_1']; ?>%</span> |
                    <span title="Второе звено"><?= $game_array[0]['game_guest_teamwork_2']; ?>%</span> |
                    <span title="Третье звено"><?= $game_array[0]['game_guest_teamwork_3']; ?>%</span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <?= $game_array[0]['game_home_shot']; ?>
                    (<?= $game_array[0]['game_home_shot_1']; ?> | <?= $game_array[0]['game_home_shot_2']; ?> | <?= $game_array[0]['game_home_shot_3']; ?><?php if ($game_array[0]['game_home_shot_over']) { ?> | <?= $game_array[0]['game_home_shot_over']; ?><?php } ?>)
                </td>
                <td class="text-center">Броски</td>
                <td class="text-center">
                    <?= $game_array[0]['game_guest_shot']; ?>
                    (<?= $game_array[0]['game_guest_shot_1']; ?> | <?= $game_array[0]['game_guest_shot_2']; ?> | <?= $game_array[0]['game_guest_shot_3']; ?><?php if ($game_array[0]['game_guest_shot_over']) { ?> | <?= $game_array[0]['game_guest_shot_over']; ?><?php } ?>)
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <?= $game_array[0]['game_home_penalty']; ?>
                    (<?= $game_array[0]['game_home_penalty_1']; ?> | <?= $game_array[0]['game_home_penalty_2']; ?> | <?= $game_array[0]['game_home_penalty_3']; ?><?php if ($game_array[0]['game_home_penalty_over']) { ?> | <?= $game_array[0]['game_home_penalty_over']; ?><?php } ?>)
                </td>
                <td class="text-center">Штрафные минуты</td>
                <td class="text-center">
                    <?= $game_array[0]['game_guest_penalty']; ?>
                    (<?= $game_array[0]['game_guest_penalty_1']; ?> | <?= $game_array[0]['game_guest_penalty_2']; ?> | <?= $game_array[0]['game_guest_penalty_3']; ?><?php if ($game_array[0]['game_guest_penalty_over']) { ?> | <?= $game_array[0]['game_guest_penalty_over']; ?><?php } ?>)
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <td class="text-center">Прогноз на матч</td>
                <td
                    class="col-35 text-center
                    <?php if ($game_array[0]['game_home_forecast'] > $game_array[0]['game_guest_forecast']) { ?>
                        font-green
                    <?php } elseif ($game_array[0]['game_home_forecast'] < $game_array[0]['game_guest_forecast']) { ?>
                        font-red
                    <?php } ?>"
                >
                    <?= $game_array[0]['game_home_forecast']; ?>
                </td>
                <td
                    class="col-35 text-center
                    <?php if ($game_array[0]['game_home_forecast'] < $game_array[0]['game_guest_forecast']) { ?>
                        font-green
                    <?php } elseif ($game_array[0]['game_home_forecast'] > $game_array[0]['game_guest_forecast']) { ?>
                        font-red
                    <?php } ?>"
                >
                    <?= $game_array[0]['game_guest_forecast']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-center">Сила состава</td>
                <td class="text-center
                    <?php if ($game_array[0]['game_home_power'] > $game_array[0]['game_guest_power']) { ?>
                        font-green
                    <?php } elseif ($game_array[0]['game_home_power'] < $game_array[0]['game_guest_power']) { ?>
                        font-red
                    <?php } ?>"
                >
                    <?= $game_array[0]['game_home_power']; ?>
                </td>
                <td
                    class="text-center
                    <?php if ($game_array[0]['game_home_power'] < $game_array[0]['game_guest_power']) { ?>
                        font-green
                    <?php } elseif ($game_array[0]['game_home_power'] > $game_array[0]['game_guest_power']) { ?>
                        font-red
                    <?php } ?>"
                >
                    <?= $game_array[0]['game_guest_power']; ?>
                </td>
            </tr>
        </table>
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
                <th class="hidden-xs" title="Возраст">В</th>
                <th class="hidden-xs" title="Номинальная сила">НС</th>
                <th title="Реальная сила">РС</th>
                <th class="hidden-xs" title="Штрафные минуты">ШМ</th>
                <th class="hidden-xs" title="Броски">Б</th>
                <th title="Заброшенные шайбы (Пропушенные шайбы для вратарей)">Ш</th>
                <th title="Голевые передачи">П</th>
                <th title="Плюс/минус">+/-</th>
            </tr>
            <?php foreach ($home_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <?= $item['position_short']; ?>
                    </td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                        </a>
                        <?= f_igosja_player_power_change($item['lineup_power_change']); ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= $item['lineup_age']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= $item['lineup_power_nominal']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_power_real']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= $item['lineup_penalty']; ?>
                    </td>
                    <td class="hidden-xs text-center">
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
                <th class="hidden-xs" title="Возраст">В</th>
                <th class="hidden-xs" title="Номинальная сила">НС</th>
                <th title="Реальная сила">РС</th>
                <th class="hidden-xs" title="Штрафные минуты">ШМ</th>
                <th class="hidden-xs" title="Броски">Б</th>
                <th title="Заброшенные шайбы (Пропушенные шайбы для вратарей)">Ш</th>
                <th title="Голевые передачи">П</th>
                <th title="Плюс/минус">+/-</th>
            </tr>
            <?php foreach ($guest_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <?= $item['position_short']; ?>
                    </td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                        </a>
                        <?= f_igosja_player_power_change($item['lineup_power_change']); ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= $item['lineup_age']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= $item['lineup_power_nominal']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['lineup_power_real']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= $item['lineup_penalty']; ?>
                    </td>
                    <td class="hidden-xs text-center">
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
                <th class="hidden-xs">Тип</th>
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
                    <td class="hidden-xs text-center"><?= $item['eventtype_text']; ?></td>
                    <td>
                        <span class="hidden-xs">
                            <?= $item['eventtextbullet_text']; ?>
                            <?= $item['eventtextgoal_text']; ?>
                            <?= $item['eventtextpenalty_text']; ?>
                        </span>
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
<?php if ($gamecomment_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <form method="GET">
        <input type="hidden" name="num" value="<?= $num_get; ?>">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                Всего комментариев: <?= $total; ?>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 text-right">
                <label for="page">Страница:</label>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                <select class="form-control" name="page" id="page">
                    <?php for ($i=1; $i<=$count_page; $i++) { ?>
                        <option
                            value="<?= $i; ?>"
                            <?php if ($page == $i) { ?>
                                selected
                            <?php } ?>
                        >
                            <?= $i; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </form>
    <?php foreach ($gamecomment_array as $item) { ?>
        <div class="row border-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                <a class="strong" href="/user_view.php?num=<?= $item['user_id']; ?>">
                    <?= $item['user_login']; ?>
                </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= nl2br($item['gamecomment_text']); ?>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
                <?= f_igosja_ufu_date_time($item['gamecomment_date']); ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if (isset($auth_user_id)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
            <label for="gamecomment">Ваш комментарий:</label>
        </div>
    </div>
    <form id="gamecomment-form" method="POST">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <textarea class="form-control" id="gamecomment" name="data[text]" rows="5"></textarea>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center gamecomment-error notification-error"></div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <button class="btn margin">Комментировать</button>
            </div>
        </div>
    </form>
<?php } ?>