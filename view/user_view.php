<?php include(__DIR__ . '/include/user_profile.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Команда</th>
                <th class="col-20">Дивизион</th>
                <th class="col-10" title="Рейтинг силы команды">Vs</th>
                <th class="col-20">Стоимость</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr>
                    <td>
                        <a href="team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center">
                        <?php if ($item['division_id']) { ?>
                            <a href="/championship.php?country_id=<?= $item['country_id']; ?>&division_id=<?= $item['division_id']; ?>">
                                <?= $item['country_name']; ?>,
                                <?= $item['division_name']; ?>,
                                <?= $item['championship_place']; ?> место
                            </a>
                        <?php } else { ?>
                            <a href="/conference_table.php">
                                Конференция, <?= $item['conference_place']; ?> место
                            </a>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <?= $item['team_power_vs']; ?>
                    </td>
                    <td class="text-right">
                        <?= f_igosja_money($item['team_price_total']); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th>Команда</th>
                <th>Дивизион</th>
                <th title="Рейтинг силы команды">Vs</th>
                <th>Стоимость</th>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-3" title="Сезон">C</th>
                <th>Рейтинг</th>
                <th class="col-3-5" title="Игры">И</th>
                <th class="col-3-5" title="Победы">B</th>
                <th class="col-3-5" title="Победы в овертайме/по буллитам">BО</th>
                <th class="col-3-5" title="Поражения в овертайме/по буллитам/ничьи">ПО</th>
                <th class="col-3-5" title="Поражения">П</th>
                <th class="col-3-5" title="Выигранные коллизии">К+</th>
                <th class="col-3-5" title="Проигранные коллизии">К-</th>
                <th class="col-3-5" title="Победы у команд с супернастроем">ВС</th>
                <th class="col-3-5" title="Победы у сильных соперников">В+</th>
                <th class="col-3-5" title="Победы у равных соперников">В=</th>
                <th class="col-3-5" title="Победы у слабых соперников">В-</th>
                <th class="col-3-5" title="Победы в овертайме/по буллитам у сильных соперников">ВО+</th>
                <th class="col-3-5" title="Победы в овертайме/по буллитам у равных соперников">ВО=</th>
                <th class="col-3-5" title="Победы в овертайме/по буллитам у слабых соперников">ВО-</th>
                <th class="col-3-5" title="Поражения в овертайме/по буллитам/ничьи сильным соперникам">ПО+</th>
                <th class="col-3-5" title="Поражения в овертайме/по буллитам/ничьи равным соперникам">ПО=</th>
                <th class="col-3-5" title="Поражения в овертайме/по буллитам/ничьи слабым соперникам">ПО-</th>
                <th class="col-3-5" title="Поражения сильным соперникам">П+</th>
                <th class="col-3-5" title="Поражения равным соперникам">П=</th>
                <th class="col-3-5" title="Поражения слабым соперникам">П-</th>
                <th class="col-3-5" title="Поражения супернастроем">ПС</th>
                <th class="col-3-5" title="Автосоставы">А</th>
                <th class="col-3-5" title="Игры против супернастроя">VС</th>
                <th class="col-3-5" title="Игры против отдыха">VО</th>
            </tr>
            <?php foreach ($userrating_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['userrating_season_id']; ?></td>
                    <td class="text-center"><?= $item['userrating_rating']; ?></td>
                    <td class="text-center"><?= $item['userrating_game']; ?></td>
                    <td class="text-center"><?= $item['userrating_win']; ?></td>
                    <td class="text-center"><?= $item['userrating_winover']; ?></td>
                    <td class="text-center"><?= $item['userrating_looseover']; ?></td>
                    <td class="text-center"><?= $item['userrating_loose']; ?></td>
                    <td class="text-center"><?= $item['userrating_collision_win']; ?></td>
                    <td class="text-center"><?= $item['userrating_collision_loose']; ?></td>
                    <td class="text-center"><?= $item['userrating_win_super']; ?></td>
                    <td class="text-center"><?= $item['userrating_win_strong']; ?></td>
                    <td class="text-center"><?= $item['userrating_win_equal']; ?></td>
                    <td class="text-center"><?= $item['userrating_win_weak']; ?></td>
                    <td class="text-center"><?= $item['userrating_winover_strong']; ?></td>
                    <td class="text-center"><?= $item['userrating_winover_equal']; ?></td>
                    <td class="text-center"><?= $item['userrating_winover_weak']; ?></td>
                    <td class="text-center"><?= $item['userrating_looseover_strong']; ?></td>
                    <td class="text-center"><?= $item['userrating_looseover_equal']; ?></td>
                    <td class="text-center"><?= $item['userrating_looseover_weak']; ?></td>
                    <td class="text-center"><?= $item['userrating_loose_strong']; ?></td>
                    <td class="text-center"><?= $item['userrating_loose_equal']; ?></td>
                    <td class="text-center"><?= $item['userrating_loose_weak']; ?></td>
                    <td class="text-center"><?= $item['userrating_loose_super']; ?></td>
                    <td class="text-center"><?= $item['userrating_auto']; ?></td>
                    <td class="text-center"><?= $item['userrating_vs_super']; ?></td>
                    <td class="text-center"><?= $item['userrating_vs_rest']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th></th>
                <th><?= $userrating_total_array[0]['userrating_rating']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_game']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_win']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_winover']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_looseover']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_loose']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_collision_win']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_collision_loose']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_win_super']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_win_strong']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_win_equal']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_win_weak']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_winover_strong']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_winover_equal']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_winover_weak']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_looseover_strong']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_looseover_equal']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_looseover_weak']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_loose_strong']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_loose_equal']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_loose_weak']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_loose_super']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_auto']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_vs_super']; ?></th>
                <th><?= $userrating_total_array[0]['userrating_vs_rest']; ?></th>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-1" title="Сезон">С</th>
                <th class="col-15">Дата</th>
                <th>Событие</th>
            </tr>
            <?php foreach ($event_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['log_season_id']; ?></td>
                    <td class="text-center"><?= f_igosja_ufu_date($item['log_date']); ?></td>
                    <td><?= $item['logtext_name']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Сезон">С</th>
                <th>Дата</th>
                <th>Событие</th>
            </tr>
        </table>
    </div>
</div>