<?php
/**
 * @var $c_array array
 * @var $country_array array
 * @var $error_array array
 * @var $gk_array array
 * @var $ld_array array
 * @var $lw_array array
 * @var $nationalplayer_array array
 * @var $rd_array array
 * @var $rw_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/national_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/national_view_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/national_table_link.php'); ?>
    </div>
</div>
<form method="POST">
    <?php if (isset($error_array)) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
                <?php foreach ($error_array as $item) { ?>
                    <?= $item; ?><br />
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php for ($i=POSITION_GK; $i<=POSITION_RW; $i++) { ?>
        <?php

        if (POSITION_GK == $i)
        {
            $player_array   = $gk_array;
            $form_tag       = 'gk';
        }
        elseif (POSITION_LD == $i)
        {
            $player_array   = $ld_array;
            $form_tag       = 'ld';
        }
        elseif (POSITION_RD == $i)
        {
            $player_array   = $rd_array;
            $form_tag       = 'rd';
        }
        elseif (POSITION_LW == $i)
        {
            $player_array   = $lw_array;
            $form_tag       = 'lw';
        }
        elseif (POSITION_C == $i)
        {
            $player_array   = $c_array;
            $form_tag       = 'c';
        }
        else
        {
            $player_array   = $rw_array;
            $form_tag       = 'rw';
        }

        ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th class="col-5"></th>
                        <th>Игрок</th>
                        <th class="col-5" title="Позиция">Поз</th>
                        <th class="col-5" title="Возраст">В</th>
                        <th class="col-5" title="Номинальная сила">С</th>
                        <th class="col-10 hidden-xs" title="Спецвозможности">Спец</th>
                        <th class="col-40">Команда</th>
                    </tr>
                    <?php foreach ($player_array as $item) { ?>
                        <tr>
                            <td class="text-center">
                                <label class="hidden" for="<?= $form_tag; ?>-<?= $item['player_id']; ?>"><?= $item['player_id']; ?></label>
                                <input
                                    id="<?= $form_tag; ?>-<?= $item['player_id']; ?>"
                                    name="data[<?= $form_tag; ?>][]"
                                    type="checkbox"
                                    value="<?= $item['player_id']; ?>"
                                    <?php if ((isset($data[$form_tag]) && in_array($item['player_id'], $data[$form_tag])) || in_array($item['player_id'], $nationalplayer_array)) { ?>
                                        checked
                                    <?php } ?>
                                />
                            </td>
                            <td>
                                <a href="/player_view.php?num=<?= $item['player_id']; ?>" target="_blank">
                                    <?= $item['name_name']; ?>
                                    <?= $item['surname_name']; ?>
                                </a>
                            </td>
                            <td class="text-center"><?= f_igosja_player_position($item['player_id'], $playerposition_array); ?></td>
                            <td class="text-center"><?= $item['player_age']; ?></td>
                            <td class="text-center"><?= $item['player_power_nominal']; ?></td>
                            <td class="hidden-xs text-center"><?= f_igosja_player_special($item['player_id'], $playerspecial_array); ?></td>
                            <td>
                                <img
                                    alt="<?= $item['country_name']; ?>"
                                    src="/img/country/12/<?= $item['country_id']; ?>.png"
                                    title="<?= $item['country_id']; ?>"
                                />
                                <a href="team_view.php?num=<?= $item['team_id']; ?>" target="_blank">
                                    <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <th></th>
                        <th>Игрок</th>
                        <th title="Позиция">Поз</th>
                        <th title="Возраст">В</th>
                        <th title="Номинальная сила">С</th>
                        <th class="hidden-xs" title="Спецвозможности">Спец</th>
                        <th>Команда</th>
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
    <?php } ?>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
            <button type="submit" class="btn margin">
                Сохранить
            </button>
        </div>
    </div>
</form>