<?php

/**
 * @var $country_array array
 * @var $file_name string
 */

?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>
            <?= $country_array[0]['country_name']; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/country_table_link.php'); ?>
    </div>
</div>
<?php if ('country_national' == $file_name) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php include(__DIR__ . '/country_table_national_link.php'); ?>
        </div>
    </div>
<?php } ?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Президент:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php if ($country_array[0]['president_id']) { ?>
            <a href="/user_view.php?num=<?= $country_array[0]['president_id']; ?>">
                <?= $country_array[0]['president_login']; ?>
            </a>
        <?php } else { ?>
            -
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Последний визит:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?= f_igosja_ufu_last_visit($country_array[0]['president_date_login']); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Рейтинг президента:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <span class="font-green"><?= $country_array[0]['rating_positive']; ?>%</span>
        |
        <span class="font-yellow"><?= 100 - $country_array[0]['rating_positive'] - $country_array[0]['rating_negative']; ?>%</span>
        |
        <span class="font-red"><?= $country_array[0]['rating_negative']; ?>%</span>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Заместитель президента:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php if ($country_array[0]['vice_id']) { ?>
            <a href="/user_view.php?num=<?= $country_array[0]['vice_id']; ?>">
                <?= $country_array[0]['vice_login']; ?>
            </a>
        <?php } else { ?>
            -
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Последний визит:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?= f_igosja_ufu_last_visit($country_array[0]['vice_date_login']); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Фонд федерации:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?= f_igosja_money($country_array[0]['country_finance']); ?>
    </div>
</div>