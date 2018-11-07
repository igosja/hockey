<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \frontend\models\TransferFrom $model
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <p class="text-center">
            The player is on a transfer.
            <br/>
            The initial cost of the player is
            <span class="strong"><?php

                try {
                    print Yii::$app->formatter->asCurrency($model->player->transfer->transfer_price_seller);
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?></span>.
        </p>
        <?php if ($model->player->transfer->transfer_to_league): ?>
            <p class="text-center">
                In the absence of demand, the player will be sold to the League.
            </p>
        <?php endif; ?>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'off')->hiddenInput(['value' => true])->label(false); ?>
        <p class="text-center">
            <?= Html::submitButton('Remove from the transfer', ['class' => 'btn']); ?>
        </p>
        <?php $form->end(); ?>
        <?php if ($model->transferApplicationArray) : ?>
            <p class="text-center">Requests for your player:</p>
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Team of the potential buyer</th>
                    <th class="col-20">Application time</th>
                    <th class="col-15">Price</th>
                </tr>
                <?php foreach ($model->transferApplicationArray as $item): ?>
                    <tr>
                        <td>
                            <?= Html::a(
                                $item->team->team_name . '(' . $item->team->stadium->city->city_name . ')',
                                ['team/view', 'id' => $item->transfer_application_team_id]
                            ); ?>
                        </td>
                        <td class="text-center">
                            <?php

                            try {
                                print Yii::$app->formatter->asDatetime($item->transfer_application_date);
                            } catch (Exception $e) {
                                ErrorHelper::log($e);
                            }

                            ?>
                        </td>
                        <td class="text-right">
                            <?php

                            try {
                                print Yii::$app->formatter->asCurrency($item->transfer_application_price);
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
