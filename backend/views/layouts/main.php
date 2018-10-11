<?php

use backend\assets\AppAsset;
use common\components\ErrorHelper;
use common\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\Menu;

/**
 * @var \yii\web\View $this
 * @var string $content
 */

AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags(); ?>
    <title><?= Html::encode($this->title); ?></title>
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody(); ?>
<div id="wrapper">
    <?php

    NavBar::begin([
        'brandLabel' => Yii::t('backend-views-layouts-main', 'nav-admin'),
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => ''],
        'options' => [
            'class' => 'navbar navbar-default navbar-static-top',
        ],
    ]);

    $menuItems = [
        [
            'label' => '<i class="fa fa-bell-o fa-fw"></i> <span class="badge" id="admin-bell" data-url="'
                . Url::to(['bell/index'])
                . '"></span>',
            'items' => [
                [
                    'label' => '<i class="fa fa-user fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'bell-team-request') . '
                                <span class="badge"></span>',
                    'url' => ['team-request/index'],
                ],
                [
                    'label' => '<i class="fa fa-shield fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'bell-logos') . '
                                <span class="badge admin-logo"></span>',
                    'url' => ['logo/index'],
                ],
                [
                    'label' => '<i class="fa fa-comments fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'bell-support') . '
                                <span class="badge admin-support"></span>',
                    'url' => ['logo/index'],
                ],
                [
                    'label' => '<i class="fa fa-exclamation-circle fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'bell-complaint') . '
                                <span class="badge admin-complaint"></span>',
                    'url' => ['complaint/index'],
                ],
                [
                    'label' => '<i class="fa fa-bar-chart fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'bell-poll') . '
                                <span class="badge admin-poll"></span>',
                    'url' => ['poll/index'],
                ],
            ],
            'url' => 'javascript:',
        ],
        [
            'label' => '<i class="fa fa-gear fa-fw"></i>',
            'items' => [
                [
                    'label' => '<i class="fa fa-power-off fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'gear-enable') . Yii::t('backend-views-layouts-main', 'gear-disable'),
                    'url' => ['site/switch'],
                ],
                [
                    'label' => '<i class="fa fa-signal fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'gear-version'),
                    'url' => ['site/version'],
                ],
                [
                    'label' => '<i class="fa fa-sign-out fa-fw"></i> ' . Yii::t('backend-views-layouts-main', 'gear-logout'),
                    'url' => ['site/logout'],
                ],
            ],
            'url' => 'javascript:',
        ],
    ];

    try {
        print Nav::widget([
            'encodeLabels' => false,
            'items' => $menuItems,
            'options' => ['class' => 'nav navbar-top-links navbar-right'],
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>

    <div class="navbar-default sidebar">
        <div class="sidebar-nav navbar-collapse">
            <?php

            $menuItems = [
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-user'),
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-user'),
                            'url' => ['user/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-president'),
                            'url' => ['president/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-coach'),
                            'url' => ['coach/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-block-reason'),
                            'url' => ['block-reason/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => 'Teams' . Yii::t('backend-views-layouts-main', 'link-team'),
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-team'),
                            'url' => ['team/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-stadium'),
                            'url' => ['stadium/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-city'),
                            'url' => ['city/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-country'),
                            'url' => ['country/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-news'),
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-news'),
                            'url' => ['news/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-pre-news'),
                            'url' => ['pre-news/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-rules'),
                    'url' => ['rule/index'],
                ],
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-tournament-type'),
                    'url' => ['tournament-type/index'],
                ],
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-poll'),
                    'url' => ['poll/index'],
                ],
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-schedule'),
                    'url' => ['schedule/index'],
                ],
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-forum'),
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-forum-chapter'),
                            'url' => ['forum-chapter/index'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-forum-group'),
                            'url' => ['forum-group/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => Yii::t('backend-views-layouts-main', 'link-indicator'),
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-analytic'),
                            'url' => ['analytics/game-statistic'],
                        ],
                        [
                            'label' => Yii::t('backend-views-layouts-main', 'link-snapshot'),
                            'url' => ['analytics/snapshot'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
            ];

            try {
                print Menu::widget([
                    'encodeLabels' => false,
                    'items' => $menuItems,
                    'options' => [
                        'id' => 'side-menu',
                        'class' => 'nav',
                    ],
                    'submenuTemplate' => '<ul class="nav nav-second-level">{items}</ul>'
                ]);
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </div>
    </div>
    <?php NavBar::end(); ?>
    <div id="page-wrapper">
        <?php

        try {
            print Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'] ?? [],
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        try {
            print Alert::widget();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        print $content;

        ?>
    </div>
</div>
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
