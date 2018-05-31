<?php
/**
 * @var $num_get integer
 * @var $referral_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Партнёрская программа
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <tr>
                <th>Ваши подопечные</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            <span class="strong">Вместе играть веселее.</span>
            Чем больше менеджеров играют в Виртуальной Хоккейной Лиге, тем интереснее и разнообразнее становится игра.
            Мы постоянно тратим огромное количество усилий и средств на то, чтобы рассказать
            как можно большему числу любителей хоккея о нашей игре - это долго, дорого и не всегда эффективно.
        </p>
        <p class="text-justify">
            Поэтому мы предлагам вам - нашим менеджерам: <span class="strong">приглашайте в игру новых участников.</span>
            Мы лучше выплатим вознаграждение вам, чем кому-то другому.
            Вы можете рассказать о нашей игре своим друзьям, знакомым, сотрудникам, одноклассникам и одногруппникам,
            посетителям вашего блога или сайта, на своем любимом форуме или чате, в социальной сети.
        </p>
        <p class="text-justify">
            Публикуйте статьи, обзоры, сообщения, объявления, рекламные баннеры, создайте тему на игровом форуме -
            всё то, что вам доступно, только не пользуйтесь запрещёнными законодательством методами (например, спам).
        </p>
        <p class="text-justify">
            Используйте для приглашения <span class="strong">вашу личную ссылку</span> на наш сайт - вот она:
        </p>
        <p class="text-center text-size-1 strong alert info">
            <?= SITE_URL; ?>/?num=<?= $num_get; ?>
        </p>
        <p class="text-justify">
            Все, кто зайдет на сайт по этой ссылке и зарегистрируется в игре,
            автоматически <span class="strong">станут вашими подопечными</span>.
        </p>
        <p class="text-justify">
            На ваш денежный счёт будут всегда зачисляться <span class="strong">10%</span> от всех единиц,
            купленных этими игроками!
        </p>
        <p class="text-justify">
            А в случае, если ваш подопечный сможет разобраться в игре и стать настоящим менеджером
            Виртуальной Хоккейной Лиги - вас ждет <span class="strong">дополнительное вознаграждение</span> в виде
            <span class="strong">1 млн $</span> на личный счет менеджера.
        </p>
        <p class="text-justify">
            Условия получения <span class="strong">дополнительного вознаграждения</span>:
        </p>
        <ul>
            <li>Ваш подопечный смог на протяжении 30 дней управлять полученной командой.</li>
            <li>Вы не играли с подопечным на одном компьютере и ваши подопечные тоже между собой не пересекались.</li>
            <li>Cкаут-коллегия не считает, что ваш подопечный может являться подставным аккаунтом.</li>
        </ul>
        <p class="text-justify strong red">
            Внимание!
        </p>
        <ul class="red">
            <li>Запрещено приглашать подопечных способами, которые нарушают законы (например, рассылать спам).</li>
            <li>Запрещено просить кого-либо перерегистрироваться на сайте, указав вас старшим менеджером.</li>
        </ul>
        <p class="text-justify">
            Любые средства на личном счете менеджера (включая вознаграждения за подопечных) являются игровыми
            и могут быть потрачены только для покупки игровых товаров на нашем сайте или подарков другим менеджерам.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Менеджер</th>
                <th class="col-20 hidden-xs">Последний визит</th>
                <th class="col-20 hidden-xs">Дата регистрации</th>
            </tr>
            <?php foreach ($referral_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    </td>
                    <td class="text-center hidden-xs"><?= f_igosja_ufu_last_visit($item['user_date_login']); ?></td>
                    <td class="text-center hidden-xs"><?= f_igosja_ufu_date_time($item['user_date_register']); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Менеджер</th>
                <th class="hidden-xs">Последний визит</th>
                <th class="hidden-xs">Дата регистрации</th>
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