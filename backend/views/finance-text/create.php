<?php

use common\models\FinanceText;
use yii\helpers\Html;
use yii\web\View;

/**
 * @var FinanceText $model
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
        <?= Html::a('Список', ['finance-text/index'], ['class' => 'btn btn-default']); ?>
    </li>
</ul>
<?= $this->render('_form', ['model' => $model]); ?>

