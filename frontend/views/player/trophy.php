<?php

use common\components\ErrorHelper;
use common\models\AchievementPlayer;
use common\models\Player;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;

/**
 * @var ActiveDataProvider $dataProvider
 * @var Player $player
 * @var View $this
 */

print $this->render('//player/_player', ['player' => $player]);

?>
    <div class="row margin-top-small">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?= $this->render('//player/_links'); ?>
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
                    'value' => function (AchievementPlayer $model) {
                        return $model->achievement_player_season_id;
                    }
                ],
                [
                    'footer' => 'Команда',
                    'format' => 'raw',
                    'label' => 'Команда',
                    'value' => function (AchievementPlayer $model) {
                        return $model->achievement_player_team_id ? $model->team->teamLink() : $model->national->nationalLink();
                    }
                ],
                [
                    'footer' => 'Турнир',
                    'label' => 'Турнир',
                    'value' => function (AchievementPlayer $model) {
                        return $model->getTournament();
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Позиция',
                    'headerOptions' => ['class' => 'col-10'],
                    'label' => 'Позиция',
                    'value' => function (AchievementPlayer $model) {
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
            <?= $this->render('//player/_links'); ?>
        </div>
    </div>
<?= $this->render('//site/_show-full-table'); ?>