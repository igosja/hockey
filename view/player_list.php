<?php
/**
 * @var $count_page integer
 * @var $count_player integer
 * @var $country_array array
 * @var $data array
 * @var $player_array array
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $position_array array
 * @var $total integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Список хоккеистов
        </h1>
    </div>
</div>
<form method="GET">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            Условия поиска:
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <select class="form-control" name="data[country_id]">
                <option value="">Национальность</option>
                <?php foreach ($country_array as $item) { ?>
                    <option
                        value="<?= $item['country_id']; ?>"
                        <?php if (isset($data['country_id']) && $data['country_id'] == $item['country_id']) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $item['country_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-5">
            <input
                class="form-control"
                name="data[name_name]"
                placeholder="Имя"
                <?php if (isset($data['name_name'])) { ?>
                    value="<?= $data['name_name']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-7">
            <input
                class="form-control"
                name="data[surname_name]"
                placeholder="Фамилия"
                <?php if (isset($data['surname_name'])) { ?>
                    value="<?= $data['surname_name']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <select class="form-control" name="data[position_id]">
                <option value="">Позиция</option>
                <?php foreach ($position_array as $item) { ?>
                    <option
                        value="<?= $item['position_id']; ?>"
                        <?php if (isset($data['position_id']) && $data['position_id'] == $item['position_id']) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $item['position_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <input
                class="form-control"
                name="data[age_min]"
                placeholder="Возраст, от"
                <?php if (isset($data['age_min'])) { ?>
                    value="<?= $data['age_min']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <input
                class="form-control"
                name="data[age_max]"
                placeholder="Возраст, до"
                <?php if (isset($data['age_max'])) { ?>
                    value="<?= $data['age_max']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <input
                class="form-control"
                name="data[power_min]"
                placeholder="Сила, от"
                <?php if (isset($data['power_min'])) { ?>
                    value="<?= $data['power_min']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <input
                class="form-control"
                name="data[power_max]"
                placeholder="Сила, до"
                <?php if (isset($data['power_max'])) { ?>
                    value="<?= $data['power_max']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <input
                class="form-control"
                name="data[price_min]"
                placeholder="Цена, от"
                <?php if (isset($data['price_min'])) { ?>
                    value="<?= $data['price_min']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <input
                class="form-control"
                name="data[price_max]"
                placeholder="Цена, до"
                <?php if (isset($data['price_max'])) { ?>
                    value="<?= $data['price_max']; ?>"
                <?php } ?>
            />
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <input class="form-control submit-blue" type="submit" value="Поиск" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            Всего игроков: <?= $total; ?>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 text-right">
            Страница:
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <select class="form-control" name="page" id="page">
                <?php for ($i=1; $i<=$count_page; $i++) { ?>
                    <option
                        value="<?= $i; ?>"
                        <?php if ($page == $i) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $i; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>№</th>
                <th>Игрок</th>
                <th class="hidden-xs col-1">Нац</th>
                <th>Поз</th>
                <th>В</th>
                <th>С</th>
                <th class="hidden-xs">Спец</th>
                <th>Команда</th>
                <th class="hidden-xs">Цена</th>
            </tr>
            <?php for ($i=0; $i<$count_player; $i++) { ?>
                <tr>
                    <td class="text-center"><?= $offset + $i + 1; ?></td>
                    <td>
                        <a href="/player_view.php?num=<?= $player_array[$i]['player_id']; ?>">
                            <?= $player_array[$i]['name_name']; ?> <?= $player_array[$i]['surname_name']; ?>
                        </a>
                    </td>
                    <td class="hidden-xs text-center">
                        <a href="/country_news.php?num=<?= $player_array[$i]['pl_country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $player_array[$i]['pl_country_id']; ?>.png"
                                title="<?= $player_array[$i]['pl_country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_player_position($player_array[$i]['player_id'], $playerposition_array); ?>
                    </td>
                    <td class="text-center">
                        <?= $player_array[$i]['player_age']; ?>
                    </td>
                    <td class="text-center">
                        <?= $player_array[$i]['player_power_nominal']; ?>
                    </td>
                    <td class="hidden-xs text-center">
                        <?= f_igosja_player_special($player_array[$i]['player_id'], $playerspecial_array); ?>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $player_array[$i]['team_id']; ?>">
                            <?= $player_array[$i]['team_name']; ?>
                            (<?= $player_array[$i]['city_name']; ?>, <?= $player_array[$i]['t_country_name']; ?>)
                        </a>
                    </td>
                    <td class="hidden-xs text-right">
                        <?= f_igosja_money($player_array[$i]['player_price']); ?>
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
                <th>Команда</th>
                <th class="hidden-xs">Цена</th>
            </tr>
        </table>
    </div>
</div>