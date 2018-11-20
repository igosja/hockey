<?php

use common\components\ErrorHelper;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Опросы</h1>
    </div>
</div>
<div class="row">
    <?php

    try {
        print ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_poll',
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
