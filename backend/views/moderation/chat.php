<?php

use common\components\ErrorHelper;
use common\components\HockeyHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var array $model
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
        <?= Html::a(
            'Одобрить',
            ['moderation/chat-ok', 'id' => $model['date']],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
    <li>
        <?= Html::a(
            'Удалить',
            ['moderation/chat-delete', 'id' => $model['date']],
            ['class' => 'btn btn-default']
        ); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'format' => 'raw',
                'label' => 'Автор',
                'value' => function ($model) {
                    return Html::a(
                        strip_tags($model['userLink']),
                        ['user/view', 'id' => $model['userId']]
                    );
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
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= HockeyHelper::bbDecode($model['text']); ?>
    </div>
</div>
