<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Список хоккеистов
        </h1>
    </div>
</div>
<form method="GET">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Условия поиска
            <input class="form-control" name="data[name_name]" placeholder="Имя" <?php if (isset($data['name_name'])) { ?>value="<?= $data['name_name']; ?>"<? } ?> />
            <input class="form-control" name="data[surname_name]" placeholder="Фамилия" <?php if (isset($data['surname_name'])) { ?>value="<?= $data['surname_name']; ?>"<? } ?> />
            <input class="form-control" name="data[position_id]" placeholder="Позиция" <?php if (isset($data['position_id'])) { ?>value="<?= $data['position_id']; ?>"<? } ?> />
            <input class="form-control" name="data[price_min]" placeholder="Цена, от" <?php if (isset($data['price_min'])) { ?>value="<?= $data['price_min']; ?>"<? } ?> />
            <input class="form-control" name="data[price_max]" placeholder="Цена, до" <?php if (isset($data['price_max'])) { ?>value="<?= $data['price_max']; ?>"<? } ?> />
            <input class="form-control" name="data[age_min]" placeholder="Возраст, от" <?php if (isset($data['age_min'])) { ?>value="<?= $data['age_min']; ?>"<? } ?> />
            <input class="form-control" name="data[age_max]" placeholder="Возраст, до" <?php if (isset($data['age_max'])) { ?>value="<?= $data['age_max']; ?>"<? } ?> />
            <input class="form-control" name="data[power_min]" placeholder="Сила, от" <?php if (isset($data['power_min'])) { ?>value="<?= $data['power_min']; ?>"<? } ?> />
            <input class="form-control" name="data[power_max]" placeholder="Сила, до" <?php if (isset($data['power_max'])) { ?>value="<?= $data['power_max']; ?>"<? } ?> />
            <input class="form-control" name="data[country_id]" placeholder="Национальность" <?php if (isset($data['country_id'])) { ?>value="<?= $data['country_id']; ?>"<? } ?> />
            <input class="form-control" type="submit" value="Поиск" />
        </div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th>№</th>
                <th>Игрок</th>
                <th class="col-1">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th>Спец</th>
                <th>Команда</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($player_array as $item) { ?>
                <tr>
                    <td class="text-center">1</td>
                    <td>
                        <a href="/player_view.php?num=<?= $item['player_id']; ?>">
                            <?= $item['name_name']; ?> <?= $item['surname_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="/country_view.php?num=<?= $item['pl_country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $item['pl_country_id']; ?>.png"
                                title="<?= $item['pl_country_id']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_player_position($item['player_id']); ?>
                    </td>
                    <td class="text-center">
                        <?= $item['player_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $item['player_power_nominal']; ?>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_player_special($item['player_id']); ?>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?> (<?= $item['city_name']; ?>, <?= $item['t_country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-right">
                        <?= f_igosja_money($item['player_price']); ?>
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
                <th>Цена</th>
            </tr>
        </table>
    </div>
</div>