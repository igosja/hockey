<?php
/**
 * @var $auth_team_id integer
 * @var $file_name string
 * @var $line_array array
 * @var $player_array array
 * @var $playerposition_array array
 * @var $playerspecial_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-size-1 strong">
                <?= $player_array[0]['name_name']; ?> <?= $player_array[0]['surname_name']; ?>
            </div>
            <?php if (isset($line_array) && 'player_view' == $file_name) { ?>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                    <label for="select-line">Состав:</label>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <select class="form-control" id="select-line" data-player="<?= $player_array[0]['player_id']; ?>">
                        <?php foreach ($line_array as $item) { ?>
                            <option value="<?= $item['line_id']; ?>"
                                <?php if ($player_array[0]['line_id'] == $item['line_id']) { ?>
                                    selected
                                <?php } ?>
                                <?php if ($item['line_color']) { ?>
                                    style="background-color: #<?= $item['line_color']; ?>"
                                <?php } ?>
                            >
                                <?= $item['line_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Национальность:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <img
                            alt="<?= $player_array[0]['country_name']; ?>"
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
                        <?php if (isset($auth_team_id) && $auth_team_id == $player_array[0]['team_id']) { ?>
                            <?= $player_array[0]['player_tire']; ?>%
                        <?php } else { ?>
                            ?
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Форма на сегодня:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if (isset($auth_team_id) && $auth_team_id == $player_array[0]['team_id']) { ?>
                            <img
                                alt="<?= $player_array[0]['phisical_value']; ?>%"
                                src="/img/phisical/<?= $player_array[0]['phisical_id']; ?>.png"
                                title="<?= $player_array[0]['phisical_value']; ?>%"
                            />
                        <?php } else { ?>
                            ?
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Реальная сила:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if (isset($auth_team_id) && $auth_team_id == $player_array[0]['team_id']) { ?>
                            <?= $player_array[0]['player_power_real']; ?>
                        <?php } else { ?>
                            ~<?= $player_array[0]['player_power_nominal']; ?>
                        <?php } ?>
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
                <?php if ($player_array[0]['rent_team_id']) { ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            В аренде:
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <a href="/team_view.php?num=<?= $player_array[0]['rent_team_id']; ?>">
                                <?= $player_array[0]['rent_team_name']; ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
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
                        <?= f_igosja_money_format($player_array[0]['player_salary']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Стоимость:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= f_igosja_money_format($player_array[0]['player_price']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>