<?php

use backend\models\UserSearch;
use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Support;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var UserSearch $searchModel
 * @var View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= Html::encode($this->title); ?></h3>
    </div>
</div>
<div class="row">
    <?php

    try {
        $columns = [
            [
                'format' => 'raw',
                'label' => 'Время сообщения',
                'value' => function (Support $model) {
                    $result = FormatHelper::asDateTime($model->support_date);
                    if (!$model->support_read) {
                        $result = $result . ' <i class="fa fa-clock-o fa-fw"></i>';
                    }
                    return $result;
                }
            ],
            [
                'format' => 'raw',
                'label' => 'Пользователь',
                'value' => function (Support $model) {
                    if ($model->support_user_id) {
                        $result = $model->user->userLink();
                    } else {
                        $result = $model->president->userLink() . ' (през)';
                    }
                    return $result;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view}',
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>