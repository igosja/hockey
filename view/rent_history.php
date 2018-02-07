<?php
/**
 * @var $count_rent integer
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $rating_minus_array array
 * @var $rating_plus_array array
 * @var $rent_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Список хоккеистов, отданных в аренду
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/rent_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-hover">
            <tr>
                <th>№</th>
                <th>Игрок</th>
                <th class="col-1 hidden-xs">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th class="hidden-xs">Спец</th>
                <th class="hidden-xs">Продавец</th>
                <th class="hidden-xs">Покупатель</th>
                <th title="Общая стоимость аренды">Цена
                <th title="Оценка сделки менеджерами">+/-</th>
            </tr>
            <?php for ($i=0; $i<$count_rent; $i++) { ?>
                <tr>
                    <td class="text-center"><?= $i + 1; ?></td>
                    <td>
                        <a href="/rent_view.php?num=<?= $rent_array[$i]['rent_id']; ?>">
                            <?= $rent_array[$i]['name_name']; ?> <?= $rent_array[$i]['surname_name']; ?>
                        </a>
                    </td>
                    <td class="hidden-xs text-center">
                        <a href="/country_news.php?num=<?= $rent_array[$i]['pl_country_id']; ?>">
                            <img
                                alt="<?= $rent_array[$i]['pl_country_name']; ?>"
                                src="/img/country/12/<?= $rent_array[$i]['pl_country_id']; ?>.png"
                                title="<?= $rent_array[$i]['pl_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_player_position($rent_array[$i]['rent_id'], $playerposition_array); ?>
                    </td>
                    <td class="text-center">
                        <?= $rent_array[$i]['rent_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $rent_array[$i]['rent_power']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= f_igosja_player_special($rent_array[$i]['rent_id'], $playerspecial_array); ?>
                    </td>
                    <td class="hidden-xs">
                        <a href="/team_view.php?num=<?= $rent_array[$i]['steam_id']; ?>">
                            <?= $rent_array[$i]['steam_name']; ?>
                        </a>
                    </td>
                    <td class="hidden-xs">
                        <a href="/team_view.php?num=<?= $rent_array[$i]['bteam_id']; ?>">
                            <?= $rent_array[$i]['bteam_name']; ?>
                        </a>
                    </td>
                    <td class="text-right <?php if ($rent_array[$i]['rent_cancel']) { ?>del<?php } ?>">
                        <?= f_igosja_money_format($rent_array[$i]['rent_price_buyer']); ?>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_deal_rating($transfer_array[$i]['transfer_id'], $rating_plus_array, $rating_minus_array, 'transfer'); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th>№</th>
                <th>Игрок</th>
                <th class="hidden-xs">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th class="hidden-xs">Спец</th>
                <th class="hidden-xs">Продавец</th>
                <th class="hidden-xs">Покупатель</th>
                <th title="Общая стоимость аренды">Цена</th>
                <th title="Оценка сделки менеджерами">+/-</th>
            </tr>
        </table>
    </div>
</div>