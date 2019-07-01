<?php

namespace console\models\generator;

use common\models\Country;
use common\models\ElectionPresident;
use common\models\ElectionPresidentApplication;
use common\models\ElectionPresidentViceApplication;
use common\models\ElectionStatus;
use common\models\History;
use common\models\HistoryText;
use Exception;
use yii\db\ActiveQuery;

/**
 * Class PresidentVoteStatus
 * @package console\models\generator
 */
class PresidentVoteStatus
{
    /**
     * @return void
     *@throws Exception
     */
    public function execute()
    {
        $electionPresidentArray = ElectionPresident::find()
            ->with(['application'])
            ->where(['election_president_election_status_id' => ElectionStatus::CANDIDATES])
            ->andWhere(['<', 'election_president_date', time() - 129600])
            ->orderBy(['election_president_id' => SORT_ASC])
            ->each(5);
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
            ->andWhere(['<', 'election_president_date', time() - 216000])
            ->orderBy(['election_president_id' => SORT_ASC])
            ->each(5);
        foreach ($electionPresidentArray as $electionPresident) {
            /**
             * @var ElectionPresident $electionPresident
             */
            $this->toClose($electionPresident);
        }
    }

    /**
     * @param ElectionPresident $electionPresident
     * @return void
     *@throws Exception
     */
    private function toOpen(ElectionPresident $electionPresident)
    {
        $model = new ElectionPresidentViceApplication();
        $model->election_president_vice_application_election_id = $electionPresident->election_president_id;
        $model->election_president_vice_application_text = '-';
        $model->save();

        $electionPresident->election_president_election_status_id = ElectionStatus::OPEN;
        $electionPresident->election_president_date = time();
        $electionPresident->save(true, ['election_president_election_status_id', 'election_president_date']);
    }

    /**
     * @param ElectionPresident $electionPresident
     * @return void
     *@throws Exception
     */
    private function toClose(ElectionPresident $electionPresident)
    {
        $electionPresidentApplicationArray = ElectionPresidentApplication::find()
            ->alias('epa')
            ->joinWith([
                'electionPresidentVote' => function (ActiveQuery $query) {
                    return $query
                        ->groupBy(['election_president_vote_application_id']);
                },
                'user',
            ])
            ->select(['epa.*', 'COUNT(election_president_vote_application_id) AS election_president_vote_vote'])
            ->where(['election_president_application_election_id' => $electionPresident->election_president_id])
            ->andWhere(['!=', 'election_president_application_user_id', 0])
            ->andWhere([
                'not',
                ['election_president_application_user_id' => Country::find()->select(['country_president_id'])]
            ])
            ->orderBy([
                'election_president_vote_vote' => SORT_DESC,
                'user_rating' => SORT_DESC,
                'user_date_register' => SORT_ASC,
                'election_president_application_id' => SORT_ASC,
            ])
            ->all();
        if ($electionPresidentApplicationArray) {
            if ($electionPresidentApplicationArray[0]->election_president_application_user_id) {
                $countryViceArray = Country::find()
                    ->where(['country_president_vice_id' => $electionPresidentApplicationArray[0]->election_president_application_user_id])
                    ->all();
                foreach ($countryViceArray as $countryVice) {
                    History::log([
                        'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_OUT,
                        'history_country_id' => $countryVice->country_id,
                        'history_user_id' => $electionPresidentApplicationArray[0]->election_president_application_user_id,
                    ]);

                    $countryVice->country_president_vice_id = 0;
                    $countryVice->save(true, ['country_president_vice_id']);
                }

                History::log([
                    'history_history_text_id' => HistoryText::USER_PRESIDENT_IN,
                    'history_country_id' => $electionPresident->election_president_country_id,
                    'history_user_id' => $electionPresidentApplicationArray[0]->election_president_application_user_id,
                ]);

                if (isset($electionPresidentApplicationArray[1])) {
                    $check = Country::find()
                        ->where(['country_president_vice_id' => $electionPresidentApplicationArray[1]->election_president_application_user_id])
                        ->count();
                    if (!$check) {
                        History::log([
                            'history_country_id' => $electionPresident->election_president_country_id,
                            'history_history_text_id' => HistoryText::USER_VICE_PRESIDENT_IN,
                            'history_user_id' => $electionPresidentApplicationArray[1]->election_president_application_user_id,
                        ]);
                    }
                }

                $electionPresident->country->country_president_id = $electionPresidentApplicationArray[0]->election_president_application_user_id;
                $electionPresident->country->country_president_vice_id = isset($electionPresidentApplicationArray[1]->election_president_application_user_id) ? $electionPresidentApplicationArray[1]->election_president_application_user_id : 0;
                $electionPresident->country->save(true, ['country_president_id', 'country_president_vice_id']);
            }
        }

        $electionPresident->election_president_election_status_id = ElectionStatus::CLOSE;
        $electionPresident->save(true, ['election_president_election_status_id']);
    }
}
