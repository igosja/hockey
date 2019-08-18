<?php

use common\components\ErrorHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var \common\models\TournamentType $model
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
        <?= Html::a('Список', ['tournament-type/index'], ['class' => 'btn btn-default']); ?>
    </li>
    <li>
        <?= Html::a('Изменить', ['tournament-type/update', 'id' => $model->stage_id], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<div class="row">
    <?php

    try {
        $attributes = [
            'tournament_type_id',
            'tournament_type_name',
            'tournament_type_visitor',
            'tournament_type_day_type_id',
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
