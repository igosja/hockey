<?php
/**
 * @var $count_buildingstadium integer
 * @var $new_capacity integer
 */
?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-size-1 strong">
        <?= $stadium_array[0]['stadium_name']; ?>
    </div>
</div>
<?php if ($count_buildingstadium) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
            На стадионе сейчас идет строительство.
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
<?php if (isset($stadium_accept)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $stadium_accept; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/stadium_decrease.php?capacity=<?= $new_capacity; ?>&ok=1" class="btn margin">Строить</a>
            <a href="/stadium_decrease.php" class="btn margin">Отказаться</a>
        </div>
    </div>
<?php } ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/stadium_table_link.php'); ?>
    </div>
</div>
<form method="POST">
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
            Новая вместимость
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <input class="form-control" id="stadium-capacity" name="data[new_capacity]" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
            Финансы команды
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
            <?= f_igosja_money($stadium_array[0]['team_finance']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
            Компенсация
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
            <span id="stadium-price">0</span> $
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Уменьшить стадион" />
        </div>
    </div>
</form>
<script>
    var capacity_current = <?= $stadium_array[0]['stadium_capacity']; ?>;
    var one_sit_price    = <?= STADIUM_ONE_SIT_PICE_SELL; ?>;
</script>