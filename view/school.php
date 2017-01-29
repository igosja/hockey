<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Спортшкола
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Уровень:
                <span class="strong"><?= $baseschool_array[0]['baseschool_level']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Время подготовки игрока:
                <span class="strong"><?= $baseschool_array[0]['baseschool_school_speed']; ?></span> туров
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось юниоров:
                <span class="strong"><?= $baseschool_array[0]['baseschool_player_count']; ?></span>
                из
                <span class="strong"><?= $baseschool_array[0]['baseschool_player_count']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Из них со спецвозможностью:
                <span class="strong"><?= $baseschool_array[0]['baseschool_with_special']; ?></span>
                из
                <span class="strong"><?= $baseschool_array[0]['baseschool_with_special']; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Из них со стилем:
                <span class="strong"><?= $baseschool_array[0]['baseschool_with_style']; ?></span>
                из
                <span class="strong"><?= $baseschool_array[0]['baseschool_with_style']; ?></span>
            </div>
        </div>
    </div>
</div>
<?php if (isset($confirm_data['position']['id'])) { ?>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Начнется подготовка юниора:
                <ul>
                    <li><?= $confirm_data['position']['name']; ?></li>
                    <input name="data[position_id]" type="hidden" value="<?= $confirm_data['position']['id']; ?>">
                    <li><?= $confirm_data['special']['name']; ?></li>
                    <input name="data[special_id]" type="hidden" value="<?= $confirm_data['special']['id']; ?>">
                    <li><?= $confirm_data['style']['name']; ?></li>
                    <input name="data[style_id]" type="hidden" value="<?= $confirm_data['style']['id']; ?>">
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input name="data[ok]" type="hidden" value="1">
                <input class="btn margin" type="submit" value="Начать подготовку"/>
                <a href="/school.php" class="btn margin">Отказаться</a>
            </div>
        </div>
    </form>
<?php } ?>
<?php if ($school_sql->num_rows) { ?>
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
                </tr>
                <tr>
                    <td>Молодой игрок</td>
                    <td class="text-center">
                        <a href="/country_news.php?num=<?= $player_array[0]['country_id']; ?>">
                            <img
                                    src="/img/country/12/<?= $player_array[0]['country_id']; ?>.png"
                                    title="<?= $player_array[0]['country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center">17</td>
                    <td class="text-center"><?= $school_array[0]['position_name']; ?></td>
                    <td class="text-center"><?= $school_array[0]['special_name']; ?></td>
                    <td class="text-center"><?= $school_array[0]['style_name']; ?></td>
                    <td class="text-center"><?= $school_array[0]['school_day']; ?></td>
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
                                    src="/img/country/12/<?= $player_array[0]['country_id']; ?>.png"
                                    title="<?= $player_array[0]['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="text-center">17</td>
                        <td class="text-center">
                            <select name="data[position_id]">
                                <option value="0"></option>
                                <?php foreach ($position_array as $item) { ?>
                                    <option value="<?= $item['position_id']; ?>">
                                        <?= $item['position_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td class="text-center">
                            <select name="data[special_id]">
                                <option value="0"></option>
                                <?php foreach ($special_array as $item) { ?>
                                    <option value="<?= $item['special_id']; ?>">
                                        <?= $item['special_name']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                        <td class="text-center">
                            <select name="data[style_id]">
                                <option value="0"></option>
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