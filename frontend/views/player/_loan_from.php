<?php

use common\components\ErrorHelper;
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
            Начальная стоимоcть игрока составляет
            <span class="strong"><?php

                try {
                    print Yii::$app->formatter->asCurrency($model->player->loan->loan_price_seller);
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?></span>.
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
                    <th class="col-15">Сумма</th>
                </tr>
                <?php foreach ($model->loanApplicationArray as $item): ?>
                    <tr>
                        <td>
                            <?= Html::a(
                                $item->team->team_name . '(' . $item->team->stadium->city->city_name . ')',
                                ['team/view', 'id' => $item->loan_application_team_id]
                            ); ?>
                        </td>
                        <td class="text-center">
                            <?php

                            try {
                                print Yii::$app->formatter->asDatetime($item->loan_application_date);
                            } catch (Exception $e) {
                                ErrorHelper::log($e);
                            }

                            ?>
                        </td>
                        <td class="text-center"><?= $item->loan_application_day; ?></td>
                        <td class="text-right">
                            <?php

                            try {
                                print Yii::$app->formatter->asCurrency($item->loan_application_price);
                            } catch (Exception $e) {
                                ErrorHelper::log($e);
                            }

                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
    </div>
</div>
