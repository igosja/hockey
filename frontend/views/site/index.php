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
                <h1>Online manager for true hockey fans!</h1>
                <p class="text-justify">
                    For sure, each of us wanted to feel like a coach or a manager of a real hockey club.
                    A fascinating search for talented players, the gradual development of infrastructure,
                    the choice of suitable tactics for the game, regular matches and, of course, wins,
                    titles and new achievements! This is what awaits you in our virtual hockey world.
                    Plunge into it and create a club of your dreams!
                </p>
                <h4>Everyone can play our hockey online manager!</h4>
                <p class="text-justify">
                    Our project is open to all! To start playing, you just need to go through
                    an elementary registration procedure or go under your profile in social networks.
                    <strong>"Virtual Hockey League"</strong> is a functional hockey online manager in which
                    you will get the opportunity to go through an exciting way of developing your team
                    from the lower divisions to victories in national championships and world cups!
                </p>
                <?php if (Yii::$app->user->isGuest): ?>
                    <p class="text-center">
                        <?= Html::a('Sign Up', ['site/sign-up'], ['class' => 'btn']); ?>
                    </p>
                <?php endif; ?>
                <h4>You do not need to download anything!</h4>
                <p class="text-justify">
                    Please note that our hockey online manager is a browser game.
                    Therefore, you do not need to download any client programs, spend time
                    on their tedious installation and subsequent configuration.
                    For the game you only need access to the Internet and a few minutes of free time.
                    In this case, participation in tournaments is <strong>absolutely free</strong>.
                </p>
                <h4 class="center header">You will definitely become a champion!</h4>
                <p class="text-justify">
                    We want to emphasize that you do not need to sit at your computer for success.
                    To gradually develop your club, participate in transfers and play calendar matches,
                    you just have to be able to visit our site at least several times a week.
                </p>
                <h4 class="center header">
                    Exciting hockey matches and the first victories are already waiting for you!
                </h4>
                <p class="text-justify">
                    Hockey online manager <strong>"Virtual Hockey League"</strong> is more than a regular game.
                    This is a community of people who are united by passion and love for hockey.
                    Here you can find interesting people, get new acquaintances
                    and just have a great time in a relaxed and most comfortable atmosphere.
                    Forward, it's time to take the coaching chair and manager's office!
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>Latest Game News</h2>
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
                        [<?= Html::a('Learn More', ['news/index']); ?>]
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2>How to become a manager of a hockey team?</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="text-justify">In order to become a participant in the game, you need:</p>
                <ul>
                    <li>
                        <?= Html::a('register in the game', ['site/sign-up'], ['class' => 'strong']); ?>,
                        receive a email with the registration confirmation code;
                    </li>
                    <li>
                        to activate your registration with the code received in the email,
                        on <?= Html::a('this page', ['site/confirm']); ?>;
                    </li>
                    <li>
                        enter the site under your login / password;
                    </li>
                    <li>
                        apply for a free team;
                    </li>
                    <li>
                        wait for the moderator to review your application and return the club to your disposal;
                    </li>
                    <li>
                        to familiarize with the most simple sections of rules (at will);
                    </li>
                    <li>
                        that's all - start the game! - gradually delving into the subtleties and details of the
                        gameplay.
                    </li>
                </ul>
                <p class="text-justify">
                    You can ask your questions to experienced players on the <?= Html::a('forum', ['forum/index']); ?>.
                    For all the problems and questions, you can write to
                    <?= Html::a('technical support for the site', ['support/index']); ?>.
                </p>
            </div>
        </div>
        <?php if ($reviews) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Hockey Analytics</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        Journalists of the Virtual Hockey League regularly publish reviews of the tours:
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
                    <h2>News of federations</h2>
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
                        [<?= Html::a('Learn More', ['country/news', 'id' => $countryNews->news_country_id]); ?>]
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($birthdays) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>Birthdays</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify"><span class="strong">Today's birthday</span> is celebrated by managers:</p>
                    <ul>
                        <?php foreach ($birthdays as $item) : ?>
                            <li>
                                <?= $item->user_name; ?> <?= $item->user_surname; ?>
                                (<?= Html::a($item->user_login, ['user/view', 'id' => $item->user_id]); ?>)
                                <?php if ($item->user_birth_year) : ?>
                                    - is <?= date('Y') - $item->user_birth_year; ?> years old!
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
                    <legend class="text-center strong">Forum</legend>
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
                    <legend class="text-center strong">Counter</legend>
                    <a href="//www.liveinternet.ru/click" rel="nofollow" target="_blank">
                        <img
                                alt="LiveInternet counter"
                                height="120"
                                src="//counter.yadro.ru/logo?29.19"
                                width="88"
                        />
                    </a>
                </fieldset>
            </div>
        </div>
        <div class="row margin">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <fieldset>
                    <legend class="text-center strong">Payments</legend>
                    <a href="//passport.webmoney.ru/asp/certview.asp?wmid=274662367507" rel="nofollow"
                       target="_blank">
                        <img
                                alt="WebMoney"
                                border="0"
                                src="/img/webmoney.png"
                                title="WebMoney ID 274662367507"
                        />
                    </a>
                    <br/>
                    <a href="http://www.free-kassa.ru/" rel="nofollow" target="_blank">
                        <img
                                alt="Free Kassa"
                                border="0"
                                src="//www.free-kassa.ru/img/fk_btn/13.png"
                                title="Free Kassa"
                        />
                    </a>
                </fieldset>
            </div>
        </div>
    </div>
</div>
