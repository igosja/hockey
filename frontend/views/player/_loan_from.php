<?php

use common\components\FormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\models\LoanFrom $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <p class="text-center">
            Игрок находится на рынке аренды.
            <br/>
            Начальная стоимость игрока составляет
            <span class="strong"><?= FormatHelper::asCurrency($model->player->loan->loan_price_seller); ?></span>.
            <br/>
            Срок аренды составляет
            <span class="strong">
                <?= $model->player->loan->loan_day_min; ?>-<?= $model->player->loan->loan_day_max; ?>
            </span>
            дней.
        </p>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'off')->hiddenInput(['value' => true])->label(false); ?>
        <p class="text-center">
            <?= Html::submitButton('Снять с рынка аренды', ['class' => 'btn']); ?>
        </p>
        <?php $form->end(); ?>
        <?php if ($model->loanApplicationArray) : ?>
            <p class="text-center">Заявки на вашего игрока:</p>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Команда потенциального арендатора</th>
                    <th class="col-20">Время заявки</th>
                    <th class="col-15">Срок аренды</th>
                </tr>
                <?php foreach ($model->loanApplicationArray as $item): ?>
                    <tr>
                        <td><?= $item->team->teamLink('img'); ?></td>
                        <td class="text-center"><?= FormatHelper::asDatetime($item->loan_application_date); ?></td>
                        <td class="text-center"><?= $item->loan_application_day; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
