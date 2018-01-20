<?php
/**
 * @var $price integer
 * @var $redirect string
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Отмена строительства стадиона
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Вы собираетесь отменить строительство стадиона.
        <?php if ($price > 0) { ?>
            Компенсансация за отмену строительства составит <span class="strong"><?= f_igosja_money_format($price); ?></span>.
        <?php } else { ?>
            Оплата за отмену строительства составит <span class="strong"><?= f_igosja_money_format(-$price); ?></span>.
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/stadium_cancel.php?ok=1" class="btn margin">Отменить строительство</a>
        <a href="<?= $redirect; ?>" class="btn margin">Вернуться</a>
    </div>
</div>