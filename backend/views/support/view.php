<?php

use coderlex\wysibb\WysiBB;
use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\components\HockeyHelper;
use common\models\Support;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var Support $model
 * @var \yii\web\View $this
 * @var \common\models\User $user
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($user->user_login); ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <?= Html::a('Список', ['support/index'], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'format' => 'raw',
                'value' => function (Support $model) {
                    $result = FormatHelper::asDateTime($model->support_date);
                    if ($model->support_question) {
                        $result = $result . ' ' . $model->user->userLink();
                    } else {
                        $result = $result . ' ' . $model->admin->userLink();
                    }
                    $result = $result . '<br/>' . HockeyHelper::bbDecode($model->support_text);
                    return $result;
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'showHeader' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'support_text')->widget(WysiBB::class)->label(false); ?>
        <div class="form-group">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Ответить', ['class' => 'btn btn-default']); ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>