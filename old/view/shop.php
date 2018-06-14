<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Виртуальный магазин</h1>
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p>
            Если вам нравится эта игра,
            если вы хотите пользоваться более комфортным интерфейсом без рекламы и с дополнительными страничками,
            выделиться VIP-значком, управлять большим числом команд,
            а может у вас просто есть желание и возможность поддержать нашу дальнейшую работу -
            рекомендуем вам оплатить небольшой взнос и стать VIP-менеджером. Спасибо!
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <td>
                    Вступить в VIP-клуб на 15 дней
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[vip]=15">
                        Купить за 2 ед.
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    Вступить в VIP-клуб на 30 дней
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[vip]=30">
                        Купить за 3 ед.
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    Вступить в VIP-клуб на 60 дней
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[vip]=60">
                        Купить за 5 ед.
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    Вступить в VIP-клуб на 180 дней
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[vip]=180">
                        Купить за 10 ед.
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    Вступить в VIP-клуб на 365 дней
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[vip]=365">
                        Купить за 15 ед.
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p>
            Развитие команды не требует обязательного совершения покупок в магазине,
            но если вы не привыкли ждать, хотите "всё и сразу" и имеете возможность "ускорить процесс",
            то добро пожаловать в магазин игровых товаров!
            Цены для разных команд разные - чем сильнее команда, тем сложнее её усилить с помощью магазина:
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <td>
                    Балл силы для тренировки игрока команды
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[product]=1">
                        Купить за 1 ед.
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    1 млн. $ на счёт команды
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[product]=2">
                        Купить за 5 ед.
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    Совмещение для игрока команды
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[product]=3">
                        Купить за 3 ед.
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    Спецвозможность для игрока команды
                </td>
                <td class="text-right">
                    <a href="/shop.php?data[product]=4">
                        Купить за 3 ед.
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>