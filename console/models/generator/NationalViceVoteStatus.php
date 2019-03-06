<?php

namespace console\models\generator;

use common\models\ElectionNationalApplication;
use common\models\ElectionNationalVice;
use common\models\ElectionNationalViceApplication;
use common\models\ElectionStatus;
use common\models\History;
use common\models\HistoryText;
use common\models\National;
use yii\db\ActiveQuery;

/**
 * Class NationalViceVoteStatus
 * @package console\models\generator
 */
class NationalViceVoteStatus
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $electionNationalViceArray = ElectionNationalVice::find()
            ->with(['application'])
            ->where(['election_national_vice_election_status_id' => ElectionStatus::CANDIDATES])
            ->andWhere(['<', 'election_national_vice_date', time() - 172800])
            ->orderBy(['election_national_vice_id' => SORT_ASC])
            ->each();
        foreach ($electionNationalViceArray as $electionNationalVice) {
            /**
             * @var ElectionNationalVice $electionNationalVice
             */
            if (count($electionNationalVice->application)) {
                $this->toOpen($electionNationalVice);
            }
        }

        $electionNationalViceArray = ElectionNationalVice::find()
            ->with(['application'])
            ->where(['election_national_vice_election_status_id' => ElectionStatus::OPEN])
            ->andWhere(['<', 'election_national_vice_date', time() - 259200])
            ->orderBy(['election_national_vice_id' => SORT_ASC])
            ->each();
        foreach ($electionNationalViceArray as $electionNationalVice) {
            /**
             * @var ElectionNationalVice $electionNationalVice
             */
            $this->toClose($electionNationalVice);
        }
    }

    /**
     * @param ElectionNationalVice $electionNationalVice
     * @throws \Exception
     */
    private function toOpen(ElectionNationalVice $electionNationalVice)
    {
        $model = new ElectionNationalApplication();
        $model->election_national_application_election_id = $electionNationalVice->election_national_vice_id;
        $model->election_national_application_text = '-';
        $model->save();

        $electionNationalVice->election_national_vice_date = time();
        $electionNationalVice->election_national_vice_election_status_id = ElectionStatus::OPEN;
        $electionNationalVice->save(true, ['election_national_vice_date', 'election_national_vice_election_status_id']);
    }

    /**
     * @param ElectionNationalVice $electionNationalVice
     * @throws \Exception
     */
    private function toClose(ElectionNationalVice $electionNationalVice)
    {
        $electionNationalViceApplication = ElectionNationalViceApplication::find()
            ->alias('ena')
            ->joinWith([
                'electionNationalViceVote' => function (ActiveQuery $query) {
                    return $query
                        ->groupBy(['election_national_vice_vote_application_id']);
                },
                'user',
            ])
            ->select([
                'ena.*',
                'COUNT(election_national_vice_vote_application_id) AS election_national_vice_vote_vote'
            ])
            ->where(['election_national_vice_application_election_id' => $electionNationalVice->election_national_vice_id])
            ->andWhere(['!=', 'election_national_application_user_id', 0])
            ->andWhere([
                'not',
                ['election_national_vice_application_user_id' => National::find()->select(['national_user_id'])]
            ])
            ->andWhere([
                'not',
                ['election_national_vice_application_user_id' => National::find()->select(['national_vice_id'])]
            ])
            ->orderBy([
                'election_national_vice_vote_vote' => SORT_DESC,
                'user_rating' => SORT_DESC,
                'user_date_register' => SORT_ASC,
                'election_national_vice_application_id' => SORT_ASC,
            ])
            ->limit(1)
            ->one();
        if ($electionNationalViceApplication) {
            History::log([
                'history_history_text_id' => HistoryText::USER_VICE_NATIONAL_IN,
                'history_national_id' => $electionNationalVice->national->national_id,
                'history_user_id' => $electionNationalViceApplication->election_national_vice_application_user_id,
            ]);

            $electionNationalVice->national->national_vice_id = $electionNationalViceApplication->election_national_vice_application_user_id;
            $electionNationalVice->national->save(true, ['national_vice_id']);
        }

        $electionNationalVice->election_national_vice_election_status_id = ElectionStatus::CLOSE;
        $electionNationalVice->save(true, ['election_national_vice_election_status_id']);
    }
}
