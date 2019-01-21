<?php

use coderlex\wysibb\WysiBB;
use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\TransferApplication;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $applicationDataProvider
 * @var \yii\data\ActiveDataProvider $commentDataProvider
 * @var \frontend\models\TransferVote $model
 * @var \common\models\Transfer $transfer
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>
                Трансферная сделка
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $this->render('//transfer/_links'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Игрок:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->player->country->countryImage(); ?>
                    <?= $transfer->player->playerLink(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Возраст:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->transfer_age; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Позиция:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->position(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Сила:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->transfer_power; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Спецвозможности:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->special(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Оценка сделки (+/-):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->rating(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Дата трансфера:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= FormatHelper::asDate($transfer->transfer_ready); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Стоимость трансфера:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong <?php if ($transfer->transfer_cancel) : ?>del<?php endif; ?>">
                    <?= FormatHelper::asCurrency($transfer->transfer_price_buyer); ?>
                    (<?= round($transfer->transfer_price_buyer / $transfer->transfer_player_price * 100); ?>%)
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Продавец (команда):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->seller->teamLink('img'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Продавец (менеджер):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->managerSeller->userLink(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Покупатель (команда):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->buyer->teamLink('img'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Покупатель (менеджер):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $transfer->managerBuyer->userLink(); ?>
                </div>
            </div>
        </div>
    </div>
<?php if (!$transfer->transfer_checked) : ?>
    <?php foreach ($transfer->alerts() as $class => $alert) : ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 alert <?= $class; ?> margin-top-small">
                <ul>
                    <?php foreach ($alert as $item) : ?>
                        <li><?= $item; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
    <div class="row margin-top">
        <?php

        try {
            $columns = [
                [
                    'footer' => 'Команда',
                    'format' => 'raw',
                    'label' => 'Команда',
                    'value' => function (TransferApplication $model) {
                        return $model->team->teamLink('img');
                    }
                ],
                [
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Менеджер',
                    'footerOptions' => ['class' => 'hidden-xs'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs'],
                    'label' => 'Менеджер',
                    'value' => function (TransferApplication $model) {
                        return $model->user->userLink();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Время',
                    'label' => 'Время',
                    'value' => function (TransferApplication $model) {
                        return FormatHelper::asDateTime($model->transfer_application_date);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-right'],
                    'footer' => 'Цена',
                    'label' => 'Цена',
                    'value' => function (TransferApplication $model) {
                        return FormatHelper::asCurrency($model->transfer_application_price);
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $applicationDataProvider,
                'rowOptions' => function (TransferApplication $model) use ($transfer) {
                    if ($model->transfer_application_team_id == $transfer->transfer_team_buyer_id) {
                        return ['class' => 'info'];
                    }
                    return [];
                },
                'showFooter' => true,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
<?= $this->render('//site/_show-full-table'); ?>
<?php if ($commentDataProvider->models) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $commentDataProvider,
                'itemOptions' => ['class' => 'row border-top'],
                'itemView' => '_comment',
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
<?php endif; ?>
<?php if (!$transfer->transfer_checked && !Yii::$app->user->isGuest) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
            Ваше мнение:
        </div>
    </div>
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'errorOptions' => [
                'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 notification-error',
                'tag' => 'div'
            ],
        ],
    ]); ?>
    <?= $form
        ->field($model, 'vote')
        ->radioList(
            [1 => 'Честная сделка', -1 => 'Нечестная сделка'],
            [
                'item' => function ($index, $label, $name, $checked, $value) {
                    return Html::radio($name, $checked, [
                            'index' => $index,
                            'label' => $label,
                            'value' => $value,
                        ]) . '<br/>';
                }
            ]
        )
        ->label(false); ?>
    <?php if ($user->user_date_block_comment_deal >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию сделок до
                <?= FormatHelper::asDateTime($user->user_date_block_comment_deal); ?>
                <br/>
                Причина - <?= $user->reasonBlockCommentDeal->block_reason_text; ?>
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию сделок до
                <?= FormatHelper::asDateTime($user->user_date_block_comment); ?>
                <br/>
                Причина - <?= $user->reasonBlockComment->block_reason_text; ?>
            </div>
        </div>
    <?php else : ?>
        <br/>
        <div class="row margin-top">
            <?= $form->field($model, 'comment')->widget(WysiBB::class)->label(false); ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= Html::submitButton('Сохранить', ['class' => 'btn margin']); ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
<?php endif; ?>