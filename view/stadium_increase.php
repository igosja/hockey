<?php
/**
 * @var $buildingstadium_day string
 * @var $count_buildingstadium integer
 * @var $new_capacity integer
 * @var $stadium_accept string
 * @var $stadium_array array
 * @var $stadium_error string
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Строительство стадиона
            </div>
        </div>
    </div>
</div>
<?php if ($count_buildingstadium) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
            На стадионе сейчас идет строительство.
            Дата окончания строительства - <?= $buildingstadium_day; ?>
            <br/>
            <a href="/stadium_cancel.php">
                Отменить строительство
            </a>
        </div>
    </div>
<?php } ?>
<?php if (isset($stadium_error)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
            Строить нельзя: <?= $stadium_error; ?>
        </div>
    </div>
<?php } ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/stadium_table_link.php'); ?>
    </div>
</div>
<?php if (isset($stadium_accept)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $stadium_accept; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/stadium_increase.php?capacity=<?= $new_capacity; ?>&ok=1" class="btn margin">Строить</a>
            <a href="/stadium_increase.php" class="btn margin">Отказаться</a>
        </div>
    </div>
<?php } else { ?>
    <form id="stadium-increase-form" method="POST">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Текушая вместимость
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
                <?= $stadium_array[0]['stadium_capacity']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                <label for="stadium-increase-input">Новая вместимость</label>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-6">
                <input
                    class="form-control"
                    data-available="<?= $stadium_array[0]['team_finance']; ?>"
                    data-current="<?= $stadium_array[0]['stadium_capacity']; ?>"
                    data-sit_price="<?= STADIUM_ONE_SIT_PICE_BUY; ?>"
                    id="stadium-increase-input"
                    name="data[new_capacity]"
                />
            </div>
            <div class="col-lg-4 col-md-4 col-sm-3 col-xs-12 xs-text-center stadium-increase-error notification-error"></div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Финансы команды
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
                <?= f_igosja_money_format($stadium_array[0]['team_finance']); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                Стоимость строительства
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
                <span id="stadium-increase-price">0</span> $
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input class="btn margin" type="submit" value="Начать строительтво" />
            </div>
        </div>
    </form>
<?php } ?>