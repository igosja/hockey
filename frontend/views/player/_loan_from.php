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
            The player is on a loan.
            <br/>
            The initial cost of the player is
            <span class="strong"><?php

                try {
                    print Yii::$app->formatter->asCurrency($model->player->loan->loan_price_seller);
                } catch (Throwable $e) {
                    ErrorHelper::log($e);
                }

                ?></span>.
            <br/>
            The lease term is
            <span class="strong">
                <?= $model->player->loan->loan_day_min; ?>-<?= $model->player->loan->loan_day_max; ?>
            </span>
            days.
        </p>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'off')->hiddenInput(['value' => true])->label(false); ?>
        <p class="text-center">
            <?= Html::submitButton('Remove from the loan', ['class' => 'btn']); ?>
        </p>
        <?php $form->end(); ?>
        <?php if ($model->loanApplicationArray) : ?>
            <p class="text-center">Requests for your player:</p>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Team of the potential buyer</th>
                    <th class="col-20">Application time</th>
                    <th class="col-15">Price</th>
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
                            } catch (Throwable $e) {
                                ErrorHelper::log($e);
                            }

                            ?>
                        </td>
                        <td class="text-right">
                            <?php

                            try {
                                print Yii::$app->formatter->asCurrency($item->loan_application_price);
                            } catch (Throwable $e) {
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
