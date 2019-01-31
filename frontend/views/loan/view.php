<?php

use coderlex\wysibb\WysiBB;
use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\LoanApplication;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $applicationDataProvider
 * @var \yii\data\ActiveDataProvider $commentDataProvider
 * @var \frontend\models\LoanVote $model
 * @var \common\models\Loan $loan
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>
                Арендная сделка
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $this->render('//loan/_links'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Игрок:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->player->country->countryImage(); ?>
                    <?= $loan->player->playerLink(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Возраст:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->loan_age; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Позиция:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->position(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Сила:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->loan_power; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Спецвозможности:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->special(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Оценка сделки (+/-):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->rating(); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Дата аренды:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= FormatHelper::asDate($loan->loan_ready); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Стоимость аренды:
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong <?php if ($loan->loan_cancel) : ?>del<?php endif; ?>">
                    <?= FormatHelper::asCurrency($loan->loan_price_buyer); ?>
                    (<?= $loan->loan_day; ?> дн.)
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Арендодатель (команда):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->seller->teamLink('img'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Арендодатель (менеджер):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->managerSeller->userLink(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Арендатор (команда):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->buyer->teamLink('img'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-6 col-xs-6 text-right">
                    Арендатор (менеджер):
                </div>
                <div class="col-lg-7 col-md-7 col-sm-6 col-xs-6 strong">
                    <?= $loan->managerBuyer->userLink(); ?>
                </div>
            </div>
        </div>
    </div>
<?php if (!$loan->loan_checked) : ?>
    <?php foreach ($loan->alerts() as $class => $alert) : ?>
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
                    'value' => function (LoanApplication $model) {
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
                    'value' => function (LoanApplication $model) {
                        return $model->user->userLink();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Время',
                    'label' => 'Время',
                    'value' => function (LoanApplication $model) {
                        return FormatHelper::asDateTime($model->loan_application_date);
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Дней',
                    'label' => 'Дней',
                    'value' => function (LoanApplication $model) {
                        return $model->loan_application_day;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-right'],
                    'footer' => 'Цена',
                    'label' => 'Цена',
                    'value' => function (LoanApplication $model) {
                        return FormatHelper::asCurrency($model->loan_application_price * $model->loan_application_day);
                    }
                ],
                [
                    'footer' => 'Примечание',
                    'label' => 'Примечание',
                    'value' => function (LoanApplication $model) {
                        $result = '';
                        if ($model->dealReason) {
                            $result = $model->dealReason->deal_reason_text;
                        }
                        return $result;
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $applicationDataProvider,
                'rowOptions' => function (LoanApplication $model) use ($loan) {
                    if ($model->loan_application_team_id == $loan->loan_team_buyer_id) {
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
<?php if (!$loan->loan_checked && !Yii::$app->user->isGuest) : ?>
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
    <?php if (!$user->user_date_confirm) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию сделок
                <br/>
                Причина - ваш почтовый адрес не подтверждён
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment_deal >= time()) : ?>
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