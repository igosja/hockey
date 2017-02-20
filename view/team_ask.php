<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Получение команды</h1>
    </div>
</div>
<?php if ($teamask_array[0]['count']) { ?>
    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert success">
            Ваша заявка рассматривается администратором
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Страна</th>
                <th class="hidden-xs" title="Дивизион, в котором выступает команда">Див</th>
                <th class="hidden-xs">База</th>
                <th class="hidden-xs">Стадион</th>
                <th class="hidden-xs">Финансы</th>
                <th class="hidden-xs" title="Рейтинг силы с учетом спецвозможностей">Vs</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <a href="/team_ask.php?num=<?= $item['team_id']; ?>">
                            <img src="/img/check.png"/>
                        </a>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                        </a>
                    </td>
                    <td class="xs-text-center">
                        <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png"/>
                            <span class="hidden-xs">
                                <?= $item['country_name']; ?>
                            </span>
                        </a>
                    </td>
                    <td class="hidden-xs text-center">
                        <?php if ($item['division_id']) { ?>
                            <a href="/championship.php?country_id=<?= $item['country_id']; ?>&division_id=<?= $item['division_id']; ?>">
                                <?= $item['division_name']; ?>
                            </a>
                        <?php } else { ?>
                            <a href="/conference_table.php">КЛК</a>
                        <?php } ?>
                    </td>
                    <td class="hidden-xs text-center"><?= $item['base_slot_used']; ?> из <?= $item['base_slot_max']; ?></td>
                    <td class="hidden-xs text-right"><?= $item['stadium_capacity']; ?></td>
                    <td class="hidden-xs text-right"><?= f_igosja_money($item['team_finance']); ?></td>
                    <td class="hidden-xs text-right"><?= $item['team_power_vs']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Страна</th>
                <th class="hidden-xs" title="Дивизион, в котором выступает команда">Див</th>
                <th class="hidden-xs">База</th>
                <th class="hidden-xs">Стадион</th>
                <th class="hidden-xs">Финансы</th>
                <th class="hidden-xs" title="Рейтинг силы с учетом спецвозможностей">Vs</th>
            </tr>
        </table>
    </div>
</div>