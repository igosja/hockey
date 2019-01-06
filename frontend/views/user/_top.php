<?php

use common\components\FormatHelper;
use common\models\User;
use yii\helpers\Html;

$user = User::find()->where(['user_id' => Yii::$app->request->get('id', Yii::$app->user->id)])->one();

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                <?= $user->fullName(); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Последний визит: <?= $user->lastVisit(); ?>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник:
                <?= $user->iconVip(); ?>
                <span class="strong"><?= $user->user_login; ?></span>
                <?php if ($user->canDialog()) : ?>
                    <?= Html::a(
                        '<i class="fa fa-envelope-o"></i>',
                        ['messenger/view', 'id' => $user->user_id]
                    ); ?>
                <?php endif; ?>
                <?php if ($user->user_holiday) : ?>
                    <span class="italic">(в отпуске)</span>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Личный счет:
                <span class="strong"><?= FormatHelper::asCurrency($user->user_finance); ?></span>
            </div>
        </div>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->request->get('id') == Yii::$app->user->id) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Денежный счет: <span class="strong"><?= $user->user_money; ?> ед.</span>
                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Рейтинг: <span class="strong"><?= $user->user_rating; ?></span>
            </div>
        </div>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->request->get('id') == Yii::$app->user->id) : ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    VIP-клуб:
                    <span class="strong">
                        <?php if ($user->isVip()) {
                            $vipText = 'до ' . FormatHelper::asDatetime($user->user_date_vip);
                        } else {
                            $vipText = 'не активирован';
                        } ?>
                        <?= Html::a($vipText, ['vip/index']); ?>
                    </span>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Профиль менеджера
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                День рождения:
                <span class="strong">
                    <?= $user->birthDay(); ?>
                </span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Пол: <span class="strong"><?= $user->sex ? $user->sex->sex_name : ''; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Откуда: <span class="strong"><?= $user->userFrom(); ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Дата регистрации:
                <span class="strong"><?= FormatHelper::asDate($user->user_date_register); ?></span>
            </div>
        </div>
    </div>
</div>
