<?php
/**
 * @var $auth_national_id integer
 * @var $auth_team_id integer
 * @var $c_array array
 * @var $current_array array
 * @var $game_array array
 * @var $gk_array array
 * @var $ld_array array
 * @var $line integer
 * @var $lw_array array
 * @var $mood_array array
 * @var $my_power_vs integer
 * @var $nationalmood_array array
 * @var $num_get integer
 * @var $player_array array
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $rd_array array
 * @var $rude_array array
 * @var $rw_array array
 * @var $style_array array
 * @var $tactic_array array
 * @var $teammood_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Дата</th>
                <th class="hidden-xs">Тип матча</th>
                <th class="hidden-xs">Стадия</th>
                <th></th>
                <th>Соперник</th>
                <th class="hidden-xs" title="Соотношение сил (чем больше это число, тем сильнее ваш соперник)">C/C</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($game_array as $item) { ?>
                <tr <?php if ($num_get == $item['game_id']) { ?>class="info"<?php } ?>>
                    <td class="text-center"><?= f_igosja_ufu_date_time($item['schedule_date']); ?></td>
                    <td class="hidden-xs text-center"><?= $item['tournamenttype_name']; ?></td>
                    <td class="hidden-xs text-center"><?= $item['stage_name']; ?></td>
                    <td class="text-center"><?= $item['home_guest']; ?></td>
                    <td class="text-center">
                        <?php if (isset($item['team_id'])) { ?>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>" target="_blank">
                                <?= $item['team_name']; ?>
                            </a>
                        <?php } else { ?>
                            <a href="/national_view.php?num=<?= $item['national_id']; ?>" target="_blank">
                                <?= $item['country_name']; ?>
                            </a>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?= round($item['power_vs'] / $my_power_vs * 100); ?>%
                    </td>
                    <td class="text-center">
                        <a href="/game_preview.php?num=<?= $item['game_id']; ?>" target="_blank">
                            ?
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="/game_send.php?num=<?= $item['game_id']; ?>">
                            <?php if ($item['game_tactic_id']) { ?>
                                +
                            <?php } else { ?>
                                -
                            <?php } ?>
                        </a>
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
<form class="margin-no game-form" method="POST">
    <div class="row margin-top">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right strong">
            <label for="ticket">Билет, $:</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-2 col-xs-4 text-center">
            <input
                class="form-control"
                id="ticket"
                name="data[ticket]"
                value="<?= $current_array[0]['game_ticket'] ? $current_array[0]['game_ticket'] : 20; ?>"
                <?php if ((isset($current_array[0]['game_guest_team_id']) && $auth_team_id == $current_array[0]['game_guest_team_id']) || (isset($current_array[0]['game_guest_national_id']) && $auth_national_id == $current_array[0]['game_guest_national_id'])) { ?>
                    disabled
                <?php } ?>
            />
        </div>
        <div class="col-lg-1 col-md-1 col-sm-2 col-xs-4" style="height: 20px">
            [<a href="/game_visitor<?php if (isset($current_array[0]['game_guest_national_id'])) { ?>_national<?php } ?>.php?num=<?= $num_get; ?>" target="_blank">Зрители</a>]
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 text-right strong">
            <label for="mood">Настрой:</label>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-8">
            <select class="form-control" id="mood" name="data[mood_id]">
                <?php foreach ($mood_array as $item) { ?>
                    <option
                        value="<?= $item['mood_id']; ?>"
                        <?php if ($current_array[0]['game_mood_id'] == $item['mood_id']) { ?>
                            selected
                        <?php } ?>
                        <?php if ((MOOD_SUPER == $item['mood_id'] && ((isset($teammood_array) && $teammood_array[0]['team_mood_super'] <= 0) || (isset($nationalmood_array) && $nationalmood_array[0]['national_mood_super'] <= 0))) || (MOOD_REST == $item['mood_id'] && ((isset($teammood_array) && $teammood_array[0]['team_mood_rest'] <= 0) || (isset($nationalmood_array) && $nationalmood_array[0]['national_mood_rest'] <= 0))) || (MOOD_NORMAL != $item['mood_id'] && TOURNAMENTTYPE_FRIENDLY == $current_array[0]['schedule_tournamenttype_id'])) { ?>
                            disabled
                        <?php } ?>
                    >
                        <?= $item['mood_name']; ?>
                        <?php if (MOOD_SUPER == $item['mood_id']) { ?>
                            (<?php if (isset($teammood_array)) { print $teammood_array[0]['team_mood_super']; } else { print $nationalmood_array[0]['national_mood_super']; } ?>)
                        <?php } elseif (MOOD_REST == $item['mood_id']) { ?>
                            (<?php if (isset($teammood_array)) { print $teammood_array[0]['team_mood_rest']; } else { print $nationalmood_array[0]['national_mood_rest']; } ?>)
                        <?php } ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <tr>
                    <td></td>
                    <td class="text-center strong">Тактика</td>
                    <td class="text-center strong">Грубость</td>
                    <td class="text-center strong">Стиль</td>
                </tr>
                <tr>
                    <td class="text-right strong">1 звено:</td>
                    <td>
                        <label class="hidden" for="tactic-1">tactic 1</label>
                        <select class="form-control" id="tactic-1" name="data[tactic_1_id]">
                            <?php foreach ($tactic_array as $item) { ?>
                                <option
                                    value="<?= $item['tactic_id']; ?>"
                                    <?php if ($current_array[0]['game_tactic_1_id'] == $item['tactic_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['tactic_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <label class="hidden" for="rude-1">rude 1</label>
                        <select class="form-control" id="rude-1" name="data[rude_1_id]">
                            <?php foreach ($rude_array as $item) { ?>
                                <option
                                    value="<?= $item['rude_id']; ?>"
                                    <?php if ($current_array[0]['game_rude_1_id'] == $item['rude_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['rude_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <label class="hidden" for="style-1">style 1</label>
                        <select class="form-control" id="style-1" name="data[style_1_id]">
                            <?php foreach ($style_array as $item) { ?>
                                <option
                                    value="<?= $item['style_id']; ?>"
                                    <?php if ($current_array[0]['game_style_1_id'] == $item['style_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['style_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-right strong">2 звено:</td>
                    <td>
                        <label class="hidden" for="tactic-2">tactic 2</label>
                        <select class="form-control" id="tactic-2" name="data[tactic_2_id]">
                            <?php foreach ($tactic_array as $item) { ?>
                                <option
                                    value="<?= $item['tactic_id']; ?>"
                                    <?php if ($current_array[0]['game_tactic_2_id'] == $item['tactic_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['tactic_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <label class="hidden" for="rude-2">rude 2</label>
                        <select class="form-control" id="rude-2" name="data[rude_2_id]">
                            <?php foreach ($rude_array as $item) { ?>
                                <option
                                    value="<?= $item['rude_id']; ?>"
                                    <?php if ($current_array[0]['game_rude_2_id'] == $item['rude_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['rude_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <label class="hidden" for="style-2">style 2</label>
                        <select class="form-control" id="style-2" name="data[style_2_id]">
                            <?php foreach ($style_array as $item) { ?>
                                <option
                                    value="<?= $item['style_id']; ?>"
                                    <?php if ($current_array[0]['game_style_2_id'] == $item['style_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['style_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-right strong">3 звено:</td>
                    <td>
                        <label class="hidden" for="tactic-3">tactic 3</label>
                        <select class="form-control" id="tactic-3" name="data[tactic_3_id]">
                            <?php foreach ($tactic_array as $item) { ?>
                                <option
                                    value="<?= $item['tactic_id']; ?>"
                                    <?php if ($current_array[0]['game_tactic_3_id'] == $item['tactic_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['tactic_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <label class="hidden" for="rude-3">rude 3</label>
                        <select class="form-control" id="rude-3" name="data[rude_3_id]">
                            <?php foreach ($rude_array as $item) { ?>
                                <option
                                    value="<?= $item['rude_id']; ?>"
                                    <?php if ($current_array[0]['game_rude_3_id'] == $item['rude_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['rude_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <label class="hidden" for="style-3">style 3</label>
                        <select class="form-control" id="style-3" name="data[style_3_id]">
                            <?php foreach ($style_array as $item) { ?>
                                <option
                                    value="<?= $item['style_id']; ?>"
                                    <?php if ($current_array[0]['game_style_3_id'] == $item['style_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['style_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row margin-top">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
                    Сила состава: <span class="strong span-power">0</span>
                    <br/>
                    Отпимальность позиций: <span class="strong span-position-percent">0</span>%
                    <br/>
                    Отпимальность состава: <span class="strong span-lineup-percent">0</span>%
                    <br/>
                    Сыгранность:
                    <span class="strong span-teamwork-1">0</span>%
                    |
                    <span class="strong span-teamwork-2">0</span>%
                    |
                    <span class="strong span-teamwork-3">0</span>%
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    Вратарь:
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <label for="line-0-0" class="hidden"></label>
                    <select class="form-control player-change" id="line-0-0" name="data[line][0][0]">
                        <option value="0">GK -</option>
                        <?php foreach ($gk_array as $item) { ?>
                            <option
                                value="<?= $item['player_id']; ?>"
                                <?php if ($gk_id == $item['player_id']) { ?>
                                    selected
                                <?php } ?>
                            >
                                <?= $item['position_short']; ?>
                                -
                                <?= TOURNAMENTTYPE_FRIENDLY == $current_array[0]['schedule_tournamenttype_id'] ? round($item['player_power_nominal'] * 0.75) : $item['player_power_real']; ?>
                                -
                                <?= $item['name_name']; ?>
                                <?= $item['surname_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php for($i=1; $i<=3; $i++) { ?>
                <?php
                if     (1 == $i) { $line = 'Первое'; }
                elseif (2 == $i) { $line = 'Второе'; }
                elseif (3 == $i) { $line = 'Третье'; }
                ?>
                <div class="row margin-top">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                        <?= $line; ?> звено:
                    </div>
                </div>
                <?php for ($j=1; $j<=5; $j++) { ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <label for="line-<?= $i; ?>-<?= $j; ?>"></label>
                            <select
                                class="form-control lineup-change player-change"
                                data-line="<?= $i; ?>"
                                data-position="<?= $j; ?>"
                                id="line-<?= $i; ?>-<?= $j; ?>"
                                name="data[line][<?= $i; ?>][<?= $j; ?>]"
                            ></select>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Сохранить" />
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover" id="grid">
                <thead>
                    <tr>
                        <th data-type="player">Игрок</th>
                        <th class="col-1 hidden-xs" data-type="country" title="Национальность">Нац</th>
                        <th data-type="position" title="Позиция">Поз</th>
                        <th class="hidden-xs" data-type="number" title="Возраст">В</th>
                        <th class="hidden-xs" data-type="number" title="Сила">С</th>
                        <th data-type="number" title="Усталость">У</th>
                        <th class="hidden-xs" data-type="phisical" title="Форма">Ф</th>
                        <th data-type="number" title="Реальная сила">РС</th>
                        <th data-type="string" title="Спецвозможности">Спец</th>
                        <th data-type="number" title="Играл/отдыхал подряд">ИО</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=0; foreach ($player_array as $item) { ?>
                        <tr class="tr-player" data-order="<?= $i; ?>" id="tr-<?= $item['player_id']; ?>">
                            <td<?php if ($item['line_color']) { ?> style="background-color: #<?= $item['line_color']; ?>"<?php } ?>>
                                <a href="/player_view.php?num=<?= $item['player_id']; ?>" target="_blank">
                                    <?= $item['name_name']; ?>
                                    <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td class="hidden-xs text-center">
                                <a href="/country_news.php?num=<?= $item['country_id']; ?>" target="_blank">
                                    <img
                                        alt="<?= $item['country_name']; ?>"
                                        src="/img/country/12/<?= $item['country_id']; ?>.png"
                                        title="<?= $item['country_name']; ?>"
                                    >
                                </a>
                            </td>
                            <td class="text-center"><?= f_igosja_player_position($item['player_id'], $playerposition_array); ?></td>
                            <td class="hidden-xs text-center"><?= $item['player_age']; ?></td>
                            <td class="hidden-xs text-center"><?= $item['player_power_nominal']; ?></td>
                            <td class="text-center"><?= TOURNAMENTTYPE_FRIENDLY == $current_array[0]['schedule_tournamenttype_id'] ? 25 : $item['player_tire']; ?></td>
                            <td class="hidden-xs text-center">
                                <?php if (TOURNAMENTTYPE_FRIENDLY == $current_array[0]['schedule_tournamenttype_id']) { ?>
                                    <img
                                        alt="100%"
                                        src="/img/phisical/16.png"
                                        title="100%"
                                    />
                                <?php } else { ?>
                                    <img
                                        alt="<?= $item['phisical_name']; ?>"
                                        src="/img/phisical/<?= $item['phisical_id']; ?>.png"
                                        title="<?= $item['phisical_name']; ?>"
                                    />
                                <?php } ?>
                            </td>
                            <td class="text-center"><?= TOURNAMENTTYPE_FRIENDLY == $current_array[0]['schedule_tournamenttype_id'] ? round($item['player_power_nominal'] * 0.75) : $item['player_power_real']; ?></td>
                            <td class="text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                            <td class="text-center"><?= $item['player_game_row']; ?></td>
                        </tr>
                    <?php $i++; } ?>
                </tbody>
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
</form>
<script>
    <?php for ($j=1; $j<=5; $j++) { ?>
        <?php
        $array      = '';
        $f_array    = array();

        if     (1 == $j) { $array = 'ld_array'; $f_array = $ld_array; }
        elseif (2 == $j) { $array = 'rd_array'; $f_array = $rd_array; }
        elseif (3 == $j) { $array = 'lw_array'; $f_array = $lw_array; }
        elseif (4 == $j) { $array =  'c_array'; $f_array =  $c_array; }
        elseif (5 == $j) { $array = 'rw_array'; $f_array = $rw_array; }
        ?>
        var <?= $array; ?> =
        [
            <?php foreach ($f_array as $item) { ?>
                [
                    <?= $item['player_id']; ?>,
                    '<?= $item['position_short']; ?> - <?= TOURNAMENTTYPE_FRIENDLY == $current_array[0]['schedule_tournamenttype_id'] ? round($item['player_power_nominal'] * 0.75) : $item['player_power_real']; ?> - <?= $item['name_name']; ?> <?= $item['surname_name']; ?>'
                ],
            <?php } ?>
        ];
    <?php } ?>
    var ld_1_id = <?= $ld_1_id; ?>;
    var rd_1_id = <?= $rd_1_id; ?>;
    var lw_1_id = <?= $lw_1_id; ?>;
    var  c_1_id =  <?= $c_1_id; ?>;
    var rw_1_id = <?= $rw_1_id; ?>;
    var ld_2_id = <?= $ld_2_id; ?>;
    var rd_2_id = <?= $rd_2_id; ?>;
    var lw_2_id = <?= $lw_2_id; ?>;
    var  c_2_id =  <?= $c_2_id; ?>;
    var rw_2_id = <?= $rw_2_id; ?>;
    var ld_3_id = <?= $ld_3_id; ?>;
    var rd_3_id = <?= $rd_3_id; ?>;
    var lw_3_id = <?= $lw_3_id; ?>;
    var  c_3_id =  <?= $c_3_id; ?>;
    var rw_3_id = <?= $rw_3_id; ?>;
</script>