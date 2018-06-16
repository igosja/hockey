<?php

/**
 * @var $my_team_array array
 */

?>
<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-size-2">
    <span class="italic">Показатели вашей команды:</span>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Рейтинг силы команды (Vs)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $my_team_array[0]['team_power_vs']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Сила 16 лучших (s16)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $my_team_array[0]['team_power_s_16']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Сила 21 лучшего (s21)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $my_team_array[0]['team_power_s_21']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Сила 27 лучших (s27)
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= $my_team_array[0]['team_power_s_27']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Стоимость строений
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= f_igosja_money_format($my_team_array[0]['team_price_base']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            - Общая стоимость
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
            <?= f_igosja_money_format($my_team_array[0]['team_price_total']); ?>
        </div>
    </div>
</div>