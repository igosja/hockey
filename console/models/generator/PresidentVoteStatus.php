<?php

namespace console\models\generator;

use common\models\Country;
use common\models\ElectionPresident;
use common\models\ElectionPresidentApplication;
use common\models\ElectionStatus;
use common\models\History;
use common\models\HistoryText;
use yii\db\ActiveQuery;

/**
 * Class PresidentVoteStatus
 * @package console\models\generator
 */
class PresidentVoteStatus
{
    /**
     * @throws \Exception
     * @return void
     */
    public function execute(): void
    {
        $electionPresidentArray = ElectionPresident::find()
            ->with(['application'])
            ->where(['election_president_election_status_id' => ElectionStatus::CANDIDATES])
            ->andWhere(['<', 'election_president_date', time() - 172800])
            ->orderBy(['election_president_id' => SORT_ASC])
            ->each();
        foreach ($electionPresidentArray as $electionPresident) {
            /**
             * @var ElectionPresident $electionPresident
             */
            if (count($electionPresident->application)) {
                $this->toOpen($electionPresident);
            }
        }

        $electionPresidentArray = ElectionPresident::find()
            ->with(['application'])
            ->where(['election_president_election_status_id' => ElectionStatus::OPEN])
            ->andWhere(['<', 'election_president_date', time() - 432000])
            ->orderBy(['election_president_id' => SORT_ASC])
            ->each();
        foreach ($electionPresidentArray as $electionPresident) {
            /**
             * @var ElectionPresident $electionPresident
             */
            $this->toClose($electionPresident);
        }
    }

    /**
     * @param ElectionPresident $electionPresident
     * @throws \Exception
     * @return void
     */
    private function toOpen(ElectionPresident $electionPresident): void
    {
        $model = new ElectionPresidentApplication();
        $model->election_president_application_election_id = $electionPresident->election_president_id;
        $model->election_president_application_text = '-';
        $model->save();

        $electionPresident->election_president_election_status_id = ElectionStatus::OPEN;
        $electionPresident->save(true, ['election_president_election_status_id']);
    }

    /**
     * @param ElectionPresident $electionPresident
     * @throws \Exception
     * @return void
     */
    private function toClose(ElectionPresident $electionPresident): void
    {
        $electionPresidentApplicationArray = ElectionPresidentApplication::find()
            ->joinWith([
                'electionPresidentVote' => function (ActiveQuery $query): ActiveQuery {
                    return $query
                        ->select([
                            'election_president_vote_application_id',
                            'COUNT(election_president_vote_application_id) AS election_president_vote_vote',
                        ])
                        ->groupBy(['election_president_vote_application_id']);
                },
                'user',
            ])
            ->where(['election_president_application_election_id' => $electionPresident->election_president_id])
            ->andWhere(['!=', 'election_president_application_user_id', 0])
            ->andWhere([
                'not',
                ['election_president_application_user_id' => Country::find()->select(['country_president_id'])]
            ])
            ->andWhere([
                'not',
                ['election_president_application_user_id' => Country::find()->select(['country_president_vice_id'])]
            ])
            ->orderBy([
                'election_president_vote_vote' => SORT_DESC,
                'user_rating' => SORT_DESC,
                'user_date_register' => SORT_ASC,
                'election_president_application_id' => SORT_ASC,
            ])
            ->limit(2)
            ->all();
        if ($electionPresidentApplicationArray) {
            if ($electionPresidentApplicationArray[0]->election_president_application_user_id) {
                History::log([
                    'history_history_text_id' => HistoryText::USER_PRESIDENT_IN,
                    'history_country_id' => $electionPresident->election_president_country_id,
                    'history_user_id' => $electionPresidentApplicationArray[0]->election_president_application_user_id,
                ]);

                if (isset($electionPresidentApplicationArray[1])) {
                    History::log([
                        'history_country_id' => $electionPresident->election_president_country_id,
                        'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_IN,
                        'history_user_id' => $electionPresidentApplicationArray[1]->election_president_application_user_id,
                    ]);
                }

                $electionPresident->country->country_president_id = $electionPresidentApplicationArray[0]->election_president_application_user_id;
                $electionPresident->country->country_president_vice_id = $electionPresidentApplicationArray[1]->election_president_application_user_id ?? 0;
                $electionPresident->country->save();
            }
        }

        $electionPresident->election_president_election_status_id = ElectionStatus::CLOSE;
        $electionPresident->save(true, ['election_president_election_status_id']);
    }
}
