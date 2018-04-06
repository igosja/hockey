<?php
/**
 * @var $count_page integer
 * @var $count_transfer integer
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $rating_minus_array array
 * @var $rating_plus_array array
 * @var $transfer_array array
 * @var $total integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Список хоккеистов, проданных на трансфере
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/transfer_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Всего сделок: <?= $total; ?>
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
                <th title="Минимальная запрашиваемая цена">Цена</th>
                <th title="Оценка сделки менеджерами">+/-</th>
            </tr>
            <?php for ($i=0; $i<$count_transfer; $i++) { ?>
                <tr>
                    <td class="text-center"><?= $offset + $i + 1; ?></td>
                    <td>
                        <a href="/transfer_view.php?num=<?= $transfer_array[$i]['transfer_id']; ?>">
                            <?= $transfer_array[$i]['name_name']; ?> <?= $transfer_array[$i]['surname_name']; ?>
                        </a>
                    </td>
                    <td class="hidden-xs text-center">
                        <a href="/country_news.php?num=<?= $transfer_array[$i]['pl_country_id']; ?>">
                            <img
                                alt="<?= $transfer_array[$i]['pl_country_name']; ?>"
                                src="/img/country/12/<?= $transfer_array[$i]['pl_country_id']; ?>.png"
                                title="<?= $transfer_array[$i]['pl_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_player_position($transfer_array[$i]['transfer_id'], $playerposition_array); ?>
                    </td>
                    <td class="text-center">
                        <?= $transfer_array[$i]['transfer_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $transfer_array[$i]['transfer_power']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= f_igosja_player_special($transfer_array[$i]['transfer_id'], $playerspecial_array); ?>
                    </td>
                    <td class="hidden-xs">
                        <a href="/team_view.php?num=<?= $transfer_array[$i]['steam_id']; ?>">
                            <?= $transfer_array[$i]['steam_name']; ?>
                        </a>
                    </td>
                    <td class="hidden-xs">
                        <a href="/team_view.php?num=<?= $transfer_array[$i]['bteam_id']; ?>">
                            <?= $transfer_array[$i]['bteam_name']; ?>
                        </a>
                    </td>
                    <td class="text-right <?php if ($transfer_array[$i]['transfer_cancel']) { ?>del<?php } ?>">
                        <?= f_igosja_money_format($transfer_array[$i]['transfer_price_buyer']); ?>
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
                <th title="Минимальная запрашиваемая цена">Цена</th>
                <th title="Оценка сделки менеджерами">+/-</th>
            </tr>
        </table>
    </div>
</div>
<?php include(__DIR__ . '/include/pagination.php'); ?>