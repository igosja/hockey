<?php

use common\components\ErrorHelper;
use common\models\Country;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $countryDataProvider
 */

print $this->render('_top');

?>
<div class="row">
    <div class="row">
        <?php

        try {
            $columns = [
                [
                    'label' => 'Роль в игре',
                    'value' => function (Country $model): string {
                        return $model->country_name . (Yii::$app->user->id == $model->country_president_id ? ' (Президент федерации)' : ' (Заместитель президента федерации)');
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $countryDataProvider,
                'emptyText' => false,
                'showFooter' => true,
                'showOnEmpty' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>
