<?php
/**
 * @var $user_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        День рождения:
        <span class="strong">
            <?= f_igosja_birth_date($user_array[0]); ?>
        </span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Пол: <span class="strong"><?= $user_array[0]['sex_name']; ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Откуда: <span class="strong"><?= f_igosja_user_from($user_array[0]); ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Дата регистрации: <span class="strong"><?= f_igosja_ufu_date($user_array[0]['user_date_register']); ?></span>
    </div>
</div>