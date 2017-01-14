<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_top_right.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th colspan="2" rowspan="2">Статистический показатель</th>
                <th class="hidden-xs" colspan="3">Место</th>
            </tr>
            <tr>
                <th class="col-10 hidden-xs">в лиге</th>
                <th class="col-10 hidden-xs">в стране</th>
                <th class="col-10 hidden-xs">в дивизионе</th>
            </tr>
            <tr>
                <td>Рейтинг посещаемости:</td>
                <td class="col-10 text-center"><?= $rating_array[0]['team_visitor']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Вместимость стадиона:</td>
                <td class="text-center"><?= $rating_array[0]['stadium_capacity']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Зарплата игроков:</td>
                <td class="text-center"><?= f_igosja_money($rating_array[0]['team_salary']); ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Сумма сил сильнейших 16 игроков (c16):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_c_16']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Сумма сил сильнейшего 21 игрока (c21):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_c_21']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Сумма сил сильнейших 27 игроков (c27):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_c_27']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Средн. сила состава в длит. соревнованиях (V):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_v']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Сумма сил сильнейших 16 игроков с уч. спецвозм. (s16):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_s_16']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Сумма сил сильнейшего 21 игрока с уч. спецвозм. (s21):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_s_21']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Сумма сил сильнейших 27 игроков с уч. спецвозм. (s27):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_s_27']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Средн. сила состава с учетом спецвозможностей (Vs):</td>
                <td class="text-center"><?= $rating_array[0]['team_power_vs']; ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Стоимость базы:</td>
                <td class="text-center"><?= f_igosja_money($rating_array[0]['team_price_base']); ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Стоимость стадиона:</td>
                <td class="text-center"><?= f_igosja_money($rating_array[0]['team_price_stadium']); ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Стоимость игроков:</td>
                <td class="text-center"><?= f_igosja_money($rating_array[0]['team_price_player']); ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>В кассе команды:</td>
                <td class="text-center"><?= f_igosja_money($rating_array[0]['team_finance']); ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
            <tr>
                <td>Общая стоимость команды:</td>
                <td class="text-center"><?= f_igosja_money($rating_array[0]['team_price_total']); ?></td>
                <td class="hidden-xs text-center">10656</td>
                <td class="hidden-xs text-center">77</td>
                <td class="hidden-xs text-center">7</td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>