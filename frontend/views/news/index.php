<?php

use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>News</h1>
        </div>
    </div>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
]); ?>