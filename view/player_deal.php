<?php include(__DIR__ . '/include/player_view_top.php'); ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="9">Трансферы</th>
            </tr>
            <tr>
                <th>C</th>
                <th>Дата</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Продавец</th>
                <th>Покупатель</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($transfer_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['transfer_season_id']; ?></td>
                    <td class="text-center"><?= f_igosja_ufu_date($item['transfer_date']); ?></td>
                    <td class="text-center"><?= f_igosja_player_position($item['player_id']); ?></td>
                    <td class="text-center"><?= $item['transfer_age']; ?></td>
                    <td class="text-center"><?= $item['transfer_power']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['player_id']); ?></td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['seller_team_id']; ?>">
                            <?= $item['seller_team_name']; ?>
                            (<?= $item['seller_city_name']; ?>, <?= $item['seller_country_name']; ?>)
                        </a>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['buyer_team_id']; ?>">
                            <?= $item['buyer_team_name']; ?>
                            (<?= $item['buyer_city_name']; ?>, <?= $item['buyer_country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-right"><?= f_igosja_money($item['transfer_price_buyer']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="10">Аренда</th>
            </tr>
            <tr>
                <th>C</th>
                <th>Дата</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Владелец</th>
                <th>Арендатор</th>
                <th>Срок</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($rent_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['rent_season_id']; ?></td>
                    <td class="text-center"><?= f_igosja_ufu_date($item['rent_date']); ?></td>
                    <td class="text-center"><?= f_igosja_player_position($item['player_id']); ?></td>
                    <td class="text-center"><?= $item['rent_age']; ?></td>
                    <td class="text-center"><?= $item['rent_power']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['player_id']); ?></td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['seller_team_id']; ?>">
                            <?= $item['seller_team_name']; ?>
                            (<?= $item['seller_city_name']; ?>, <?= $item['seller_country_name']; ?>)
                        </a>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['buyer_team_id']; ?>">
                            <?= $item['buyer_team_name']; ?>
                            (<?= $item['buyer_city_name']; ?>, <?= $item['buyer_country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center"><?= $item['rent_day']; ?></td>
                    <td class="text-right"><?= f_igosja_money($item['rent_price_buyer']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>