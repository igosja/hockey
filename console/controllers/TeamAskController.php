<?php

namespace console\controllers;

use common\components\ErrorHelper;
use common\models\History;
use common\models\HistoryText;
use common\models\Team;
use common\models\TeamAsk;
use Exception;
use Yii;
use yii\db\Expression;
use yii\db\Query;

/**
 * Class TeamAskController
 * @package console\controllers
 */
class TeamAskController extends AbstractController
{
    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function actionIndex()
    {
        $expression = new Expression('UNIX_TIMESTAMP()-CEIL(IFNULL(`count_history`, 0)/5)-IFNULL(`count_history`, 0)*3600');
        $teamAsk = (new Query())
            ->from(TeamAsk::tableName())
            ->leftJoin(
                [
                    't1' => '(' . (new Query())
                            ->select(['count_history' => 'COUNT(history_id)', 'history_user_id'])
                            ->from(History::tableName())
                            ->where(['history_history_text_id' => HistoryText::USER_MANAGER_TEAM_IN])
                            ->andWhere(['history_user_id' => TeamAsk::find()->select(['team_ask_user_id'])])
                            ->groupBy(['history_user_id'])
                            ->createCommand()
                            ->rawSql . ')'
                ],
                'team_ask_user_id=history_user_id'
            )
            ->where(['<', 'team_ask_date', $expression])
            ->orderBy(['IFNULL(`count_history`, 0)' => SORT_ASC, 'team_ask_date' => SORT_ASC])
            ->limit(1)
            ->one();

        if (!$teamAsk) {
            return false;
        }

        $teamToEmploy = Team::find()
            ->where(['team_id' => $teamAsk['team_ask_team_id'], 'team_user_id' => 0])
            ->limit(1)
            ->one();
        if (!$teamToEmploy) {
            TeamAsk::deleteAll(['team_ask_id' => $teamAsk['team_ask_id']]);
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($teamAsk['team_ask_leave_id']) {
                $teamToFire = Team::find()
                    ->where(['team_id' => $teamAsk['team_ask_leave_id']])
                    ->limit(1)
                    ->one();
                if ($teamToFire) {
                    $teamToFire->managerFire();
                }
            }

            $teamToEmploy->managerEmploy($teamAsk['team_ask_user_id']);

            TeamAsk::deleteAll(['team_ask_team_id' => $teamAsk['team_ask_team_id']]);
            TeamAsk::deleteAll(['team_ask_user_id' => $teamAsk['team_ask_user_id']]);
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);

            return false;
        }

        $transaction->commit();

        return true;
    }
}
