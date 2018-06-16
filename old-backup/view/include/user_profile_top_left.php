<?php
/**
 * @var $auth_user_id integer
 * @var $num_get integer
 * @var $user_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        <?php if ($user_array[0]['user_name'] || $user_array[0]['user_surname']) { ?>
            <?= $user_array[0]['user_name']; ?> <?= $user_array[0]['user_surname']; ?>
        <?php } else { ?>
            Новый менеджер
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
        Последний визит: <?= f_igosja_ufu_last_visit($user_array[0]['user_date_login']); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Ник:
        <?= f_igosja_user_vip($user_array[0]['user_date_vip']); ?>
        <span class="strong"><?= $user_array[0]['user_login']; ?></span>
        <?php if (isset($auth_user_id) && $auth_user_id != $num_get) { ?>
            <a href="/dialog.php?num=<?= $user_array[0]['user_id']; ?>">
                <img alt="Letter" src="/img/letter.png" title="Написать письмо" />
            </a>
        <?php } ?>
        <?php if (1 == $user_array[0]['user_holiday']) { ?>
            <span class="italic">(в отпуске)</span>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Личный счет: <span class="strong"><?= f_igosja_money_format($user_array[0]['user_finance']); ?></span>
    </div>
</div>
<?php if (isset($auth_user_id) && $num_get == $auth_user_id) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Денежный счет: <span class="strong"><?= $user_array[0]['user_money']; ?> ед.</span>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Рейтинг: <span class="strong"><?= $user_array[0]['user_rating']; ?></span>
    </div>
</div>
<?php if (isset($auth_user_id) && $num_get == $auth_user_id) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            VIP-клуб:
            <span class="strong">
                <a href="/vip.php">
                    <?php if (time() < $user_array[0]['user_date_vip']) { ?>
                        до <?= f_igosja_ufu_date_time($user_array[0]['user_date_vip']); ?>
                    <?php } else { ?>
                        не активирован
                    <?php } ?>
                </a>
            </span>
        </div>
    </div>
<?php } ?>