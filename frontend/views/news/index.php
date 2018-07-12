<?php

use common\components\ErrorHelper;
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
<?php

try {
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
    ]);
} catch (Exception $e) {
    ErrorHelper::log($e);
}

?>