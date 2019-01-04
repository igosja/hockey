<?php

use common\components\ErrorHelper;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 */

print $this->render('//user/_top');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'row'],
                'itemView' => '_user',
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>