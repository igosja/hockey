<?php
/**
 * @var $count_rent integer
 * @var $num_get integer
 * @var $playerposition_array array
 * @var $playerspecial_array array
 * @var $rating_minus_array array
 * @var $rating_my integer
 * @var $rating_plus_array array
 * @var $rent_array array
 * @var $rentapplication_array array
 * @var $rentcomment_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Арендная сделка
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/rent_link.php'); ?>
    </div>
</div>
<?php if (0 == $rating_my) { ?>
    <div class="row text-center margin">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="/rent_rating_plus.php?num=<?= $num_get; ?>">Честная сделка</a>
            |
            <a class="reject" href="javascript:">Нечестная сделка</a>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Игрок:
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <img
                    alt="<?= $rent_array[0]['pl_country_id']; ?>"
                    src="/img/country/12/<?= $rent_array[0]['pl_country_id']; ?>.png"
                    title="<?= $rent_array[0]['pl_country_id']; ?>"
                />
                <a href="/player_view.php?num=<?= $rent_array[0]['player_id']; ?>">
                    <?= $rent_array[0]['name_name']; ?>
                    <?= $rent_array[0]['surname_name']; ?>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Возраст:
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <?= $rent_array[0]['rent_age']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Позиция:
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <?= f_igosja_player_position($rent_array[0]['rent_id'], $playerposition_array); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Сила:
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <?= $rent_array[0]['rent_power']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Спецвозможности:
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <?= f_igosja_player_special($rent_array[0]['rent_id'], $playerspecial_array); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Оценка сделки (+/-):
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <span class="font-green"><?= $rating_plus_array[0]['rating']; ?></span>
                |
                <span class="font-red"><?= $rating_minus_array[0]['rating']; ?></span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Дата аренды:
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <?= f_igosja_ufu_date($rent_array[0]['rent_date']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Стоимость аренды:
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong <?php if ($rent_array[0]['rent_cancel']) { ?>del<?php } ?>">
                <?= f_igosja_money_format($rent_array[0]['rent_price_buyer']); ?>
                (<?= $rent_array[0]['rent_day']; ?> <?= f_igosja_count_case($rent_array[0]['rent_day'], 'день', 'дня', 'дней'); ?>)
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Продавец (команда):
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <a href="/team_view.php?num=<?= $rent_array[0]['steam_id']; ?>">
                    <?= $rent_array[0]['steam_name']; ?>
                    <span class="hidden-xs">
                        (<?= $rent_array[0]['scity_name']; ?>, <?= $rent_array[0]['scountry_name']; ?>)
                    </span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Продавец (менеджер):
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <a href="/user_view.php?num=<?= $rent_array[0]['suser_id']; ?>">
                    <?= $rent_array[0]['suser_login']; ?>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Покупатель (команда):
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <a href="/team_view.php?num=<?= $rent_array[0]['bteam_id']; ?>">
                    <?= $rent_array[0]['bteam_name']; ?>
                    <span class="hidden-xs">
                        (<?= $rent_array[0]['bcity_name']; ?>, <?= $rent_array[0]['bcountry_name']; ?>)
                    </span>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                Покупатель (менеджер):
            </div>
            <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                <a href="/user_view.php?num=<?= $rent_array[0]['buser_id']; ?>">
                    <?= $rent_array[0]['buser_login']; ?>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Команда</th>
                <th class="hidden-xs">Менеджер</th>
                <th>Время</th>
                <th>Дней</th>
                <th>Цена</th>
            </tr>
            <?php foreach ($rentapplication_array as $item) { ?>
                <tr <?php if ($item['team_id'] == $transfer_array[0]['bteam_id']) { ?>class="info"<?php } ?>>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            <span class="hidden-xs">
                                (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                            </span>
                        </a>
                    </td>
                    <td class="hidden-xs">
                        <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_ufu_date_time($item['rentapplication_date']); ?>
                    </td>
                    <td class="text-center">
                        <?= $item['rentapplication_day']; ?>
                    </td>
                    <td class="text-right">
                        <?= f_igosja_money_format($item['rentapplication_price'] * $item['rentapplication_day']); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<?php if ($rentcomment_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <?php foreach ($rentcomment_array as $item) { ?>
        <div class="row border-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                <a class="strong" href="/user_view.php?num=<?= $item['user_id']; ?>">
                    <?= $item['user_login']; ?>
                </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= nl2br($item['rentcomment_text']); ?>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
                <?= f_igosja_ufu_date_time($item['rentcomment_date']); ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if (0 == $rating_my) { ?>
    <div class="deal-comment-block">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                <label for="rentcomment">Ваш комментарий:</label>
            </div>
        </div>
        <form action="/rent_rating_minus.php?num=<?= $num_get; ?>" id="rentcomment-form" method="POST">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" id="rentcomment" name="data[text]" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center rentcomment-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <button class="btn margin">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
<?php } ?>