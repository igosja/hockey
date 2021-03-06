<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Player;
use common\models\Team;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var array $notificationArray
 * @var Team $team
 * @var View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?= $this->render('//team/_team-top-right', ['team' => $team]); ?>
    </div>
</div>
<?php if ($notificationArray) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul>
                <?php foreach ($notificationArray as $item) : ?>
                    <li><?= $item; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('//team/_team-links'); ?>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'class' => 'yii\grid\SerialColumn',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => '№',
                'header' => '№',
            ],
            [
                'attribute' => 'squad',
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Player $model) {
                    return $model->playerLink()
                        . $model->iconPension()
                        . $model->iconInjury()
                        . $model->iconNational()
                        . $model->iconDeal()
                        . $model->iconTraining()
                        . $model->iconLoan()
                        . $model->iconScout();
                }
            ],
            [
                'attribute' => 'country',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Нац',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Национальность'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'hidden-xs col-1', 'title' => 'Национальность'],
                'label' => 'Нац',
                'value' => function (Player $model) {
                    return $model->country->countryImageLink();
                }
            ],
            [
                'attribute' => 'position',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'headerOptions' => ['title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model) {
                    return $model->position();
                }
            ],
            [
                'attribute' => 'age',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'headerOptions' => ['title' => 'Возраст'],
                'label' => 'В',
                'value' => function (Player $model) {
                    return $model->player_age;
                }
            ],
            [
                'attribute' => 'power_nominal',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Номинальная сила'],
                'format' => 'raw',
                'headerOptions' => ['title' => 'Номинальная сила'],
                'label' => 'С',
                'value' => function (Player $model) {
                    return $model->powerNominal();
                }
            ],
            [
                'attribute' => 'tire',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'У',
                'footerOptions' => ['title' => 'Усталость'],
                'headerOptions' => ['title' => 'Усталость'],
                'label' => 'У',
                'value' => function (Player $model) {
                    return $model->playerTire();
                }
            ],
            [
                'attribute' => 'physical',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Ф',
                'footerOptions' => ['title' => 'Форма'],
                'format' => 'raw',
                'headerOptions' => ['title' => 'Форма'],
                'label' => 'Ф',
                'value' => function (Player $model) {
                    return $model->playerPhysical();
                }
            ],
            [
                'attribute' => 'power_real',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'РС',
                'footerOptions' => ['title' => 'Реальная сила'],
                'headerOptions' => ['title' => 'Реальная сила'],
                'label' => 'РС',
                'value' => function (Player $model) use ($team) {
                    return $team->myTeam() ? $model->player_power_real : '~' . $model->player_power_nominal;
                }
            ],
            [
                'attribute' => 'special',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Спецвозможности'],
                'label' => 'Спец',
                'value' => function (Player $model) {
                    return $model->special();
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Ст',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Стиль'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Стиль'],
                'label' => 'Ст',
                'value' => function (Player $model) {
                    return $model->iconStyle(true);
                }
            ],
            [
                'attribute' => 'game_row',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'ИО',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Играл/отдыхал подряд'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Играл/отдыхал подряд'],
                'label' => 'ИО',
                'value' => function (Player $model) {
                    return $model->playerGameRow();
                }
            ],
            [
                'attribute' => 'plus_minus',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => '+/-',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Плюс/минус'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Плюс/минус'],
                'label' => '+/-',
                'value' => function (Player $model) {
                    $result = 0;
                    foreach ($model->statisticPlayer as $statisticPlayer) {
                        $result = $result + $statisticPlayer->statistic_player_plus_minus;
                    }
                    return $result;
                }
            ],
            [
                'attribute' => 'game',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'И',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Игры'],
                'label' => 'И',
                'value' => function (Player $model) {
                    $result = 0;
                    foreach ($model->statisticPlayer as $statisticPlayer) {
                        $result = $result + $statisticPlayer->statistic_player_game;
                    }
                    return $result;
                }
            ],
            [
                'attribute' => 'score',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Ш',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Шайбы'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Шайбы'],
                'label' => 'Ш',
                'value' => function (Player $model) {
                    $result = 0;
                    foreach ($model->statisticPlayer as $statisticPlayer) {
                        $result = $result + $statisticPlayer->statistic_player_score;
                    }
                    return $result;
                }
            ],
            [
                'attribute' => 'assist',
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'П',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Результативные передачи'],
                'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Результативные передачи'],
                'label' => 'П',
                'value' => function (Player $model) {
                    $result = 0;
                    foreach ($model->statisticPlayer as $statisticPlayer) {
                        $result = $result + $statisticPlayer->statistic_player_assist;
                    }
                    return $result;
                }
            ],
            [
                'attribute' => 'player_price',
                'contentOptions' => ['class' => 'hidden-xs text-right'],
                'footer' => 'Цена',
                'footerOptions' => ['class' => 'hidden-xs'],
                'headerOptions' => ['class' => 'hidden-xs'],
                'label' => 'Цена',
                'value' => function (Player $model) {
                    return FormatHelper::asCurrency($model->player_price);
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'rowOptions' => function (Player $model) use ($team) {
                $result = [];
                if ($team->myTeam() && $model->squad) {
                    $result['style'] = ['background-color' => '#' . $model->squad->squad_color];
                }
                return $result;
            },
            'showFooter' => true,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('//team/_team-links'); ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
<div class="row margin-top">
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-size-2">
        <span class="italic">Показатели команды:</span>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Рейтинг силы команды (Vs)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_vs; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 21 лучшего (s21)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_s_21; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 26 лучших (s26)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_s_26; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Сила 32 лучших (s32)
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $team->team_power_s_32; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Стоимость строений
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= FormatHelper::asCurrency($team->team_price_base); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                - Общая стоимость
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= FormatHelper::asCurrency($team->team_price_total); ?>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Расскажите друзьям о Лиге:
                <p>
                    <a class="no-underline"
                       href="https://www.facebook.com/sharer/sharer.php?u=<?= Url::to(['site/index'], true); ?>"
                       target="_blank">
                        <i class="fa fa-facebook-official fa-2x" aria-hidden="true"></i>
                    </a>
                    <a class="no-underline"
                       href="https://twitter.com/intent/tweet?text=Виртуальная Хоккейная Лига - лучший бесплатный хоккейный онлайн-менеджер.&url=<?= Url::to(['site/index'], true); ?>"
                       target="_blank">
                        <i class="fa fa-twitter fa-2x" aria-hidden="true"></i>
                    </a>
                    <a class="no-underline" href="https://vk.com/share.php?url=<?= Url::to(['site/index'], true); ?>"
                       target="_blank">
                        <i class="fa fa-vk fa-2x" aria-hidden="true"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 hidden-xs"></div>
    <?php if ($team->myTeam()) : ?>
        <?= $this->render('_team-bottom-forum', ['team' => $team]); ?>
    <?php elseif (Yii::$app->controller->myTeam): ?>
        <?= $this->render('_team-bottom-my-team'); ?>
    <?php endif; ?>
