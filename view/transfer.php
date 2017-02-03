<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Список хоккеистов, выставленных на трансфер
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-hover">
            <tr>
                <th>№</th>
                <th>Игрок</th>
                <th class="col-1">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Команда</th>
                <th title="Минимальная запрашиваемая цена">Цена</th>
            </tr>
            <?php for ($i=0; $i<$count_transfer; $i++) { ?>
                <tr>
                    <td class="text-center"><?= $i + 1; ?></td>
                    <td>
                        <a href="/player_transfer.php?num=<?= $transfer_array[$i]['player_id']; ?>">
                            <?= $transfer_array[$i]['name_name']; ?> <?= $transfer_array[$i]['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="/country_news.php?num=<?= $transfer_array[$i]['pl_country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $transfer_array[$i]['pl_country_id']; ?>.png"
                                title="<?= $transfer_array[$i]['pl_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_player_position($transfer_array[$i]['player_id']); ?>
                    </td>
                    <td class="text-center">
                        <?= $transfer_array[$i]['player_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $transfer_array[$i]['player_power_nominal']; ?>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_player_special($transfer_array[$i]['player_id']); ?>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $transfer_array[$i]['team_id']; ?>">
                            <?= $transfer_array[$i]['team_name']; ?>
                            (<?= $transfer_array[$i]['city_name']; ?>, <?= $transfer_array[$i]['t_country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-right">
                        <?= f_igosja_money($transfer_array[$i]['transfer_price_buyer']); ?>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th>№</th>
                <th>Игрок</th>
                <th>Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Команда</th>
                <th title="Минимальная запрашиваемая цена">Цена</th>
            </tr>
        </table>
    </div>
</div>