<?php

use common\components\ErrorHelper;
use yii\widgets\ListView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\ForumTheme $forumTheme
 * @var \common\models\User $user
 * @var \yii\web\View $this
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>Результаты поиска</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <?= $this->render('/forum/_searchForm'); ?>
            </div>
        </div>
        <?php

        try {
            print ListView::widget([
                'dataProvider' => $dataProvider,
                'itemOptions' => ['class' => 'row forum-row forum-striped'],
                'itemView' => '_search',
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>
