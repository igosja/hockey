<?php
/**
 * @var $payment_accept string
 * @var $sum integer
 * @var $user_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Пополнение денежного счета</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        <p class="text-center">Ваш счёт - <?= $user_array[0]['user_money']; ?></p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/shop_table_link.php'); ?>
    </div>
</div>
<?php if (isset($payment_accept)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $payment_accept; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/shop_payment.php?data[sum]=<?= $sum; ?>&ok=1" class="btn margin">Пополнить</a>
            <a href="/shop_payment.php" class="btn margin">Отказаться</a>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p class="text-justify">
                <span class="strong">Денежный счёт менеджера</span> предназначен для приобретения игровых товаров.
                Перед тем, как пополнить свой денежный счёт, посмотрите <a href="/shop.php">в списке игровых товаров</a>, какие из них вам нужны.
                Таким образом, вы сможете рассчитать, сколько для этого потребуется единиц на вашем денежном счёте.
            </p>
            <p class="text-justify">
                Мы предоставляем вам <span class="strong">максимально возможное число способов для пополнения вашего денежного счёта</span>,
                в каком бы регионе земного шара вы не находились.
                Воспользоваться правом на зачисление <span class="strong">1 единицы</span> на ваш денежный счёт вы можете примерно за <span class="strong">$1</span>,
                но точная стоимость зависит от способа оплаты. Выбирайте тот способ, который для вас удобнее.
            </p>
            <p class="text-justify">
                Средства на денежном счёте менеджера являются игровым понятием и могут быть использованы только для покупки
                <a href="/shop.php">игровых товаров</a> на нашем сайте.
                Средства на денежном счёте менеджера хранятся неограниченное время до удаления аккаунта менеджера.
            </p>
        </div>
    </div>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p class="text-center">
                <span class="strong">Ваш личный бонус</span>:
                <?php include(__DIR__ . '/include/payment_bonus.php'); ?>
            </p>
        </div>
    </div>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p class="text-center">
                <span class="strong">Внимание!</span>
                При пополнении денежного счета одним платежом на большую сумму полагаются бонусы:
                <br/>
                если сумма пополнения счёта <span class="strong">от 100</span> единиц денежного счета,
                то вы получите <span class="strong">+10% от суммы</span> в подарок.
            </p>
        </div>
    </div>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-right xs-text-center">
                <label for="sum">Сумма пополнения, единиц</label>:
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-left">
                <input
                    class="form-control form-small"
                    id="sum"
                    name="data[sum]"
                    type="text"
                />
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input type="submit" class="btn margin" value="Пополнить" />
            </div>
        </div>
    </form>
<?php } ?>