<?php

use common\components\ErrorHelper;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;

/**
 * @var ActiveDataProvider $dataProvider
 * @var View $this
 */

print $this->render('_country');

?>
<div class="row">
    <?php

    try {
        print ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => function ($model, $key, $index) {
                unset($model, $key);
                $class = ['row', 'border-top'];
                if ($index % 2) {
                    $class[] = 'div-odd';
                }
                return ['class' => $class];
            },
            'itemView' => '_news',
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>