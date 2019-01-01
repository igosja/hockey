<?php

use common\components\ErrorHelper;
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
                'label' => 'Название',
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
