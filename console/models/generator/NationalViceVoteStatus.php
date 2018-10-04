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
     * @return void
     */
    public function execute(): void
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
            ->andWhere(['<', 'election_national_vice_date', time() - 432000])
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
     * @return void
     */
    private function toOpen(ElectionNationalVice $electionNationalVice): void
    {
        $model = new ElectionNationalApplication();
        $model->election_national_application_election_id = $electionNationalVice->election_national_vice_id;
        $model->save();

        $electionNationalVice->election_national_vice_election_status_id = ElectionStatus::OPEN;
        $electionNationalVice->save();
    }

    /**
     * @param ElectionNationalVice $electionNationalVice
     * @return void
     */
    private function toClose(ElectionNationalVice $electionNationalVice): void
    {
        $electionNationalViceApplication = ElectionNationalViceApplication::find()
            ->joinWith([
                'electionNationalViceVote' => function (ActiveQuery $query): ActiveQuery {
                    return $query
                        ->select([
                            'election_national_vice_vote_application_id',
                            'COUNT(election_national_vice_vote_application_id) AS election_national_vice_vote_vote',
                        ])
                        ->groupBy(['election_national_vice_vote_application_id']);
                },
                'user',
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
                'history_national_id' => $electionNationalVice->election_national_vice_id,
                'history_user_id' => $electionNationalViceApplication->election_national_vice_application_user_id,
            ]);

            $electionNationalVice->national->national_vice_id = $electionNationalViceApplication->election_national_vice_application_user_id;
            $electionNationalVice->national->save();
        }

        $electionNationalVice->election_national_vice_election_status_id = ElectionStatus::CLOSE;
        $electionNationalVice->save();
    }
}
