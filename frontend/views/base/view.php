<?php

use common\components\ErrorHelper;
use yii\helpers\Html;

/**
 * @var \common\models\Team $team
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//team/_team-top-left', ['team' => $team, 'teamId' => $team->team_id]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"></div>
</div>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">База команды</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <?= Html::img(
                        '/img/base/base.png',
                        [
                            'alt' => 'База команды',
                            'class' => 'img-border img-base',
                        ]
                    ); ?>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень:
                            <span class="strong"><?= $team->base->base_level; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Стоимость:
                            <span class="strong">
                                <?php

                                try {
                                    print Yii::$app->formatter->asCurrency($team->base->base_price_buy, 'USD');
                                } catch (Exception $e) {
                                    ErrorHelper::log($e);
                                }

                                ?>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Слотов:
                            <span class="strong">
                                <?= $team->base->base_slot_min; ?>-<?= $team->base->base_slot_max; ?>
                            </span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Занято слотов:
                            <span class="strong"><?= $team->baseUsed(); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Содержание:
                            <span class="strong">
                                <?php

                                try {
                                    print Yii::$app->formatter->asCurrency($team->baseMaintenance(), 'USD');
                                } catch (Exception $e) {
                                    ErrorHelper::log($e);
                                }

                                ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Тренировочный центр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <?= Html::img(
                        '/img/base/training.png',
                        [
                            'alt' => 'Тренировочный центр',
                            'class' => 'img-border img-base',
                        ]
                    ); ?>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень:
                            <span class="strong"><?= $team->baseTraining->base_training_level; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Доступно:
                            <span class="strong"><?= $team->baseTraining->base_training_power_count; ?></span> бал.
                            |
                            <span class="strong"><?= $team->baseTraining->base_training_special_count; ?></span> спец.
                            |
                            <span class="strong"><?= $team->baseTraining->base_training_position_count; ?></span> поз.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Скорость:
                            <span class="strong">
                                <?= $team->baseTraining->base_training_training_speed_min; ?>
                                -<?= $team->baseTraining->base_training_training_speed_max; ?>%
                            </span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Осталось:
                            <span class="strong"><?= 0; ?></span> бал.
                            |
                            <span class="strong"><?= 0; ?></span> спец.
                            |
                            <span class="strong"><?= 0; ?></span> поз.
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Медцентр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <?= Html::img(
                        '/img/base/medical.png',
                        [
                            'alt' => 'Медицинский центр',
                            'class' => 'img-border img-base',
                        ]
                    ); ?>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень:
                            <span class="strong"><?= $team->baseMedical->base_medical_level; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Базовая усталость:
                            <span class="strong"><?= $team->baseMedical->base_medical_tire; ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Центр физподготовки</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <?= Html::img(
                        '/img/base/physical.png',
                        [
                            'alt' => 'Центр физподготовки',
                            'class' => 'img-border img-base',
                        ]
                    ); ?>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень:
                            <span class="strong"><?= $team->basePhysical->base_physical_level; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Изменений формы:
                            <span class="strong"><?= $team->basePhysical->base_physical_change_count; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Увеличение усталости:
                            <span class="strong"><?= $team->basePhysical->base_physical_tire_bonus; ?>%</span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Осталось изменений: <span class="strong"><?= 0; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Запланировано: <span class="strong"><?= 0; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Спортшкола</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <?= Html::img(
                        '/img/base/school.png',
                        [
                            'alt' => 'Спортивная школа',
                            'class' => 'img-border img-base',
                        ]
                    ); ?>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень:
                            <span class="strong"><?= $team->baseSchool->base_school_level; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Молодежь: <span class="strong"><?= $team->baseSchool->base_school_player_count; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Осталось игроков: <span class="strong"><?= 0; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Скаут-центр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <?= Html::img(
                        '/img/base/scout.png',
                        [
                            'alt' => 'Скаут-центр',
                            'class' => 'img-border img-base',
                        ]
                    ); ?>
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $team->baseScout->base_scout_base_level; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Доступно изучений стилей:
                            <span class="strong"><?= $team->baseScout->base_scout_my_style_count; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Осталось изучений стилей:
                            <span class="strong"><?= 0; ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>