<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        Имя
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
        Последний визит: <?= f_igosja_ufu_last_visit($user_array[0]['user_date_login']); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Ник: <span class="strong"><?= $user_array[0]['user_login']; ?></span>
        <a href="/talk.php?num=<?= $user_array[0]['user_id']; ?>">
            Письмо
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Личный счет: <span class="strong"><?= f_igosja_money($user_array[0]['user_finance']); ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Денежный счет: <span class="strong"><?= $user_array[0]['user_money']; ?> ед.</span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Рейтинг: 0
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        VIP-клуб: 0
    </div>
</div>