<?php

namespace frontend\controllers;

use common\models\Game;
use common\models\Special;
use common\models\TournamentType;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Class VisitorNationalController
 * @package frontend\controllers
 */
class VisitorNationalController extends AbstractController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        if (!$this->myNationalOrVice) {
            return $this->redirect(['team/view']);
        }

        $game = $this->getGame($id);

        $special = 0;
        foreach ($game->lineup as $lineup) {
            if (!$lineup->player) {
                continue;
            }
            foreach ($lineup->player->playerSpecial as $playerSpecial) {
                if (Special::IDOL == $playerSpecial->player_special_special_id) {
                    $special = $special + $playerSpecial->player_special_level;
                }
            }
        }
        $guestVisitor = $game->nationalGuest->national_visitor;
        $homeVisitor = $game->nationalHome->national_visitor;
        $stadiumCapacity = $game->nationalHome->stadium->stadium_capacity;
        $stageVisitor = $game->schedule->stage->stage_visitor;
        $tournamentTypeId = $game->schedule->schedule_tournament_type_id;
        $tournamentTypeVisitor = $game->schedule->tournamentType->tournament_type_visitor;

        $gameVisitor = $stadiumCapacity;
        $gameVisitor = $gameVisitor * $tournamentTypeVisitor;
        $gameVisitor = $gameVisitor * $stageVisitor;

        $visitor_array = [];

        for ($i = 10; $i <= 50; $i++) {
            $visitor = $gameVisitor / pow(($i - Game::TICKET_PRICE_BASE) / 10, 1.1);

            if (in_array($tournamentTypeId, [TournamentType::FRIENDLY, TournamentType::NATIONAL])) {
                $visitor = $visitor * ($homeVisitor + $guestVisitor) / 2;
            } else {
                $visitor = $visitor * ($homeVisitor * 2 + $guestVisitor) / 3;
            }

            $visitor = $visitor * (100 + $special * 5);
            $visitor = $visitor / 100000000;
            $visitor = round($visitor);

            if ($visitor > $stadiumCapacity) {
                $visitor = $stadiumCapacity;
            }

            $visitor_array['visitor'][$i] = $visitor;
            $visitor_array['income'][$i] = $visitor * $i;
        }

        $x_data = array_keys($visitor_array['visitor']);
        $s_data_visitor = array_values($visitor_array['visitor']);
        $s_data_income = array_values($visitor_array['income']);

        $this->setSeoTitle('Прогноз посещаемости');

        return $this->render('view', [
            'game' => $game,
            'sDataIncome' => $s_data_income,
            'sDataVisitor' => $s_data_visitor,
            'special' => $special,
            'xData' => $x_data,
        ]);
    }

    /**
     * @param int $id
     * @return Game
     * @throws NotFoundHttpException
     */
    public function getGame($id)
    {
        $game = Game::find()
            ->where(['game_id' => $id, 'game_played' => 0])
            ->andWhere([
                'or',
                ['game_guest_national_id' => $this->myNationalOrVice->national_id],
                ['game_home_national_id' => $this->myNationalOrVice->national_id]
            ])
            ->limit(1)
            ->one();
        $this->notFound($game);

        return $game;
    }
}
