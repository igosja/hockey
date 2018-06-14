<?php
/**
 * @var $teamask_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Получение команды</h1>
    </div>
</div>
<?php if ($teamask_array[0]['count']) { ?>
    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
            Ваша заявка рассматривается администратором
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <?php if ($teamask_array) { ?>
                <tr>
                    <th class="text-center" colspan="9">Ваши заявки</th>
                </tr>
                <tr>
                    <th></th>
                    <th>Команда</th>
                    <th>Страна</th>
                    <th class="hidden-xs" title="Дивизион, в котором выступает команда">Див</th>
                    <th class="hidden-xs">База</th>
                    <th class="hidden-xs">Стадион</th>
                    <th class="hidden-xs">Финансы</th>
                    <th class="hidden-xs" title="Рейтинг силы команды в длительных соревнованиях">Vs</th>
                    <th title="Число заявок">ЧЗ</th>
                </tr>
                <?php foreach ($teamask_array as $item) { ?>
                    <tr>
                        <td class="text-center">
                            <a href="/team_ask_delete.php?num=<?= $item['teamask_id']; ?>">
                                <img alt="Удалить заявку" src="/img/delete.png" title="Удалить заявку" />
                            </a>
                        </td>
                        <td>
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td class="xs-text-center">
                            <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                                <img alt="<?= $item['country_name']; ?>" src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>" />
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
                        <td class="hidden-xs text-right"><?= f_igosja_money_format($item['team_finance']); ?></td>
                        <td class="hidden-xs text-right"><?= $item['team_power_vs']; ?></td>
                        <td class="text-center"><?= $item['teamask_count']; ?></td>
                    </tr>
                <?php } ?>
            <?php } ?>
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Страна</th>
                <th class="hidden-xs" title="Дивизион, в котором выступает команда">Див</th>
                <th class="hidden-xs">База</th>
                <th class="hidden-xs">Стадион</th>
                <th class="hidden-xs">Финансы</th>
                <th class="hidden-xs" title="Рейтинг силы команды в длительных соревнованиях">Vs</th>
                <th title="Число заявок">ЧЗ</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <a href="/team_ask.php?num=<?= $item['team_id']; ?>">
                            <img alt="Выбрать" src="/img/check.png" title="Выбрать" />
                        </a>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                        </a>
                    </td>
                    <td class="xs-text-center">
                        <a href="/country_news.php?num=<?= $item['country_id']; ?>">
                            <img alt="<?= $item['country_name']; ?>" src="/img/country/12/<?= $item['country_id']; ?>.png" title="<?= $item['country_name']; ?>" />
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
                    <td class="hidden-xs text-right"><?= f_igosja_money_format($item['team_finance']); ?></td>
                    <td class="hidden-xs text-right"><?= $item['team_power_vs']; ?></td>
                    <td class="text-center"><?= $item['teamask_count']; ?></td>
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
                <th class="hidden-xs" title="Рейтинг силы команды в длительных соревнованиях">Vs</th>
                <th title="Число заявок">ЧЗ</th>
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