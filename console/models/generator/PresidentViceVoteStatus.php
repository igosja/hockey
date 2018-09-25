<?php

namespace console\models\generator;

use common\models\Country;
use common\models\ElectionPresidentApplication;
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
     * @return void
     */
    public function execute(): void
    {
        $electionPresidentViceArray = ElectionPresidentVice::find()
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
            ->where(['election_president_vice_election_status_id' => ElectionStatus::OPEN])
            ->andWhere(['<', 'election_president_vice_date', time() - 432000])
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
     * @return void
     */
    private function toOpen(ElectionPresidentVice $electionPresidentVice): void
    {
        $model = new ElectionPresidentApplication();
        $model->election_president_application_election_id = $electionPresidentVice->election_president_vice_id;
        $model->save();

        $electionPresidentVice->election_president_vice_election_status_id = ElectionStatus::OPEN;
        $electionPresidentVice->save();
    }

    /**
     * @param ElectionPresidentVice $electionPresidentVice
     * @return void
     */
    private function toClose(ElectionPresidentVice $electionPresidentVice): void
    {
        $electionPresidentViceApplication = ElectionPresidentViceApplication::find()
            ->joinWith([
                'electionPresidentViceVote' => function (ActiveQuery $query): ActiveQuery {
                    return $query
                        ->select([
                            'election_president_vice_vote_application_id',
                            'SUM(election_president_vice_vote_vote) AS election_president_vice_vote_vote',
                        ])
                        ->groupBy(['election_president_vice_vote_application_id']);
                },
                'user',
            ])
            ->where(['election_president_vice_application_election_id' => $electionPresidentVice->election_president_vice_id])
            ->andWhere(['!=', 'election_president_application_user_id', 0])
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
            $electionPresidentVice->country->save();
        }

        $electionPresidentVice->election_president_vice_election_status_id = ElectionStatus::CLOSE;
        $electionPresidentVice->save();
    }
}
