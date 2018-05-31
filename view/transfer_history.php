<?php
/**
 * @var $count_page integer
 * @var $country_array array
 * @var $count_transfer integer
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $position_array array
 * @var $rating_minus_array array
 * @var $rating_plus_array array
 * @var $total integer
 * @var $transfer_array array
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
<form method="GET">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
            Условия поиска:
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
            <label class="hidden" for="country_id">Национальность</label>
            <select class="form-control" id="country_id" name="data[country_id]">
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
            <label class="hidden" for="position_id">Национальность</label>
            <select class="form-control" id="position_id" name="data[position_id]">
                <option value="">Позиция</option>
                <?php foreach ($position_array as $item) { ?>
                    <option
                        value="<?= $item['position_id']; ?>"
                        <?php if (isset($data['position_id']) && $data['position_id'] == $item['position_id']) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $item['position_short']; ?>
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
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Всего сделок: <?= $total; ?>
        </div>
    </div>
</form>
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
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>
<?php include(__DIR__ . '/include/pagination.php'); ?>