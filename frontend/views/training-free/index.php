<?php

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Team;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var bool $onBuilding
 * @var Team $team
 * @var \yii\web\View $this
 * @var \common\models\Training[] $trainingArray
 * @var \common\models\User $user
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Бонусные тренировки
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось тренировок силы:
                <span class="strong"><?= $user->user_shop_point; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось спецвозможностей:
                <span class="strong"><?= $user->user_shop_position; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось совмещений:
                <span class="strong"><?= $user->user_shop_special; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в тренировочном центре</span> -
        вы можете назначить тренировки силы, спецвозможностей или совмещений своим игрокам:
    </div>
</div>
<?php if ($trainingArray) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            Игроки вашей команды, находящиеся на тренировке:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th class="col-1 hidden-xs" title="Национальность">Нац</th>
                    <th class="col-5" title="Возраст">В</th>
                    <th class="col-10" title="Номинальная сила">С</th>
                    <th class="col-10" title="Позиция">Поз</th>
                    <th class="col-10" title="Спецвозможности">Спец</th>
                    <th class="col-10" title="Прогресс тренировки">%</th>
                    <th class="col-1"></th>
                </tr>
                <?php foreach ($trainingArray as $item) : ?>
                    <tr>
                        <td>
                            <?= $item->player->playerLink(); ?>
                        </td>
                        <td class="hidden-xs text-center">
                            <?= $item->player->country->countryImageLink(); ?>
                        </td>
                        <td class="text-center"><?= $item->player->player_age; ?></td>
                        <td class="text-center">
                            <?= $item->player->player_power_nominal; ?>
                            <?php if ($item->training_power) : ?>
                                + 1
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?= $item->player->position(); ?>
                            <?php if ($item->training_position_id) : ?>
                                + <?= $item->position->position_name; ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?= $item->player->special(); ?>
                            <?php if ($item->training_special_id) : ?>
                                + <?= $item->special->special_name; ?>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?= $item->training_percent; ?>%
                        </td>
                        <td class="text-center">
                            <?= Html::a(
                                '<i class="fa fa-times-circle"></i>',
                                ['training/cancel', 'id' => $item->training_id],
                                ['title' => 'Отменить тренировку']
                            ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th>Игрок</th>
                    <th class="hidden-xs" title="Национальность">Нац</th>
                    <th title="Возраст">В</th>
                    <th title="Позиция">Поз</th>
                    <th title="Номинальная сила">С</th>
                    <th title="Спецвозможности">Спец</th>
                    <th title="Прогресс тренировки">%</th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>
<?php endif; ?>
<?= Html::beginForm(['training-free/index']); ?>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'footer' => 'Игрок',
                'format' => 'raw',
                'label' => 'Игрок',
                'value' => function (Player $model) {
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
                'value' => function (Player $model) {
                    return $model->country->countryImage();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'В',
                'footerOptions' => ['title' => 'Возраст'],
                'headerOptions' => ['class' => 'col-5', 'title' => 'Возраст'],
                'label' => 'В',
                'value' => function (Player $model) {
                    return $model->player_age;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'С',
                'footerOptions' => ['title' => 'Номинальная сила'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-10', 'title' => 'Номинальная сила'],
                'label' => 'С',
                'value' => function (Player $model) {
                    $result = $model->player_power_nominal;
                    if ($model->player_date_no_action < time()) {
                        $result = $result
                            . ' '
                            . Html::checkbox('power[' . $model->player_id . ']');
                    }
                    return $result;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-15', 'title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model) {
                    $result = '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">'
                        . $model->position()
                        . '</div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
                    if ($model->player_date_no_action < time()) {
                        $result = $result . ' ' . $model->trainingPositionDropDownList();
                    }
                    $result = $result . '</div></div>';
                    return $result;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-15', 'title' => 'Спецвозможности'],
                'label' => 'Спец',
                'value' => function (Player $model) {
                    $result = '<div class="row"><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">'
                        . $model->special()
                        . '</div><div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">';
                    if ($model->player_date_no_action < time()) {
                        $result = $result . ' ' . $model->trainingSpecialDropDownList();
                    }
                    $result = $result . '</div></div>';
                    return $result;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'rowOptions' => function (Player $model) {
                if ($model->squad) {
                    return ['style' => ['background-color' => '#' . $model->squad->squad_color]];
                }
                return [];
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Продолжить', ['class' => 'btn margin']); ?>
    </div>
</div>
<?= Html::endForm(); ?>
<?= $this->render('//site/_show-full-table'); ?>
