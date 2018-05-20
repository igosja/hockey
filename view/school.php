<?php
/**
 * @var $baseschool_array array
 * @var $cancel_array array
 * @var $cancel_get integer
 * @var $confirm_data array
 * @var $count_school integer
 * @var $on_building boolean
 * @var $player_array array
 * @var $position_array array
 * @var $school_available integer
 * @var $special_field_array array
 * @var $special_gk_array array
 * @var $style_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Спортшкола
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Уровень:
                <span class="strong"><?= $baseschool_array[0]['baseschool_level']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Время подготовки игрока:
                <span class="strong"><?= $baseschool_array[0]['baseschool_school_speed']; ?></span> туров
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Осталось юниоров:
                <span class="strong"><?= $school_available; ?></span>
                из
                <span class="strong"><?= $baseschool_array[0]['baseschool_player_count']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Из них со спецвозможностью:
                <span class="strong"><?= $baseschool_array[0]['baseschool_with_special']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($on_building) { ?> del<?php } ?>">
                Из них со стилем:
                <span class="strong"><?= $baseschool_array[0]['baseschool_with_style']; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в спортшколе</span> -
        вы можете подготовить молодых игроков для основной команды:
    </div>
</div>
<?php if (isset($confirm_data['position']['id'])) { ?>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Начнется подготовка юниора:
                <ul>
                    <li>позиция - <?= $confirm_data['position']['name']; ?></li>
                    <li>спецвозможность - <?= $confirm_data['special']['name']; ?></li>
                    <li>стиль - <?= $confirm_data['style']['name']; ?></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input name="data[position_id]" type="hidden" value="<?= $confirm_data['position']['id']; ?>" />
                <input name="data[special_field_id]" type="hidden" value="<?= $confirm_data['special']['id']; ?>" />
                <input name="data[special_gk_id]" type="hidden" value="<?= $confirm_data['special']['id']; ?>" />
                <input name="data[with_special]" type="hidden" value="<?= $confirm_data['special']['with']; ?>" />
                <input name="data[style_id]" type="hidden" value="<?= $confirm_data['style']['id']; ?>" />
                <input name="data[with_style]" type="hidden" value="<?= $confirm_data['style']['with']; ?>" />
                <input name="data[ok]" type="hidden" value="1">
                <input class="btn margin" type="submit" value="Начать подготовку"/>
                <a href="/school.php" class="btn margin">Отказаться</a>
            </div>
        </div>
    </form>
<?php } elseif (isset($cancel_array)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Будут отменены подготовка юниора:
            <ul>
                <li>позиция - <?= $cancel_array[0]['position_short']; ?></li>
                <li>спецвозможность - <?= $cancel_array[0]['special_name']; ?></li>
                <li>стиль - <?= $cancel_array[0]['style_name']; ?></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/school.php?cancel=<?= $cancel_get; ?>&ok=1" class="btn margin">Отменить подготовку</a>
            <a href="/school.php" class="btn margin">Вернуться</a>
        </div>
    </div>
<?php } else { ?>
    <?php if ($count_school) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                Сейчас происходит подготовка юниора:
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>Игрок</th>
                        <th class="col-1" title="Национальность">Нац</th>
                        <th class="col-5" title="Возраст">В</th>
                        <th class="col-15" title="Позиция">Поз</th>
                        <th class="col-15" title="Спецвозможности">Спец</th>
                        <th class="col-15">Стиль</th>
                        <th class="col-15">Осталось туров</th>
                        <th class="col-1"></th>
                    </tr>
                    <tr>
                        <td>Молодой игрок</td>
                        <td class="text-center">
                            <a href="/country_news.php?num=<?= $player_array[0]['country_id']; ?>">
                                <img
                                    alt="<?= $player_array[0]['country_name']; ?>"
                                    src="/img/country/12/<?= $player_array[0]['country_id']; ?>.png"
                                    title="<?= $player_array[0]['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="text-center">17</td>
                        <td class="text-center"><?= $school_array[0]['position_short']; ?></td>
                        <td class="text-center"><?= $school_array[0]['special_name']; ?></td>
                        <td class="text-center"><?= $school_array[0]['style_name']; ?></td>
                        <td class="text-center"><?= $school_array[0]['school_day']; ?></td>
                        <td class="text-center">
                            <a href="/school.php?cancel=<?= $school_array[0]['school_id']; ?>">
                                <img alt="Отменить подготовку юниора" src="/img/delete.png" title="Отменить подготовку юниора" />
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <?php } else { ?>
        <form method="POST">
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Игрок</th>
                            <th class="col-1" title="Национальность">Нац</th>
                            <th class="col-5" title="Возраст">В</th>
                            <th class="col-15" title="Позиция">Поз</th>
                            <th class="col-15" title="Спецвозможности">Спец</th>
                            <th class="col-15">Стиль</th>
                        </tr>
                        <tr>
                            <td>
                                Молодой игрок
                            </td>
                            <td class="text-center">
                                <a href="/country_news.php?num=<?= $player_array[0]['country_id']; ?>">
                                    <img
                                        alt="<?= $player_array[0]['country_name']; ?>"
                                        src="/img/country/12/<?= $player_array[0]['country_id']; ?>.png"
                                        title="<?= $player_array[0]['country_name']; ?>"
                                    />
                                </a>
                            </td>
                            <td class="text-center">17</td>
                            <td class="text-center">
                                <label class="hidden" for="school-position">Position</label>
                                <select class="form-control" id="school-position" name="data[position_id]">
                                    <option value="0">-</option>
                                    <?php foreach ($position_array as $item) { ?>
                                        <option value="<?= $item['position_id']; ?>">
                                            <?= $item['position_short']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center">
                                <label class="hidden" for="school-special-field">Special</label>
                                <select class="form-control" id="school-special-field" name="data[special_field_id]">
                                    <option value="0">-</option>
                                    <?php foreach ($special_field_array as $item) { ?>
                                        <option value="<?= $item['special_id']; ?>">
                                            <?= $item['special_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                                <label class="hidden" for="school-special-gk">Special</label>
                                <select class="form-control" id="school-special-gk" name="data[special_gk_id]">
                                    <option value="0">-</option>
                                    <?php foreach ($special_gk_array as $item) { ?>
                                        <option value="<?= $item['special_id']; ?>">
                                            <?= $item['special_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td class="text-center">
                                <label class="hidden" for="school-style">Style</label>
                                <select class="form-control" id="school-style" name="data[style_id]">
                                    <option value="0">-</option>
                                    <?php foreach ($style_array as $item) { ?>
                                        <option value="<?= $item['style_id']; ?>">
                                            <?= $item['style_name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Продолжить" />
                </div>
            </div>
        </form>
    <?php } ?>
<?php } ?>