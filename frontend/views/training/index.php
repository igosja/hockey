<?php

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Team;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Team $team
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team, 'teamId' => $team->team_id]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Тренировочный центр
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Уровень:
                <span class="strong"><?= $team->baseTraining->base_training_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Скорость тренировки:
                <span class="strong"><?= $team->baseTraining->base_training_training_speed_min; ?>%</span>
                -
                <span class="strong"><?= $team->baseTraining->base_training_training_speed_max; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось тренировок силы:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_power_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось спецвозможностей:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_special_count; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Осталось совмещений:
                <span class="strong"><?= 0; ?></span>
                из
                <span class="strong"><?= $team->baseTraining->base_training_position_count; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <span class="strong">Стоимость тренировок:</span>
        Балл силы
        <span class="strong">
            <?php

            try {
                print Yii::$app->formatter->asCurrency($team->baseTraining->base_training_power_price, 'USD');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </span>
        Спецвозможность
        <span class="strong">
            <?php

            try {
                print Yii::$app->formatter->asCurrency($team->baseTraining->base_training_special_price, 'USD');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </span>
        Совмещение
        <span class="strong">
            <?php

            try {
                print Yii::$app->formatter->asCurrency($team->baseTraining->base_training_position_price, 'USD');
            } catch (Exception $e) {
                ErrorHelper::log($e);
            }

            ?>
        </span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в тренировочном центре</span> -
        вы можете назначить тренировки силы, спецвозможностей или совмещений своим игрокам:
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Player $model): string {
                    return $model->playerLink();
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footer' => 'Нац',
                'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Национальность'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Национальность'],
                'label' => 'Нац',
                'value' => function (Player $model): string {
                    return $model->country->countryImage();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Возраст'],
                'label' => 'В',
                'value' => function (Player $model): string {
                    return $model->player_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Номинальная сила'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Номинальная сила'],
                'label' => 'С',
                'value' => function (Player $model): string {
                    return $model->player_power_nominal;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'headerOptions' => ['class' => 'col-15', 'title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model): string {
                    return $model->position();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'headerOptions' => ['class' => 'col-15', 'title' => 'Спецвозможности'],
                'label' => 'Спец',
                'value' => function (Player $model): string {
                    return $model->special();
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showFooter' => true,
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<?= $this->render('//site/_show-full-table'); ?>
