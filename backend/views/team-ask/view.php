<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\TeamAsk;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var TeamAsk $model
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
        <?= Html::a('Одобрить', ['team-ask/update', 'id' => $model->team_ask_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            [
                'captionOptions' => ['class' => 'col-lg-6'],
                'label' => 'ID',
                'value' => function (TeamAsk $model) {
                    return $model->team_ask_id;
                },
            ],
            [
                'label' => 'Время заявки',
                'value' => function (TeamAsk $model) {
                    return FormatHelper::asDateTime($model->team_ask_date);
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Команда',
                'value' => function (TeamAsk $model) {
                    return $model->team->teamLink();
                },
            ],
            [
                'format' => 'raw',
                'label' => 'Менеджер',
                'value' => function (TeamAsk $model) {
                    return $model->user->userLink();
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
