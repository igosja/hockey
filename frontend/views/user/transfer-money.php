<?php

use common\components\FormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var array $countryArray
 * @var \frontend\models\UserTransferMoney $model
 * @var array $teamArray
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
                <th>Перевод денег с личного счёта</th>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Вы собираетесь провести процедуру перерегистрации команды
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <p class="text-center">
            Деньги на личном счете менеджера появляются как премиальные за написание обзоров,
            участие в пресс-конференциях, тренерскую работу в сборных либо за воспитание подопечных.
        </p>
        <p class="text-center">
            На этой странице вы можете перевести деньги с вашего личного счета
            на счет выбранной команды или в фонд федерации.
        </p>
        <p class="text-center">Заполните форму для перевода денег:</p>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center notification-error',
                    'tag' => 'div'
                ],
                'options' => ['class' => 'row'],
                'template' =>
                    '<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">{label}</div>
                    <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">{input}</div>
                    {error}',
            ],
        ]); ?>
        <?= $form
            ->field($model, 'teamId')
            ->dropDownList($teamArray, ['class' => 'form-control', 'prompt' => 'Выберите команду'])
            ->label('Команда'); ?>
        <?= $form
            ->field($model, 'countryId')
            ->dropDownList($countryArray, ['class' => 'form-control', 'prompt' => 'Выберите федерацию'])
            ->label('Федерация'); ?>
        <div class="row">
            <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                Доступно
            </div>
            <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                <span class="strong"><?= FormatHelper::asCurrency($model->user->user_finance); ?></span>
            </div>
        </div>
        <?= $form
            ->field($model, 'sum')
            ->textInput(['class' => 'form-control', 'type' => 'number'])
            ->label('Сумма, $'); ?>
        <?= $form
            ->field($model, 'comment')
            ->textarea(['class' => 'form-control'])
            ->label('Комментарий'); ?>
        <p class="text-center">
            <?= Html::submitButton('Перевести', ['class' => 'btn margin']); ?>
        </p>
        <?php ActiveForm::end(); ?>
    </div>
</div>