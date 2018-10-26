<?php

use yii\helpers\Html;

/**
 * @var int $count
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Что такое VIP-клуб?</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                Зарегистрировались в VIP-клубе <span class="strong"><?= $count; ?></span> чел.
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p>
                    <span class="strong">VIP-клуб</span> - это сообщество менеджеров, которым нравится наш сайт.
                    Они уделяют игре достаточно много своего времени, им хочется, чтобы сайт активнее и быстрее
                    развивался,
                    и для этого они согласны платить небольшую абонентскую плату игровыми единицами.
                </p>
                <p>
                    <span class="strong">VIP-менеджер</span> получает дополнительные неигровые возможности,
                    более комфортный интерфейс сайта и особо уважительное отношение со стороны создателей сайта -
                    ведь вы поддерживаете нашу небольшую команду, которая работает над этим сайтом.
                </p>
                <p>
                    <span class="strong">Абонентская плата VIP-менеджера</span> составляет <span
                            class="strong">3 ед.</span>
                    с денежного счёта менеджера за месяц (30 дней). Можно продлить VIP на сроки от 15 дней до 1 года,
                    за больший срок предусмотрены существенные скидки.
                </p>
                <p>
                    <span class="strong">Спецвозможности VIP-менеджеров:</span>
                </p>
                <ul>
                    <li>
                        в ростере и в списке команд вы будете выделяться <span class="strong">значком VIP</span>
                        <br/>
                        <span class="text-size-3">
                            (тем самым вы поддержите существование и развитие проекта Виртуальная Хоккейная Лига)
                        </span>
                    </li>
                    <li>
                        вы будете видеть наш сайт <span class="strong">без рекламных блоков</span>
                        <br/>
                        <span class="text-size-3">(странички грузятся быстрее и трафик меньше)</span>
                    </li>
                    <li>
                        вы сможете отказываться от рассылки новостей и
                        <span class="strong">более гибко настраивать</span>
                        уведомления и свой профиль
                        <br/>
                        <span class="text-size-3">
                            (появятся дополнительные настройки в анкетных данных менеджера)
                        </span>
                    </li>
                    <li>
                        вы не потеряете свою команду, даже если
                        <span class="strong">надолго уедете в отпуск</span>
                        и не сможете ею управлять
                        <br/>
                        <span class="text-size-3">
                            (мы обязуемся сохранять команды под управлением VIP-менеджера
                            на срок до 90 дней с момента его последней авторизации на сайте)
                        </span>
                    </li>
                    <li>
                        вы сможете найти
                        <span class="strong">заместителей</span>
                        в свои команды не только на время отпуска, а на постоянной основе
                        <br/>
                        <span class="text-size-3">
                            (иметь в своей команде заместителя разрешено менеджерам,
                            находящимся в отпуске, либо вступившим в VIP-клуб)
                        </span>
                    </li>
                    <li>
                        в ваших командах будет возможность составлять
                        <span class="strong">план усталости и сыгранности</span>
                        для игроков на предстоящие матчи
                        <br/>
                        <span class="text-size-3">
                            (там можно планировать, каких игроков вы собираетесь выпускать на лёд,
                            и видеть в режиме реального времени, что случится с усталостью и сыгранностью)
                        </span>
                    </li>
                    <li>
                        будет доступно составление
                        <span class="strong">шаблонов для тактики и составов</span>
                        и их использование при отправке составов на предстоящие матчи
                        <br/>
                        <span class="text-size-3">
                            (и любой из последних отправленных вами составов на уже прошедшие игры
                            можно будет одним кликом загрузить в форму отправки нового состава)
                        </span>
                    </li>
                    <li>
                        в таблицах чемпионатов и других турниров вам будет видны
                        <span class="strong">дополнительная статистическая информация</span>
                    </li>
                    <li>
                        ряд страниц будут обладать для вас более
                        <span class="strong">удобным интерфейсом и дополнительным функционалом</span>
                    </li>
                </ul>
                <p>
                    <span class="strong">Для того, чтобы оплатить членство в VIP-клубе, нужно:</span>
                </p>
                <ul>
                    <li>
                        <?= Html::a('пополнить', ['shop/payment']); ?> свой денежный счёт менеджера
                    </li>
                    <li>
                        купить в <?= Html::a('виртуальном магазине', ['shop/index']); ?>
                        продление VIP-клуба на нужный срок
                    </li>
                </ul>
                <p>
                    <span class="strong">Вступать в VIP-клуб необязательно!</span>
                    Но если вы играете с нами, и вам у нас нравится -
                    это хороший способ поддержать нас в нашем стремлении сделать этот сайт
                    самым лучшим симулятором хоккейного менеджмента в интернете. Спасибо!
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::a('Вступить в VIP-клуб', ['shop/index'], ['class' => 'btn margin']); ?>
            </div>
        </div>
    </div>
</div>