<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\User;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var User $model
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a('Список', ['user/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['user/update', 'id' => $model->user_id], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a(
            'Вход',
            ['user/auth', 'id' => $model->user_id],
            ['class' => 'btn btn-default', 'target' => '_blank']
        ); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (User $model) {
                    return $model->user_id;
                },
            ],
            [
                'label' => 'Логин',
                'value' => function (User $model) {
                    return $model->user_login;
                },
            ],
            [
                'label' => 'Email',
                'value' => function (User $model) {
                    return $model->user_email;
                },
            ],
            [
                'label' => 'Баланс',
                'value' => function (User $model) {
                    return $model->user_money;
                },
            ],
            [
                'label' => 'Дата последнего посещения',
                'value' => function (User $model) {
                    return $model->lastVisit();
                },
            ],
            [
                'label' => 'Дата регистрации',
                'value' => function (User $model) {
                    return FormatHelper::asDateTime($model->user_date_register);
                },
            ],
            [
                'label' => 'Доступ ко всем комментариям',
                'value' => function (User $model) {
                    if ($model->user_date_block_comment > time()) {
                        $result = 'Заблокирован до ' . FormatHelper::asDateTime($model->user_date_block_comment);
                    } else {
                        $result = 'Открыт ' . Html::a(
                                'Блокировать',
                                ['user/block-comment', 'id' => $model->user_id],
                                ['class' => 'btn btn-default btn-xs']
                            );
                    }
                    return $result;
                },
            ],
            [
                'label' => 'Доступ к комментариям сделок',
                'value' => function (User $model) {
                    if ($model->user_date_block_comment_deal > time()) {
                        $result = 'Заблокирован до ' . FormatHelper::asDateTime($model->user_date_block_comment_deal);
                    } else {
                        $result = 'Открыт ' . Html::a(
                                'Блокировать',
                                ['user/block-comment-deal', 'id' => $model->user_id],
                                ['class' => 'btn btn-default btn-xs']
                            );
                    }
                    return $result;
                },
            ],
            [
                'label' => 'Доступ к комментариям сделок',
                'value' => function (User $model) {
                    if ($model->user_date_block_forum > time()) {
                        $result = 'Заблокирован до ' . FormatHelper::asDateTime($model->user_date_block_forum);
                    } else {
                        $result = 'Открыт ' . Html::a(
                                'Блокировать',
                                ['user/block-forum', 'id' => $model->user_id],
                                ['class' => 'btn btn-default btn-xs']
                            );
                    }
                    return $result;
                },
            ],
            [
                'label' => 'Доступ к комментариям матчей',
                'value' => function (User $model) {
                    if ($model->user_date_block_comment_game > time()) {
                        $result = 'Заблокирован до ' . FormatHelper::asDateTime($model->user_date_block_comment_game);
                    } else {
                        $result = 'Открыт ' . Html::a(
                                'Блокировать',
                                ['user/block-comment-game', 'id' => $model->user_id],
                                ['class' => 'btn btn-default btn-xs']
                            );
                    }
                    return $result;
                },
            ],
            [
                'label' => 'Доступ к комментариям новостей',
                'value' => function (User $model) {
                    if ($model->user_date_block_comment_news > time()) {
                        $result = 'Заблокирован до ' . FormatHelper::asDateTime($model->user_date_block_comment_news);
                    } else {
                        $result = 'Открыт ' . Html::a(
                                'Блокировать',
                                ['user/block-comment-news', 'id' => $model->user_id],
                                ['class' => 'btn btn-default btn-xs']
                            );
                    }
                    return $result;
                },
            ],
        ];
        print DetailView::widget([
            'attributes' => $attributes,
            'model' => $model,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
