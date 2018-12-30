<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Player;
use yii\grid\GridView;
use yii\helpers\Html;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var bool $onBuilding
 * @var \common\models\Scout[] $scoutArray
 * @var \common\models\Team $team
 * @var \yii\web\View $this
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                Скаут центр
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Уровень:
                <span class="strong"><?= $team->baseScout->base_scout_level; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Скорость изучения:
                <span class="strong"><?= $team->baseScout->base_scout_scout_speed_min; ?>%</span>
                -
                <span class="strong"><?= $team->baseScout->base_scout_scout_speed_max; ?>%</span>
                за тур
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 <?php if ($onBuilding) : ?>del<?php endif; ?>">
                Осталось изучений стилей:
                <span class="strong"><?= $team->availableScout(); ?></span>
                из
                <span class="strong"><?= $team->baseScout->base_scout_my_style_count; ?></span>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center <?php if ($onBuilding) : ?>del<?php endif; ?>">
        <span class="strong">Стоимость изучения:</span>
        Стиля
        <span class="strong">
            <?= FormatHelper::asCurrency($team->baseScout->base_scout_my_style_price); ?>
        </span>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Здесь - <span class="strong">в скаут центре</span> -
        вы можете изучить любимые стили игроков:
    </div>
</div>
<?php if ($scoutArray) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            Игроки вашей команды, находящиеся на изучении:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th class="col-1 hidden-xs" title="Национальность">Нац</th>
                    <th class="col-10" title="Позиция">Поз</th>
                    <th class="col-5" title="Возраст">В</th>
                    <th class="col-10" title="Номинальная сила">С</th>
                    <th class="col-15 hidden-xs" title="Спецвозможности">Спец</th>
                    <th class="col-10">Изучение</th>
                    <th class="col-10" title="Прогресс изучения">%</th>
                    <th class="col-1"></th>
                </tr>
                <?php foreach ($scoutArray as $item) : ?>
                    <tr>
                        <td>
                            <?= $item->player->playerLink(); ?>
                        </td>
                        <td class="hidden-xs text-center">
                            <?= $item->player->country->countryImageLink(); ?>
                        </td>
                        <td class="text-center"><?= $item->player->position(); ?></td>
                        <td class="text-center"><?= $item->player->player_age; ?></td>
                        <td class="text-center"><?= $item->player->player_power_nominal; ?></td>
                        <td class="hidden-xs text-center"><?= $item->player->special(); ?></td>
                        <td class="text-center">Стиль</td>
                        <td class="text-center"><?= $item->scout_percent; ?>%</td>
                        <td class="text-center">
                            <?= Html::a(
                                '<i class="fa fa-times-circle"></i>',
                                ['scout/cancel', 'id' => $item->scout_id],
                                ['title' => 'Отменить изучение']
                            ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <th>Игрок</th>
                    <th class="hidden-xs" title="Национальность">Нац</th>
                    <th title="Позиция">Поз</th>
                    <th title="Возраст">В</th>
                    <th title="Номинальная сила">С</th>
                    <th class="col-15 hidden-xs" title="Спецвозможности">Спец</th>
                    <th class="col-10">Изучение</th>
                    <th class="col-10" title="Прогресс изучения">%</th>
                    <th></th>
                </tr>
            </table>
        </div>
    </div>
<?php endif; ?>
<?= Html::beginForm(['scout/index']); ?>
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
                'footer' => 'Поз',
                'footerOptions' => ['title' => 'Позиция'],
                'headerOptions' => ['class' => 'col-10', 'title' => 'Позиция'],
                'label' => 'Поз',
                'value' => function (Player $model): string {
                    return $model->position();
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
                'footer' => 'Спец',
                'footerOptions' => ['title' => 'Спецвозможности'],
                'headerOptions' => ['class' => 'col-15', 'title' => 'Спецвозможности'],
                'label' => 'Спец',
                'value' => function (Player $model): string {
                    return $model->special();
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'footer' => 'Стиль',
                'format' => 'raw',
                'headerOptions' => ['class' => 'col-15'],
                'label' => 'Стиль',
                'value' => function (Player $model): string {
                    $result = '';
                    if ($model->countScout() < 2) {
                        $result = $result
                            . ' '
                            . Html::checkbox('style[' . $model->player_id . ']');
                    }
                    return $result . ' ' . $model->iconStyle();
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'rowOptions' => function (Player $model) {
                return ['style' => ['background-color' => '#' . $model->squad->squad_color]];
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
