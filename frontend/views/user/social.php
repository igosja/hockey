<?php

use common\models\User;
use frontend\models\OAuthFacebook;
use frontend\models\OAuthGoogle;
use frontend\models\OAuthVk;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var User $model
 */

print $this->render('_top');

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_user-links'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <tr>
                <th>Мои профили в соцальных сетях</th>
            </tr>
        </table>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center margin-top">
            {label}
            {input}
            </div>',
    ],
]); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        На этой странице вы можете
        <span class="strong">соединить ваш аккаунт менеджера с теми социальными сетями</span>,
        которыми вы пользуетесь.
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
        <i class="fa fa-facebook-square"></i>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php if ($model->user_social_facebook_id) : ?>
            <?= Html::a(
                'Профиль',
                'javascript:'
            ); ?>
            [<?= Html::a(
                'Отключить',
                ['social/disconnect', 'id' => 'fb']
            ); ?>]
        <?php else: ?>
            <?= Html::a(
                'Подключить',
                OAuthFacebook::getConnectUrl('connect')
            ); ?>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
        <i class="fa fa-google-plus-square"></i>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php if ($model->user_social_google_id) : ?>
            <?= Html::a(
                'Профиль',
                'javascript:'
            ); ?>
            [<?= Html::a(
                'Отключить',
                ['social/disconnect', 'id' => 'gl']
            ); ?>]
        <?php else: ?>
            <?= Html::a(
                'Подключить',
                OAuthGoogle::getConnectUrl('connect')
            ); ?>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
        <i class="fa fa-vk"></i>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php if ($model->user_social_vk_id) : ?>
            <?= Html::a(
                'Профиль',
                'https://vk.com/id' . $model->user_social_vk_id,
                ['target' => '_blank']
            ); ?>
            [<?= Html::a(
                'Отключить',
                ['social/disconnect', 'id' => 'vk']
            ); ?>]
        <?php else: ?>
            <?= Html::a(
                'Подключить',
                OAuthVk::getConnectUrl('connect')
            ); ?>
        <?php endif; ?>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Это позволит входить в игру нажатием одной кнопки.
    </div>
</div>
<?= $form->field($model, 'user_show_social')->checkbox(['label' => false])->label(
    'Показывать мои профили в социальных сетях другим менеджерам'
); ?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
