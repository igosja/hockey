<?php

use common\components\ErrorHelper;
use common\models\Player;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\National $national
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//national/_national-top-left', ['national' => $national]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?= $this->render('//national/_national-top-right', ['national' => $national]); ?>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('//national/_national-links'); ?>
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
                        . $model->iconInjury();
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
                'value' => function (Player $model) use ($national) {
                    return $national->myTeam() ? $model->player_tire : '?';
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
                'value' => function (Player $model) use ($national) {
                    return $national->myTeam() ? $model->physical->image() : '?';
                }
            ],
            [
                'attribute' => 'power_real',
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'РС',
                'footerOptions' => ['title' => 'Реальная сила'],
                'headerOptions' => ['title' => 'Реальная сила'],
                'label' => 'РС',
                'value' => function (Player $model) use ($national) {
                    return $national->myTeam() ? $model->player_power_real : '~' . $model->player_power_nominal;
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
                'attribute' => 'style',
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
                    return $model->player_game_row;
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
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'rowOptions' => function (Player $model) use ($national) {
                $result = [];
                if ($national->myTeam() && $model->squadNational) {
                    $result['style'] = ['background-color' => '#' . $model->squadNational->squad_color];
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
        <?= $this->render('//national/_national-links'); ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
