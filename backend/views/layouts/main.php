<?php

use backend\assets\AppAsset;
use common\components\ErrorHelper;
use common\widgets\Alert;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
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
        'brandLabel' => 'Admin',
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => ''],
        'options' => [
            'class' => 'navbar navbar-default navbar-static-top',
        ],
    ]);

    $menuItems = [
        [
            'label' => '<i class="fa fa-bell-o fa-fw"></i> <span class="badge" id="admin-bell"></span>',
            'items' => [
                [
                    'label' => '<i class="fa fa-user fa-fw"></i> Team Requests
                                <span class="badge admin-team-ask"></span>',
                    'url' => ['team-request/index'],
                ],
                [
                    'label' => '<i class="fa fa-shield fa-fw"></i> Logos
                                <span class="badge admin-logo"></span>',
                    'url' => ['logo/index'],
                ],
                [
                    'label' => '<i class="fa fa-comments fa-fw"></i> Support
                                <span class="badge admin-support"></span>',
                    'url' => ['logo/index'],
                ],
                [
                    'label' => '<i class="fa fa-exclamation-circle fa-fw"></i> Complaints
                                <span class="badge admin-complaint"></span>',
                    'url' => ['complaint/index'],
                ],
                [
                    'label' => '<i class="fa fa-bar-chart fa-fw"></i> Polls
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
                    'label' => '<i class="fa fa-power-off fa-fw"></i> Enable-disable site',
                    'url' => ['site/switch'],
                ],
                [
                    'label' => '<i class="fa fa-signal fa-fw"></i> Site version',
                    'url' => ['site/version'],
                ],
                [
                    'label' => '<i class="fa fa-file-text-o fa-fw"></i> Error log',
                    'url' => ['error-log/index'],
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
                    'label' => 'Users',
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => 'Users',
                            'url' => ['user/index'],
                        ],
                        [
                            'label' => 'Presidents',
                            'url' => ['president/index'],
                        ],
                        [
                            'label' => 'Coaches',
                            'url' => ['coach/index'],
                        ],
                        [
                            'label' => 'Reasons for blocking',
                            'url' => ['block-reason/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => 'Teams',
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => 'Teams',
                            'url' => ['team/index'],
                        ],
                        [
                            'label' => 'Stadiums',
                            'url' => ['stadium/index'],
                        ],
                        [
                            'label' => 'Cities',
                            'url' => ['city/index'],
                        ],
                        [
                            'label' => 'Countries',
                            'url' => ['country/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => 'News',
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => 'News',
                            'url' => ['news/index'],
                        ],
                        [
                            'label' => 'Preliminary news',
                            'url' => ['pre-news/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => 'Rules',
                    'url' => ['rule/index'],
                ],
                [
                    'label' => 'Tournament types',
                    'url' => ['tournament-type/index'],
                ],
                [
                    'label' => 'Polls',
                    'url' => ['poll/index'],
                ],
                [
                    'label' => 'Schedule',
                    'url' => ['schedule/index'],
                ],
                [
                    'label' => 'Forum',
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => 'Chapters',
                            'url' => ['forum-chapter/index'],
                        ],
                        [
                            'label' => 'Groups',
                            'url' => ['forum-group/index'],
                        ],
                    ],
                    'url' => 'javascript:',
                ],
                [
                    'label' => 'Site indicators',
                    'template' => '<a href="{url}">{label}<span class="fa arrow"></span></a>',
                    'items' => [
                        [
                            'label' => 'Analytics',
                            'url' => ['analytics/game-statistic'],
                        ],
                        [
                            'label' => 'Snapshot',
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
