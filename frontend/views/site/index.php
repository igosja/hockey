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
                <h1><?= Yii::t('app', 'frontend-views-site-index-h1'); ?></h1>
                <?= Yii::t('app', 'frontend-views-site-index-text-seo', [
                    'sign-up' => Yii::$app->user->isGuest ? '<p class="text-center">' . Html::a(
                            Yii::t('app', 'frontend-views-site-index-link-sign-up'),
                            ['site/sign-up'],
                            ['class' => 'btn']
                        ) . '</p>' : '',
                ]); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2><?= Yii::t('app', 'frontend-views-site-index-h4-news'); ?></h2>
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
                        [<?= Html::a(Yii::t('app', 'frontend-views-link-learn-more'), ['news/index']); ?>]
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2><?= Yii::t('app', 'frontend-views-site-index-h2-how'); ?></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="text-justify"><?= Yii::t('app', 'frontend-views-site-index-text-how'); ?></p>
                <ul>
                    <li>
                        <?= Yii::t('app', 'frontend-views-site-index-how-li-1', [
                            'register' => Html::a(
                                Yii::t('app', 'frontend-views-site-index-link-register'),
                                ['site/sign-up'],
                                ['class' => 'strong']
                            ),
                        ]); ?>
                    </li>
                    <li>
                        <?= Yii::t('app', 'frontend-views-site-index-how-li-2', [
                            'confirm' => Html::a(
                                Yii::t('app', 'frontend-views-site-index-link-confirm-page'),
                                ['site/confirm']
                            ),
                        ]); ?>
                    </li>
                    <li>
                        <?= Yii::t('app', 'frontend-views-site-index-how-li-3'); ?>
                    </li>
                    <li>
                        <?= Yii::t('app', 'frontend-views-site-index-how-li-4'); ?>
                    </li>
                    <li>
                        <?= Yii::t('app', 'frontend-views-site-index-how-li-5'); ?>
                    </li>
                    <li>
                        <?= Yii::t('app', 'frontend-views-site-index-how-li-6'); ?>;
                    </li>
                    <li>
                        <?= Yii::t('app', 'frontend-views-site-index-how-li-7'); ?>;
                    </li>
                </ul>
                <p class="text-justify">
                    <?= Yii::t('app', 'frontend-views-site-index-how-ask', [
                        'forum' => Html::a(
                            Yii::t('app', 'frontend-views-site-index-link-forum'),
                            ['forum/index']
                        ),
                        'support' => Html::a(
                            Yii::t('app', 'frontend-views-site-index-link-support'),
                            ['support/index']
                        ),
                    ]); ?>
                </p>
            </div>
        </div>
        <?php if ($reviews) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2><?= Yii::t('app', 'frontend-views-site-index-h2-reviews'); ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        <?= Yii::t('app', 'frontend-views-site-index-text-reviews'); ?>
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
                        <?= Yii::t('app', 'frontend-views-site-index-h2-federation-news'); ?>
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
                        [<?= Html::a(
                            Yii::t('app', 'frontend-views-link-learn-more'),
                            ['country/news', 'id' => $countryNews->news_country_id]
                        ); ?>]
                    </p>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($birthdays) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h2>
                        <?= Yii::t('app', 'frontend-views-site-index-h2-birthday'); ?>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <p class="text-justify">
                        <?= Yii::t('app', 'frontend-views-site-index-text-birthday'); ?>
                    </p>
                    <ul>
                        <?php foreach ($birthdays as $item) : ?>
                            <li>
                                <?= $item->user_name; ?> <?= $item->user_surname; ?>
                                (<?= Html::a($item->user_login, ['user/view', 'id' => $item->user_id]); ?>)
                                <?php if ($item->user_birth_year || true) : ?>
                                    -
                                    <?= Yii::t('app', 'frontend-views-site-index-text-birthday-years-old', [
                                        'years' => date('Y') - $item->user_birth_year,
                                    ]); ?>
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
                        <?= Yii::t('app', 'frontend-views-site-index-legend-forum'); ?>
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
                        <?= Yii::t('app', 'frontend-views-site-index-legend-counter'); ?>
                    </legend>
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
                    <legend class="text-center strong">
                        <?= Yii::t('app', 'frontend-views-site-index-legend-payments'); ?>
                    </legend>
                    <a href="//passport.webmoney.ru/asp/certview.asp?wmid=274662367507" rel="nofollow" target="_blank">
                        <img
                                alt="WebMoney"
                                border="0"
                                src="/img/webmoney.png"
                                title="WebMoney ID 274662367507"
                        />
                    </a>
                </fieldset>
            </div>
        </div>
    </div>
</div>
