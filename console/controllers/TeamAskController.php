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
 * Class BaseController
 * @package console\controllers
 */
class TeamAskController extends BaseController
{
    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function actionIndex(): bool
    {
        $expression = new Expression('UNIX_TIMESTAMP()-CEIL(IFNULL(`count_history`, 0)/5)-IFNULL(`count_history`, 0)*3600');
        $teamAsk = (new Query())
            ->select(['team_ask_id', 'team_ask_leave_id', 'team_ask_team_id', 'team_ask_user_id'])
            ->from(TeamAsk::tableName())
            ->leftJoin(
                [
                    't1' => '(' . (new Query())
                            ->select(['count_history' => 'COUNT(history_id)', 'history_user_id'])
                            ->from(History::tableName())
                            ->where(['history_history_text_id' => HistoryText::USER_MANAGER_TEAM_IN])
                            ->andWhere(['history_user_id' => TeamAsk::find()->select(['team_ask_user_id'])->column()])
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

        if (!Team::find()->where(['team_id' => $teamAsk['team_ask_team_id'], 'team_user_id' => 0])->count()) {
            TeamAsk::deleteAll(['team_ask_id' => $teamAsk['team_ask_id']]);
            return false;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if ($teamAsk['team_ask_leave_id']) {
                Team::findOne($teamAsk['team_ask_leave_id'])->managerFire();
            }

            Team::findOne($teamAsk['team_ask_team_id'])->managerEmploy($teamAsk['team_ask_user_id']);

            TeamAsk::deleteAll(['team_ask_team_id' => $teamAsk['team_ask_team_id']]);
            TeamAsk::deleteAll(['team_ask_user_id' => $teamAsk['team_ask_user_id']]);
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            ErrorHelper::log($e);

            return false;
        }

        return true;
    }
}
