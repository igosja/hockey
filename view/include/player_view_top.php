<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        <?= $player_array[0]['name_name']; ?> <?= $player_array[0]['surname_name']; ?>
    </div>
    <div class="row margin-top">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Национальность:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <img
                        src="/img/country/12/<?= $player_array[0]['country_id']; ?>.png"
                    />
                    <a href="/country_news.php?num=<?= $player_array[0]['country_id']; ?>">
                        <?= $player_array[0]['country_name']; ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Возраст:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_age']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Сила:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_power_nominal']; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Усталость:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_tire']; ?>%
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Форма на сегодня:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <img
                            src="/img/phisical/<?= $player_array[0]['phisical_id']; ?>.png"
                            title="<?= $player_array[0]['phisical_value']; ?>%"
                    />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Реальная сила:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= $player_array[0]['player_power_real']; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Команда:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <a href="/team_view.php?num=<?= $player_array[0]['team_id']; ?>">
                        <?= $player_array[0]['team_name']; ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Позиция:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_player_position($player_array[0]['player_id'], $playerposition_array); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Спецвозможности:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_player_special($player_array[0]['player_id'], $playerspecial_array); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Зарплата за тур:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_money($player_array[0]['player_salary']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Стоимость:
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <?= f_igosja_money($player_array[0]['player_salary']); ?>
                </div>
            </div>
        </div>
    </div>
</div>