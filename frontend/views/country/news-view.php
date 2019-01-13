<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\NewsComment $model
 * @var \common\models\News $news
 * @var \common\models\User $user
 */

$user = Yii::$app->user->identity;

print $this->render('_country');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3>Комментарии к новостям</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        <?= $news->news_title; ?>
        <?php if (!Yii::$app->user->isGuest && $news->news_user_id == Yii::$app->user->id) : ?>
            <span class="text-size-3 font-grey">
                <?= Html::a(
                    'Редактировать',
                    ['country/news-update', 'id' => $news->news_country_id, 'newsId' => $news->news_id]
                ); ?>
                |
                <?= Html::a(
                    'Удалить',
                    ['country/news-delete', 'id' => $news->news_country_id, 'newsId' => $news->news_id]
                ); ?>
            </span>
        <?php endif; ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
        <?= FormatHelper::asDateTime($news->news_date); ?>
        -
        <?= $news->user->userLink(['class' => 'strong']); ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= nl2br(Html::encode($news->news_text)); ?>
    </div>
</div>
<?php if ($dataProvider->models) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'row border-top'],
                'itemView' => '_comment',
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
<?php endif; ?>
<?php if (!Yii::$app->user->isGuest) : ?>
    <?php if ($user->user_date_block_comment_news >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию новостей до
                <?= FormatHelper::asDateTime($user->user_date_block_comment_news); ?>
                <br/>
                Причина - <?= $user->reasonBlockCommentNews->block_reason_text; ?>
            </div>
        </div>
    <?php elseif ($user->user_date_block_comment >= time()) : ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию новостей до
                <?= FormatHelper::asDateTime($user->user_date_block_comment); ?>
                <br/>
                Причина - <?= $user->reasonBlockComment->block_reason_text; ?>
            </div>
        </div>
    <?php else : ?>
        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'errorOptions' => [
                    'class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error',
                    'tag' => 'div'
                ],
                'options' => ['class' => 'row'],
                'template' =>
                    '<div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">{label}</div>
                    </div>
                    <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
                    </div>
                    <div class="row">{error}</div>',
            ],
        ]); ?>
        <?= $form->field($model, 'news_comment_text')->textarea(['rows' => 5])->label('Ваш комментарий:'); ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Комментировать', ['class' => 'btn margin']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    <?php endif; ?>
<?php endif; ?>
