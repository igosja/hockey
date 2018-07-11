<?php

use common\components\ErrorHelper;
use common\widgets\DetailView;
use yii\helpers\Html;

/**
 * @var \common\models\News $model
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
        <?= Html::a('List', ['index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Update', ['update', 'id' => $model->news_id], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Delete', ['delete', 'id' => $model->news_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'news_id',
            'news_date:date',
            'news_title',
            'news_text',
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
