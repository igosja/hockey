<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\Logo;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\DetailView;

/**
 * @var Logo $model
 * @var View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a('Список', ['photo/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Одобрить', ['photo/accept', 'id' => $model->logo_id], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Удалить', ['photo/delete', 'id' => $model->logo_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (Logo $model) {
                    return $model->logo_id;
                },
            ],
            [
                'label' => 'Время заявки',
                'value' => function (Logo $model) {
                    return FormatHelper::asDateTime($model->logo_date);
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Пользователь',
                'value' => function (Logo $model) {
                    return $model->user->userLink();
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Старое фото',
                'value' => function (Logo $model) {
                    if (file_exists(Yii::getAlias('@frontend') . '/web/img/user/125/' . $model->logo_user_id . '.png')) {
                        return Html::img(
                            '/img/user/125/' . $model->logo_user_id . '.png?v=' . filemtime(Yii::getAlias('@frontend') . '/web/img/user/125/' . $model->logo_user_id . '.png'),
                            [
                                'alt' => Html::encode($model->user->user_login),
                                'title' => Html::encode($model->user->user_login),
                            ]
                        );
                    }
                    return '';
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Новое фото',
                'value' => function (Logo $model) {
                    if (file_exists(Yii::getAlias('@frontend') . '/web/upload/img/user/125/' . $model->logo_user_id . '.png')) {
                        return Html::img(
                            '/upload/img/user/125/' . $model->logo_user_id . '.png?v=' . filemtime(Yii::getAlias('@frontend') . '/web/upload/img/user/125/' . $model->logo_user_id . '.png'),
                            [
                                'alt' => Html::encode($model->user->user_login),
                                'title' => Html::encode($model->user->user_login),
                            ]
                        );
                    }
                    return '';
                },
            ],
            [
                'label' => 'Комментарий',
                'value' => function (Logo $model) {
                    return HockeyHelper::bbDecode($model->logo_text);
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
