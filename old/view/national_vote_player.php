<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Состав сборной в заявке тренера</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th>Игрок</th>
                <th class="col-5" title="Позиция">Поз</th>
                <th class="col-5" title="Возраст">В</th>
                <th class="col-5" title="Номинальная сила">С</th>
                <th class="col-10 hidden-xs" title="Спецвозможности">Спец</th>
                <th class="col-40">Команда</th>
            </tr>
            <?php foreach ($player_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>" target="_blank">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['player_id'], $playerposition_array); ?></td>
                    <td class="text-center"><?= $item['player_age']; ?></td>
                    <td class="text-center"><?= $item['player_power_nominal']; ?></td>
                    <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                    <td>
                        <img
                                alt="<?= $item['country_name']; ?>"
                                src="/img/country/12/<?= $item['country_id']; ?>.png"
                                title="<?= $item['country_id']; ?>"
                        />
                        <a href="team_view.php?num=<?= $item['team_id']; ?>" target="_blank">
                            <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                        </a>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th>Игрок</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <th class="hidden-xs" title="Спецвозможности">Спец</th>
                <th>Команда</th>
            </tr>
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