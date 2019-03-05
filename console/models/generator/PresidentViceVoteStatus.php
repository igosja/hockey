<?php

namespace console\models\generator;

use common\models\Country;
use common\models\ElectionPresidentVice;
use common\models\ElectionPresidentViceApplication;
use common\models\ElectionStatus;
use common\models\History;
use common\models\HistoryText;
use yii\db\ActiveQuery;

/**
 * Class PresidentViceVoteStatus
 * @package console\models\generator
 */
class PresidentViceVoteStatus
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $electionPresidentViceArray = ElectionPresidentVice::find()
            ->with(['application'])
            ->where(['election_president_vice_election_status_id' => ElectionStatus::CANDIDATES])
            ->andWhere(['<', 'election_president_vice_date', time() - 172800])
            ->orderBy(['election_president_vice_id' => SORT_ASC])
            ->each();
        foreach ($electionPresidentViceArray as $electionPresidentVice) {
            /**
             * @var ElectionPresidentVice $electionPresidentVice
             */
            if (count($electionPresidentVice->application)) {
                $this->toOpen($electionPresidentVice);
            }
        }

        $electionPresidentViceArray = ElectionPresidentVice::find()
            ->with(['application'])
            ->where(['election_president_vice_election_status_id' => ElectionStatus::OPEN])
            ->andWhere(['<', 'election_president_vice_date', time() - 259200])
            ->orderBy(['election_president_vice_id' => SORT_ASC])
            ->each();
        foreach ($electionPresidentViceArray as $electionPresidentVice) {
            /**
             * @var ElectionPresidentVice $electionPresidentVice
             */
            $this->toClose($electionPresidentVice);
        }
    }

    /**
     * @param ElectionPresidentVice $electionPresidentVice
     * @throws \Exception
     */
    private function toOpen(ElectionPresidentVice $electionPresidentVice)
    {
        $model = new ElectionPresidentViceApplication();
        $model->election_president_vice_application_election_id = $electionPresidentVice->election_president_vice_id;
        $model->election_president_vice_application_text = '-';
        $model->save();

        $electionPresidentVice->election_president_vice_date = time();
        $electionPresidentVice->election_president_vice_election_status_id = ElectionStatus::OPEN;
        $electionPresidentVice->save(true, ['election_president_vice_date', 'election_president_vice_election_status_id']);
    }

    /**
     * @param ElectionPresidentVice $electionPresidentVice
     * @throws \Exception
     */
    private function toClose(ElectionPresidentVice $electionPresidentVice)
    {
        $electionPresidentViceApplication = ElectionPresidentViceApplication::find()
            ->alias('epa')
            ->joinWith([
                'electionPresidentViceVote' => function (ActiveQuery $query) {
                    return $query
                        ->groupBy(['election_president_vice_vote_application_id']);
                },
                'user',
            ])
            ->select([
                'epa.*',
                'COUNT(election_president_vice_vote_application_id) AS election_president_vice_vote_vote'
            ])
            ->where(['election_president_vice_application_election_id' => $electionPresidentVice->election_president_vice_id])
            ->andWhere(['!=', 'election_president_vice_application_user_id', 0])
            ->andWhere([
                'not',
                ['election_president_vice_application_user_id' => Country::find()->select(['country_president_id'])]
            ])
            ->andWhere([
                'not',
                ['election_president_vice_application_user_id' => Country::find()->select(['country_president_vice_id'])]
            ])
            ->orderBy([
                'election_president_vice_vote_vote' => SORT_DESC,
                'user_rating' => SORT_DESC,
                'user_date_register' => SORT_ASC,
                'election_president_vice_application_id' => SORT_ASC,
            ])
            ->limit(1)
            ->one();
        if ($electionPresidentViceApplication) {
            History::log([
                'history_country_id' => $electionPresidentVice->election_president_vice_country_id,
                'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_IN,
                'history_user_id' => $electionPresidentViceApplication->election_president_vice_application_user_id,
            ]);

            $electionPresidentVice->country->country_president_vice_id = $electionPresidentViceApplication->election_president_vice_application_user_id;
            $electionPresidentVice->country->save(true, ['country_president_vice_id']);
        }

        $electionPresidentVice->election_president_vice_election_status_id = ElectionStatus::CLOSE;
        $electionPresidentVice->save(true, ['election_president_vice_election_status_id']);
    }
}
