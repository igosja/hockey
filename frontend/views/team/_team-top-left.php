<?php

/**
 * @var \common\models\Team $team
 */

use common\components\FormatHelper;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-lg-3 col-md-4 col-sm-3 col-xs-4 text-center team-logo-div">
        <?= Html::a(
            $team->logo(),
            ['team/logo', 'id' => $team->team_id],
            ['class' => 'team-logo-link']
        ); ?>
    </div>
    <div class="col-lg-9 col-md-8 col-sm-9 col-xs-8">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                <?= $team->fullName(); ?>
            </div>
        </div>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Дивизион: <?= $team->division(); ?>
            </div>
        </div>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Менеджер:
                <?php if ($team->manager->canDialog()) : ?>
                    <?= Html::a(
                        '<i class="fa fa-envelope-o"></i>',
                        ['dialog/view', 'id' => $team->manager->user_id]
                    ); ?>
                <?php endif; ?>
                <?= Html::a(
                    $team->manager->fullName(),
                    ['user/view', 'id' => $team->manager->user_id],
                    ['class' => 'strong']
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник:
                <?= $team->manager->iconVip(); ?>
                <?= $team->manager->userLink(['class' => 'strong']); ?>
            </div>
        </div>
        <?php if ($team->team_vice_id) : ?>
            <div class="row margin-top-small">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Заместитель:
                    <?php if ($team->vice->canDialog()) : ?>
                        <?= Html::a(
                            '<i class="fa fa-envelope-o"></i>',
                            ['dialog/view', 'id' => $team->vice->user_id]
                        ); ?>
                    <?php endif; ?>
                    <?= Html::a(
                        $team->vice->fullName(),
                        ['user/view', 'id' => $team->vice->user_id],
                        ['class' => 'strong']
                    ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Ник:
                    <?= $team->manager->iconVip(); ?>
                    <?= $team->vice->userLink(['class' => 'strong']); ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Стадион:
                <?= $team->stadium->stadium_name; ?>,
                <strong><?= Yii::$app->formatter->asInteger($team->stadium->stadium_capacity); ?></strong>
                <?php if ($team->myTeam()) : ?>
                    <?= Html::a(
                        '<i class="fa fa-search" aria-hidden="true"></i>',
                        ['stadium/increase']
                    ); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                База:
                <span class="strong"><?= $team->base->base_level; ?></span> уровень
                (<span class="strong"><?= $team->baseUsed(); ?></span>
                из
                <span class="strong"><?= $team->base->base_slot_max; ?></span>)
                <?= Html::a(
                    '<i class="fa fa-search" aria-hidden="true"></i>',
                    ['base/view', 'id' => $team->team_id]
                ); ?>
            </div>
        </div>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Финансы:
                <span class="strong">
                    <?= FormatHelper::asCurrency($team->team_finance); ?>
                </span>
            </div>
        </div>
    </div>
</div>