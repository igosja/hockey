<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="2" rowspan="2">Статистический показатель</th>
                <th class="hidden-xs" colspan="3">Место</th>
            </tr>
            <tr>
                <th class="col-15 hidden-xs">в лиге</th>
                <th class="col-15 hidden-xs">в стране</th>
            </tr>
            <tr>
                <td>Рейтинг посещаемости:</td>
                <td class="col-10 text-center"><?= $rating_array[0]['team_visitor']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_visitor_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_visitor_place_country']; ?></td>
            </tr>
            <tr>
                <td>Вместимость стадиона:</td>
                <td class="text-center"><?= $rating_array[0]['stadium_capacity']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_stadium_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_stadium_place_country']; ?></td>
            </tr>
            <tr>
                <td>Средн. возраст игроков:</td>
                <td class="text-center"><?= $rating_array[0]['team_age']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_age_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_age_place_country']; ?></td>
            </tr>
            <tr>
                <td>Количество игроков:</td>
                <td class="text-center"><?= $rating_array[0]['player']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_player_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_player_place_country']; ?></td>
            </tr>
            <tr>
                <td>Средн. сила состава с учетом спецвозможностей (Vs):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_vs']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_power_vs_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_power_vs_place_country']; ?></td>
            </tr>
            <tr>
                <td>База:</td>
                <td class="text-center"><?= $rating_array[0]['base_level']; ?> (<?= $rating_array[0]['base_used']; ?>)</td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_base_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_base_place_country']; ?></td>
            </tr>
            <tr>
                <td>Стоимость базы:</td>
                <td class="text-center"><?= f_igosja_money_format($rating_array[0]['team_price_base']); ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_price_base_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_price_base_place_country']; ?></td>
            </tr>
            <tr>
                <td>Стоимость стадиона:</td>
                <td class="text-center"><?= f_igosja_money_format($rating_array[0]['team_price_stadium']); ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_price_stadium_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_price_stadium_place_country']; ?></td>
            </tr>
            <tr>
                <td>Общая стоимость команды:</td>
                <td class="text-center"><?= f_igosja_money_format($rating_array[0]['team_price_total']); ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_price_total_place']; ?></td>
                <td class="hidden-xs text-center"><?= $rating_array[0]['ratingteam_price_total_place_country']; ?></td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>