<?php

use common\components\ErrorHelper;
use common\models\AchievementPlayer;
use yii\grid\GridView;

/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \common\models\Player $player
 * @var \yii\web\View $this
 */

print $this->render('_player', ['player' => $player]);

?>
    <div class="row margin-top-small">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('_links'); ?>
        </div>
    </div>
    <div class="row">
        <?php

        try {
            $columns = [
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['title' => 'Сезон'],
                    'headerOptions' => ['class' => 'col-5', 'title' => 'Сезон'],
                    'label' => 'С',
                    'value' => function (AchievementPlayer $model): string {
                        return $model->achievement_player_season_id;
                    }
                ],
                [
                    'footer' => 'Команда',
                    'format' => 'raw',
                    'label' => 'Команда',
                    'value' => function (AchievementPlayer $model): string {
                        return $model->team->teamLink();
                    }
                ],
                [
                    'footer' => 'Турнир',
                    'label' => 'Турнир',
                    'value' => function (AchievementPlayer $model): string {
                        return $model->tournamentType->tournament_type_name;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Позиция',
                    'headerOptions' => ['class' => 'col-10'],
                    'label' => 'Позиция',
                    'value' => function (AchievementPlayer $model): string {
                        return $model->getPosition();
                    }
                ],
            ];
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $dataProvider,
                'showFooter' => true,
                'summary' => false,
            ]);
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('_links'); ?>
        </div>
    </div>
<?= $this->render('/site/_show-full-table'); ?>