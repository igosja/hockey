<?php

/**
 * @var $country_array array
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
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Президент:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Имя
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Последний визит:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Время
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Рейтинг президента:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Рейтинг
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