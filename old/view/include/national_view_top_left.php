<?php
/**
 * @var $auth_user_id integer
 * @var $num_get integer
 * @var $national_array integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        <?= $national_array[0]['country_name']; ?>
        (<?= $national_array[0]['nationaltype_name']; ?>)
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
        Дивизон:
        <a href="/worldcup.php?division_id=<?= $national_array[0]['division_id']; ?>">
            <?= $national_array[0]['division_name']; ?>,
            <?= $national_array[0]['worldcup_place']; ?> место
        </a>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Менеджер:
        <?php if (isset($auth_user_id) && $national_array[0]['user_id'] && $national_array[0]['user_id'] != $auth_user_id) { ?>
            <a href="/dialog.php?num=<?= $national_array[0]['user_id']; ?>">
                <img src="/img/letter.png" title="Написать письмо" />
            </a>
        <?php } ?>
        <a class="strong" href="/user_view.php?num=<?= $national_array[0]['user_id']; ?>">
            <?php if ($national_array[0]['user_name'] || $national_array[0]['user_surname']) { ?>
                <?= $national_array[0]['user_name']; ?> <?= $national_array[0]['user_surname']; ?>
            <?php } else { ?>
                Новый менеджер
            <?php } ?>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Ник:
        <?= f_igosja_user_vip($national_array[0]['user_date_vip']); ?>
        <a class="strong" href="/user_view.php?num=<?= $national_array[0]['user_id']; ?>">
            <?= $national_array[0]['user_login']; ?>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Заместитель:
        <?php if (isset($auth_user_id) && $national_array[0]['vice_user_id'] && $national_array[0]['vice_user_id'] != $auth_user_id) { ?>
            <a href="/dialog.php?num=<?= $national_array[0]['vice_user_id']; ?>">
                <img src="/img/letter.png" title="Написать письмо" />
            </a>
        <?php } ?>
        <a class="strong" href="/user_view.php?num=<?= $national_array[0]['vice_user_id']; ?>">
            <?php if ($national_array[0]['vice_user_name'] || $national_array[0]['vice_user_surname']) { ?>
                <?= $national_array[0]['vice_user_name']; ?> <?= $national_array[0]['vice_user_surname']; ?>
            <?php } else { ?>
                Новый менеджер
            <?php } ?>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Ник:
        <?= f_igosja_user_vip($national_array[0]['vice_user_date_vip']); ?>
        <a class="strong" href="/user_view.php?num=<?= $national_array[0]['vice_user_id']; ?>">
            <?= $national_array[0]['vice_user_login']; ?>
        </a>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Стадион:
        <?= $national_array[0]['stadium_name']; ?>,
        <strong><?= $national_array[0]['stadium_capacity']; ?></strong>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Финансы:
        <span class="strong"><?= f_igosja_money_format($national_array[0]['national_finance']); ?></span>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Рейтинг тренера:
        <span class="font-green"><?= $rating_positive; ?>%</span>
        |
        <span class="font-yellow"><?= $rating_neutral; ?>%</span>
        |
        <span class="font-red"><?= $rating_negative; ?>%</span>
    </div>
</div>