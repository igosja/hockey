<?php

namespace frontend\controllers;

use common\models\National;
use common\models\Player;
use yii\data\ActiveDataProvider;
use yii\web\Response;

/**
 * Class NationalController
 * @package frontend\controllers
 */
class NationalController extends AbstractController
{
    /**
     * @param $id
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $national = $this->getNational($id);

        $query = Player::find()
            ->with([
                'country',
                'name',
                'physical',
                'playerPosition.position',
                'playerSpecial.special',
                'statisticPlayer',
                'style',
                'surname',
            ])
            ->where(['player_national_id' => $id]);
        $dataProvider = new ActiveDataProvider([
            'pagination' => false,
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'age' => [
                        'asc' => ['player_age' => SORT_ASC],
                        'desc' => ['player_age' => SORT_DESC],
                    ],
                    'game_row' => [
                        'asc' => ['player_game_row' => SORT_ASC],
                        'desc' => ['player_game_row' => SORT_DESC],
                    ],
                    'position' => [
                        'asc' => ['player_position_id' => SORT_ASC, 'player_id' => SORT_ASC],
                        'desc' => ['player_position_id' => SORT_DESC, 'player_id' => SORT_DESC],
                    ],
                    'physical' => [
                        'asc' => [$national->myTeam() ? 'player_physical_id' : 'player_position_id' => SORT_ASC],
                        'desc' => [$national->myTeam() ? 'player_physical_id' : 'player_position_id' => SORT_DESC],
                    ],
                    'power_nominal' => [
                        'asc' => ['player_power_nominal' => SORT_ASC],
                        'desc' => ['player_power_nominal' => SORT_DESC],
                    ],
                    'power_real' => [
                        'asc' => [$national->myTeam() ? 'player_power_real' : 'player_power_nominal' => SORT_ASC],
                        'desc' => [$national->myTeam() ? 'player_power_real' : 'player_power_nominal' => SORT_DESC],
                    ],
                    'price' => [
                        'asc' => ['player_price' => SORT_ASC],
                        'desc' => ['player_price' => SORT_DESC],
                    ],
                    'squad' => [
                        'asc' => ['player_squad_id' => SORT_ASC, 'player_position_id' => SORT_ASC],
                        'desc' => ['player_squad_id' => SORT_DESC, 'player_position_id' => SORT_ASC],
                    ],
                    'style' => [
                        'asc' => ['player_style_id' => SORT_ASC],
                        'desc' => ['player_style_id' => SORT_DESC],
                    ],
                    'tire' => [
                        'asc' => [$national->myTeam() ? 'player_tire' : 'player_position_id' => SORT_ASC],
                        'desc' => [$national->myTeam() ? 'player_tire' : 'player_position_id' => SORT_DESC],
                    ],
                ],
                'defaultOrder' => ['position' => SORT_ASC],
            ],
        ]);

        $this->setSeoTitle($national->fullName() . '. Профиль сборной');

        return $this->render('view', [
            'dataProvider' => $dataProvider,
            'national' => $national,
        ]);
    }

    /**
     * @param int $id
     * @return National
     * @throws \yii\web\NotFoundHttpException
     */
    public function getNational($id)
    {
        $national = National::find()
            ->where(['national_id' => $id])
            ->limit(1)
            ->one();
        $this->notFound($national);

        return $national;
    }
}
