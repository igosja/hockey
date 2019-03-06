<?php

/**
 * @var \common\models\National $national
 */

use common\components\FormatHelper;
use yii\helpers\Html;

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                <?= $national->fullName(); ?>
            </div>
        </div>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Дивизион: <?= $national->division(); ?>
            </div>
        </div>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Менеджер:
                <?php if ($national->manager->canDialog()) : ?>
                    <?= Html::a(
                        '<i class="fa fa-envelope-o"></i>',
                        ['messenger/view', 'id' => $national->user->user_id]
                    ); ?>
                <?php endif; ?>
                <?= Html::a(
                    $national->user->fullName(),
                    ['user/view', 'id' => $national->user->user_id],
                    ['class' => 'strong']
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник:
                <?= $national->user->iconVip(); ?>
                <?= $national->user->userLink(['class' => 'strong']); ?>
            </div>
        </div>
        <?php if ($national->team_vice_id) : ?>
            <div class="row margin-top-small">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Заместитель:
                    <?php if ($national->vice->canDialog()) : ?>
                        <?= Html::a(
                            '<i class="fa fa-envelope-o"></i>',
                            ['messenger/view', 'id' => $national->vice->user_id]
                        ); ?>
                    <?php endif; ?>
                    <?= Html::a(
                        $national->vice->fullName(),
                        ['user/view', 'id' => $national->vice->user_id],
                        ['class' => 'strong']
                    ); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Ник:
                    <?= $national->manager->iconVip(); ?>
                    <?= $national->vice->userLink(['class' => 'strong']); ?>
                </div>
            </div>
        <?php endif; ?>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Стадион:
                <?= $national->stadium->stadium_name; ?>,
                <strong><?= Yii::$app->formatter->asInteger($national->stadium->stadium_capacity); ?></strong>
            </div>
        </div>
        <div class="row margin-top-small">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Финансы:
                <span class="strong">
                    <?= FormatHelper::asCurrency($national->national_finance); ?>
                </span>
            </div>
        </div>
    </div>
</div>