<?php if (isset($confirm_data)) { ?>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Будут проведены следующие тренировки:
                <ul>
                    <?php foreach ($confirm_data['power'] as $item) { ?>
                        <li><?= $item['name']; ?> +1 балл силы</li>
                        <input name="data[power][player_id]" type="hidden" value="<?= $item['id']; ?>">
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input name="data[ok]" type="hidden" value="1">
                <input class="btn margin" type="submit" value="Начать тренировку"/>
                <a href="/training.php" class="btn margin">Отказаться</a>
            </div>
        </div>
    </form>
<?php } ?>
<form method="POST">
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th title="Национальность" class="col-1">Нац</th>
                    <th title="Возраст">В</th>
                    <th title="Позиция">Поз</th>
                    <th title="Номинальная сила">С</th>
                    <th title="Спецвозможности">Спец</th>
                </tr>
                <?php foreach ($player_array as $item) { ?>
                    <tr>
                        <td>
                            <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                                <?= $item['name_name']; ?>
                                <?= $item['surname_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/country_view.php?num=<?= $item['country_id']; ?>">
                                <img
                                    src="/img/country/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_name']; ?>"
                                />
                            </a>
                        </td>
                        <td class="text-center"><?= $item['player_age']; ?></td>
                        <td class="text-center"><?= f_igosja_player_position($item['player_id']); ?></td>
                        <td class="text-center">
                            <?= $item['player_power_nominal']; ?>
                            <input name="data[power][player_id]" type="checkbox" value="<?= $item['player_id']; ?>" />
                        </td>
                        <td class="text-center"><?= f_igosja_player_special($item['player_id']); ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Игрок</th>
                    <th title="Национальность">Нац</th>
                    <th title="Возраст">В</th>
                    <th title="Позиция">Поз</th>
                    <th title="Номинальная сила">С</th>
                    <th title="Спецвозможности">Спец</th>
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