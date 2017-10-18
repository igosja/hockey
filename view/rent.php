<?php
/**
 * @var $count_rent integer
 * @var $rent_array array
 * @var $playerposition_array array
 * @var $playerspecial_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Список хоккеистов, выставленных на аренду
        </h1>
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
                <th class="hidden-xs">Команда</th>
                <th title="Срок аренды (календарных дней)">Дней</th>
                <th title="Минимальная запрашиваемая цена за 1 день аренды">Цена</th>
            </tr>
            <?php for ($i=0; $i<$count_rent; $i++) { ?>
                <tr>
                    <td class="text-center"><?= $i + 1; ?></td>
                    <td>
                        <a href="/player_view.php?num=<?= $rent_array[$i]['player_id']; ?>">
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
                        <?= f_igosja_player_position($rent_array[$i]['player_id'], $playerposition_array); ?>
                    </td>
                    <td class="text-center">
                        <?= $rent_array[$i]['player_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $rent_array[$i]['player_power_nominal']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= f_igosja_player_special($rent_array[$i]['player_id'], $playerspecial_array); ?>
                    </td>
                    <td class="hidden-xs">
                        <a href="/team_view.php?num=<?= $rent_array[$i]['team_id']; ?>">
                            <?= $rent_array[$i]['team_name']; ?>
                            (<?= $rent_array[$i]['city_name']; ?>, <?= $rent_array[$i]['t_country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center">
                        <?= $rent_array[$i]['rent_day_min']; ?>-<?= $rent_array[$i]['rent_day_max']; ?>
                    </td>
                    <td class="text-right">
                        <?= f_igosja_money($rent_array[$i]['rent_price_buyer']); ?>
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
                <th class="hidden-xs">Команда</th>
                <th title="Срок аренды (календарных дней)">Дней</th>
                <th title="Минимальная запрашиваемая цена за 1 день аренды">Цена</th>
            </tr>
        </table>
    </div>
</div>