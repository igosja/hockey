<?php

use yii\helpers\Html;

/**
 * @var \common\models\User[] $birthdays
 * @var \common\models\News $countryNews
 * @var \common\models\ForumTheme[] $forumThemes
 * @var \common\models\News $news
 * @var \common\models\Review[] $reviews
 */

?>
<div class="row">
    <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Онлайн-менеджер для истинных любителей хоккея!</h1>
                <p class="text-justify">
                    Наверняка каждый из нас мечтал почувствовать себя тренером или менеджером настоящего хоккейного
                    клуба.
                    Увлекательный поиск талантливых игроков, постепенное развитие инфраструктуры,
                    выбор подходящей тактики на игру, регулярные матчи и, конечно же, победы, титулы и новые достижения!
                    Именно это ждёт Вас в нашем мире виртуального хоккея. Окунитесь в него и создайте клуб своей мечты!
                </p>
                <h4>Играть в наш хоккейный онлайн-менеджер может каждый!</h4>
                <p class="text-justify">
                    Наш проект открыт для всех!
                    Чтобы начать играть, Вам достаточно просто пройти элементарную процедуру регистрации.
                    <strong>"Виртуальная Хоккейная Лига"</strong> – это функциональный хоккейный онлайн-менеджер,
                    в котором Вы получите возможность пройти увлекательный путь развития своей команды
                    от низших дивизионов до побед в национальных чемпионатах и мировых кубках!
                </p>
                <?php if (Yii::$app->user->isGuest) : ?>
                    <p class="text-center">
                        <?= Html::a(
                            'Зарегистрироваться',
                            ['site/sign-up'],
                            ['class' => 'btn']
                        ); ?>
                    </p>
                <?php endif; ?>
                <h4>Скачивать ничего не надо!</h4>
                <p class="text-justify">
                    Обращаем внимание, что наш хоккейный онлайн-менеджер является браузерной игрой.
                    Поэтому Вам не надо будет скачивать какие-либо клиентские программы,
                    тратить время на их утомительную установку и последующую настройку.
                    Для игры Вам необходим только доступ к интернету и несколько минут свободного времени.
                    При этом участие в турнирах является <strong>абсолютно бесплатным</strong>.
                </p>
                <h4 class="center header">Вы обязательно станете чемпионом!</h4>
                <p class="text-justify">
                    Хотим подчеркнуть, что для достижения успеха Вам не надо целыми сутками сидеть за компьютером.
                    Чтобы постепенно развивать свой клуб, участвовать в трансферах и играть календарные матчи,
                    Вам достаточно иметь возможность хотя бы несколько раз в неделю посещать наш сайт.
                </p>
                <h4 class="center header">Увлекательные хоккейные матчи и первые победы уже ждут Вас!</h4>
                <p class="text-justify">
                    Хоккейный онлайн-менеджер <strong>"Виртуальная Хоккейная Лига"</strong> – это больше, чем обычная
                    игра.
                    Это сообщество людей, которые объединены страстью и любовью к хоккею.
                    Здесь Вы обязательно сможете найти интересных людей, заведете новые знакомства
                    и просто отлично проведетё время в непринужденной и максимально комфортной атмосфере.
                    Вперёд, пришло время занять тренерское кресло и кабинет менеджера!
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Последние игровые новост</h2>
            </div>
        </div>
        <?php if ($news) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        <span class="strong"><?= $news->news_title; ?></span>
                    </p>
                    <p class="text-justify">
                        <?= $news->news_text; ?>
                    </p>
                    <?= Html::a(
                        $news->user->user_login,
                        ['user/view', 'id' => $news->user->user_id]
                    ); ?>
                    <p class="text-justify text-size-3">
                        [<?= Html::a('Подробнее', ['news/index']); ?>]
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Как стать менеджером хоккейной команды?</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="text-justify">Для того, чтобы стать участником игры, вам нужно:</p>
                <ul>
                    <li>
                        <?= Html::a(
                            'зарегистрироваться в игре',
                            ['site/sign-up'],
                            ['class' => 'strong']
                        ); ?>, получить письмо с кодом подтверждения регистрации;
                    </li>
                    <li>
                        активировать свою регистрацию с помощью кода, полученного в письме, на
                        <?= Html::a(
                            'этой странице',
                            ['site/activation']
                        ); ?>;
                    </li>
                    <li>
                        зайти на сайт под своим логином и паролем;
                    </li>
                    <li>
                        подать заявку на новую или свободную команду;
                    </li>
                    <li>
                        дождаться, пока модератор рассмотрит вашу заявку и отдаст клуб в ваше распоряжение;
                    </li>
                    <li>
                        ознакомиться с самыми простыми разделами правил (по желанию);
                    </li>
                    <li>
                        и всё - приступить к игре! - постепенно вникая в тонкости и детали игрового процесса.
                    </li>
                </ul>
                <p class="text-justify">
                    Свои вопросы вы можете задать опытным игрокам на <?= Html::a('форуме', ['forum/index']); ?>.
                    Обо всех проблемах и вопросах вы можете написать в
                    <?= Html::a('техподдержку сайта', ['support/index']); ?>.
                </p>
            </div>
        </div>
        <?php if ($reviews) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Хоккейная аналитика</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        Журналисты Виртуальной Хоккейной Лиги регулярно публикуют обзоры состоявшихся туров:
                    </p>
                    <ul>
                        <?php foreach ($reviews as $item): ?>
                            <li>
                                <?= $item->country->country_name; ?>
                                (<?= $item->division->division_name; ?>),
                                <?= $item->stage->stage_name; ?>:
                                <?= Html::a($item->review_title, ['review/view', 'id' => $item->review_id]); ?>
                                (<?= Html::a($item->user->user_login, ['user/view', 'id' => $item->user->user_id]); ?>)
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($countryNews): ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>
                        Новости федераций
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        <span class="strong">
                            <?= $countryNews->country->country_name; ?>: <?= $countryNews->news_title; ?>
                        </span>
                    </p>
                    <p class="text-justify">
                        <?= $countryNews->news_text; ?>
                    </p>
                    <?= Html::a($countryNews->user->user_login, ['user/view', 'id' => $countryNews->user->user_id]); ?>
                    <p class="text-justify text-size-3">
                        [<?= Html::a('Подробнее', ['country/news', 'id' => $countryNews->news_country_id]); ?>]
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($birthdays) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>
                        Дни рождения
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        <span class="strong">Сегодня день рождения</span> празднуют менеджеры:
                    </p>
                    <ul>
                        <?php foreach ($birthdays as $item) : ?>
                            <li>
                                <?= $item->user_name; ?> <?= $item->user_surname; ?>
                                (<?= Html::a($item->user_login, ['user/view', 'id' => $item->user_id]); ?>)
                                <?php if ($item->user_birth_year) : ?>
                                    -
                                    <?= Yii::t(
                                        'app',
                                        'исполняется {years, plural, one{# год} few{# года} many{# лет} other{# лет}}!',
                                        [
                                            'years' => date('Y') - $item->user_birth_year,
                                        ]
                                    ); ?>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
        <div class="row margin">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <fieldset class="text-size-3">
                    <legend class="text-center strong">
                        Форум
                    </legend>
                    <?php foreach ($forumThemes as $item): ?>
                        <div class="row margin-top-small">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?= Html::a(
                                    $item->forum_theme_name,
                                    ['forum/theme', 'id' => $item->forum_theme_id]
                                ); ?>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <?= $item->forumGroup->forum_group_name; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>
        </div>
        <div class="row margin">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <fieldset>
                    <legend class="text-center strong">
                        Счётчик
                    </legend>
                    <?= Html::img(
                        '//counter.yadro.ru/logo?14.4',
                        [
                            'alt' => 'LiveInternet counter',
                            'height' => 31,
                            'width' => 8,
                        ]
                    ); ?>
                </fieldset>
            </div>
        </div>
        <div class="row margin">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <fieldset>
                    <legend class="text-center strong">
                        Платежи
                    </legend>
                    <a href="//passport.webmoney.ru/asp/certview.asp?wmid=274662367507" rel="nofollow" target="_blank">
                        <?= Html::img(
                            '/img/webmoney.png',
                            [
                                'alt' => 'WebMoney',
                                'border' => 0,
                                'title' => 'WebMoney ID 274662367507',
                            ]
                        ); ?>
                    </a>
                </fieldset>
            </div>
        </div>
    </div>
</div>
