<?php
/**
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $rent_buy_array array
 * @var $rent_sell_array array
 * @var $transfer_buy_array array
 * @var $transfer_sell_array array
 * @var $team_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Сделки менеджера
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
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
                        <?= f_igosja_money_format($item['team_price_total']); ?>
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="10">Проданы на трансфере</th>
            </tr>
            <tr>
                <th>Дата</th>
                <th>Игрок</th>
                <th class="col-1">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Продавец</th>
                <th>Покупатель</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($transfer_sell_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['transfer_date']); ?></td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td>
                        <a href="/country_news.php?num=<?= $item['player_country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $item['player_country_id']; ?>.png"
                                title="<?= $item['player_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['transfer_id'], $playerposition_array); ?></td>
                    <td class="text-center"><?= $item['transfer_age']; ?></td>
                    <td class="text-center"><?= $item['transfer_power']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['transfer_id'], $playerspecial_array); ?></td>
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
                    <td class="text-right"><?= f_igosja_money_format($item['transfer_price_buyer']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="10">Куплены на трансфере</th>
            </tr>
            <tr>
                <th>Дата</th>
                <th>Игрок</th>
                <th class="col-1">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Продавец</th>
                <th>Покупатель</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($transfer_buy_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['transfer_date']); ?></td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td>
                        <a href="/country_news.php?num=<?= $item['player_country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $item['player_country_id']; ?>.png"
                                title="<?= $item['player_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['transfer_id'], $playerposition_array); ?></td>
                    <td class="text-center"><?= $item['transfer_age']; ?></td>
                    <td class="text-center"><?= $item['transfer_power']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['transfer_id'], $playerspecial_array); ?></td>
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
                    <td class="text-right"><?= f_igosja_money_format($item['transfer_price_buyer']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="11">Отданы в аренду</th>
            </tr>
            <tr>
                <th>Дата</th>
                <th>Игрок</th>
                <th class="col-1">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Владелец</th>
                <th>Арендатор</th>
                <th>Срок</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($rent_sell_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['rent_date']); ?></td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td>
                        <a href="/country_news.php?num=<?= $item['player_country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $item['player_country_id']; ?>.png"
                                title="<?= $item['player_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['rent_id'], $playerposition_array); ?></td>
                    <td class="text-center"><?= $item['rent_age']; ?></td>
                    <td class="text-center"><?= $item['rent_power']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['rent_id'], $playerspecial_array); ?></td>
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
                    <td class="text-right"><?= f_igosja_money_format($item['rent_price_buyer']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="11">Взяты в аренду</th>
            </tr>
            <tr>
                <th>Дата</th>
                <th>Игрок</th>
                <th class="col-1">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Владелец</th>
                <th>Арендатор</th>
                <th>Срок</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($rent_buy_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['rent_date']); ?></td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?>
                            <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td>
                        <a href="/country_news.php?num=<?= $item['player_country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $item['player_country_id']; ?>.png"
                                title="<?= $item['player_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center"><?= f_igosja_player_position($item['rent_id'], $playerposition_array); ?></td>
                    <td class="text-center"><?= $item['rent_age']; ?></td>
                    <td class="text-center"><?= $item['rent_power']; ?></td>
                    <td class="text-center"><?= f_igosja_player_special($item['rent_id'], $playerspecial_array); ?></td>
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
                    <td class="text-right"><?= f_igosja_money_format($item['rent_price_buyer']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>