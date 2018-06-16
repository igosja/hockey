<?php
/**
 * @var $auth_blockcomment_text string
 * @var $auth_blockgame_text string
 * @var $auth_date_block_comment integer
 * @var $auth_date_block_gamecomment integer
 * @var $auth_user_id integer
 * @var $auth_userrole_id integer
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
        <?= f_igosja_game_tournament_link($game_array); ?>
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
                    <span title="Первое звено"><?= $game_array[0]['home_tactic_1_name']; ?></span>
                    |
                    <span title="Второе звено"><?= $game_array[0]['home_tactic_2_name']; ?></span>
                    |
                    <span title="Третье звено"><?= $game_array[0]['home_tactic_3_name']; ?></span>
                </td>
                <td class="text-center">Тактика</td>
                <td class="col-35 text-center">
                    <span title="Первое звено"><?= $game_array[0]['guest_tactic_1_name']; ?></span>
                    |
                    <span title="Второе звено"><?= $game_array[0]['guest_tactic_2_name']; ?></span>
                    |
                    <span title="Третье звено"><?= $game_array[0]['guest_tactic_3_name']; ?></span>
                </td>
            </tr>
            <tr>
                <td class="text-center">
                    <span class="<?= f_igosja_css_style($game_array[0]['game_home_style_1_id'], $game_array[0]['game_guest_style_1_id']); ?>" title="Первое звено">
                        <?= $game_array[0]['home_style_1_name']; ?>
                    </span>
                    |
                    <span class="<?= f_igosja_css_style($game_array[0]['game_home_style_2_id'], $game_array[0]['game_guest_style_2_id']); ?>" title="Второе звено">
                        <?= $game_array[0]['home_style_2_name']; ?>
                    </span>
                    |
                    <span class="<?= f_igosja_css_style($game_array[0]['game_home_style_3_id'], $game_array[0]['game_guest_style_3_id']); ?>" title="Третье звено">
                        <?= $game_array[0]['home_style_3_name']; ?>
                    </span>
                </td>
                <td class="text-center">Стиль</td>
                <td class="text-center">
                    <span class="<?= f_igosja_css_style($game_array[0]['game_guest_style_1_id'], $game_array[0]['game_home_style_1_id']); ?>" title="Первое звено">
                        <?= $game_array[0]['guest_style_1_name']; ?>
                    </span>
                    |
                    <span class="<?= f_igosja_css_style($game_array[0]['game_guest_style_2_id'], $game_array[0]['game_home_style_2_id']); ?>" title="Второе звено">
                        <?= $game_array[0]['guest_style_2_name']; ?>
                    </span>
                    |
                    <span class="<?= f_igosja_css_style($game_array[0]['game_guest_style_3_id'], $game_array[0]['game_home_style_3_id']); ?>" title="Третье звено">
                        <?= $game_array[0]['guest_style_3_name']; ?>
                    </span>
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
                <td class="text-center">
                    <span class="<?= f_igosja_css_mood($game_array[0]['home_mood_id']); ?>">
                        <?= $game_array[0]['home_mood_name']; ?>
                    </span>
                </td>
                <td class="text-center">Настрой</td>
                <td class="text-center">
                    <span class="<?= f_igosja_css_mood($game_array[0]['guest_mood_id']); ?>">
                        <?= $game_array[0]['guest_mood_name']; ?>
                    </span>
                </td>
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
    <?php for ($i=0; $i<2; $i++) { ?>
        <?php
        if (0 == $i)
        {
            $team       = 'home';
            $team_array = $home_array;
        }
        else
        {
            $team       = 'guest';
            $team_array = $guest_array;
        }
        ?>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th title="Позиция">П</th>
                    <th>
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $game_array[0][$team . '_team_id'],
                                'team_name' => $game_array[0][$team . '_team_name'],
                            ),
                            array(
                                'country_name'  => $game_array[0][$team . '_national_name'],
                                'national_id'   => $game_array[0][$team . '_national_id'],
                            ),
                            false
                        ); ?>
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
                <?php $power = 0; ?>
                <?php for ($j=0, $count_team = count($team_array); $j<$count_team; $j++) { ?>
                    <?php if (in_array($j, array(1, 6, 11))) { ?>
                        <tr>
                            <td class="text-center text-size-2" colspan="10">
                                <?php if (1 == $j) { ?>
                                    Первое
                                <?php } elseif (6 == $j) { ?>
                                    Второе
                                <?php } else { ?>
                                    Третье
                                <?php } ?>
                                звено
                            </td>
                        </tr>
                        <?php $power = 0; ?>
                    <?php } ?>
                    <?php $power = $power + $team_array[$j]['lineup_power_real']; ?>
                    <tr>
                        <td class="text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['position_short']; ?>
                        </td>
                        <td <?php if (0 == $j) { ?>class="border-bottom-blue"<?php } ?>>
                            <a href="/player_view.php?num=<?= $team_array[$j]['player_id']; ?>">
                                <?= $team_array[$j]['name_name']; ?> <?= $team_array[$j]['surname_name']; ?>
                            </a>
                            <?= f_igosja_player_power_change($team_array[$j]['lineup_power_change']); ?>
                        </td>
                        <td class="hidden-xs text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['lineup_age']; ?>
                        </td>
                        <td class="hidden-xs text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['lineup_power_nominal']; ?>
                        </td>
                        <td class="text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['lineup_power_real']; ?>
                        </td>
                        <td class="hidden-xs text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['lineup_penalty']; ?>
                        </td>
                        <td class="hidden-xs text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['lineup_shot']; ?>
                        </td>
                        <td class="text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?php if (1 == $team_array[$j]['position_id']) { ?>
                                <?= $team_array[$j]['lineup_pass']; ?>
                            <?php } else { ?>
                                <?= $team_array[$j]['lineup_score']; ?>
                            <?php } ?>
                        </td>
                        <td class="text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['lineup_assist']; ?>
                        </td>
                        <td class="text-center <?php if (0 == $j) { ?>border-bottom-blue<?php } ?>">
                            <?= $team_array[$j]['lineup_plus_minus']; ?>
                        </td>
                    </tr>
                    <?php if (in_array($j, array(5, 10, 15))) { ?>
                        <tr>
                            <td class="text-center border-bottom-blue" colspan="10"><span class="text-size-2">Общая сила звена -</span> <?= $power; ?></td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </table>
        </div>
    <?php } ?>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
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
                        <?= f_igosja_team_or_national_link(
                            array(
                                'team_id'   => $item['team_id'],
                                'team_name' => $item['team_name'],
                            ),
                            array(
                                'country_name'  => $item['country_name'],
                                'national_id'   => $item['national_id'],
                            ),
                            false
                        ); ?>
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
                                Шайба -
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
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>
<?php if ($gamecomment_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Всего комментариев: <?= $total; ?>
        </div>
    </div>
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
                <?php if (isset($auth_user_id) && USERROLE_USER != $auth_userrole_id) { ?>
                    |
                    <a href="/gamecomment_delete.php?num=<?= $item['gamecomment_id']; ?>&game_id=<?= $num_get; ?>">
                        Удалить
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php include(__DIR__ . '/include/pagination.php'); ?>
<?php } ?>
<?php if (isset($auth_user_id)) { ?>
    <?php if ($auth_date_block_gamecomment < time() && $auth_date_block_comment < time()) { ?>
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
    <?php } elseif ($auth_date_block_gamecomment >= time()) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию матчей до <?= f_igosja_ufu_date_time($auth_date_block_gamecomment); ?>.
                <br/>
                Причина - <?= $auth_blockgame_text; ?>
            </div>
        </div>
    <?php } elseif ($auth_date_block_comment >= time()) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию матчей до <?= f_igosja_ufu_date_time($auth_date_block_comment); ?>.
                <br/>
                Причина - <?= $auth_blockcomment_text; ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>