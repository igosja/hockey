<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Игрок</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <?php foreach ($shedule_array as $shedule) { ?>
                    <th><?= f_igosja_ufu_date($shedule['shedule_date']); ?></th>
                <?php } ?>
            </tr>
            <?php foreach ($player_array as $item) { ?>
                <tr class="phisical-change-row">
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['player_id']); ?></td>
                    <td class="text-center"><?= $item['player_age']; ?></td>
                    <td class="text-center"><?= $item['player_power_nominal']; ?></td>
                    <?php foreach ($item['phisical_array'] as $phisical) { ?>
                        <td
                            class="text-center <?= $phisical['class']; ?>"
                            data-phisical="<?= $phisical['phisical_id']; ?>"
                            data-player="<?= $phisical['player_id']; ?>"
                            data-shedule="<?= $phisical['shedule_id']; ?>"
                            id="<?= $phisical['id']; ?>"
                        >
                            <img
                                src="/img/phisical/<?= $phisical['phisical_id']; ?>.png"
                                title="<?= $phisical['phisical_value']; ?>%"
                            />
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
            <tr>
                <th>Игрок</th>
                <th title="Позиция">Поз</th>
                <th title="Возраст">В</th>
                <th title="Номинальная сила">С</th>
                <?php foreach ($shedule_array as $shedule) { ?>
                    <th><?= f_igosja_ufu_date($shedule['shedule_date']); ?></th>
                <?php } ?>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Показатели команды
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Последнее с форума
    </div>
</div>