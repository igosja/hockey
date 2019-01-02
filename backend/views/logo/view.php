<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Logo;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var Logo $model
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
        <?= Html::a('Список', ['logo/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Одобрить', ['logo/accept', 'id' => $model->logo_id], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Удалить', ['logo/delete', 'id' => $model->logo_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (Logo $model): string {
                    return $model->logo_id;
                },
            ],
            [
                'label' => 'Время заявки',
                'value' => function (Logo $model): string {
                    return FormatHelper::asDateTime($model->logo_date);
                },
            ],
            [
                'label' => 'Команда',
                'value' => function (Logo $model): string {
                    return $model->team->team_name;
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Пользователь',
                'value' => function (Logo $model): string {
                    return $model->user->userLink();
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Старый логотип',
                'value' => function (Logo $model): string {
                    if (file_exists(Yii::getAlias('@frontend') . '/web/img/team/125/' . $model->team->team_id . '.png')) {
                        return Html::img(
                            '/img/team/125/' . $model->team->team_id . '.png?v=' . filemtime(Yii::getAlias('@frontend') . '/web/img/team/125/' . $model->team->team_id . '.png'),
                            [
                                'alt' => $model->team->team_name,
                                'title' => $model->team->team_name,
                            ]
                        );
                    }
                    return '';
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Новый логотип',
                'value' => function (Logo $model): string {
                    if (file_exists(Yii::getAlias('@frontend') . '/web/upload/img/team/125/' . $model->team->team_id . '.png')) {
                        return Html::img(
                            '/upload/img/team/125/' . $model->team->team_id . '.png?v=' . filemtime(Yii::getAlias('@frontend') . '/web/upload/img/team/125/' . $model->team->team_id . '.png'),
                            [
                                'alt' => $model->team->team_name,
                                'title' => $model->team->team_name,
                            ]
                        );
                    }
                    return '';
                },
            ],
            [
                'label' => 'Комментарий',
                'value' => function (Logo $model): string {
                    return $model->logo_text;
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
