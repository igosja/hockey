<?php

namespace console\models\generator;

use common\models\ElectionNational;
use common\models\ElectionNationalApplication;
use common\models\ElectionStatus;
use common\models\History;
use common\models\HistoryText;
use common\models\National;
use yii\db\ActiveQuery;

/**
 * Class NationalVoteStatus
 * @package console\models\generator
 */
class NationalVoteStatus
{
    /**
     * @throws \Exception
     */
    public function execute()
    {
        $electionNationalArray = ElectionNational::find()
            ->with(['application'])
            ->where(['election_national_election_status_id' => ElectionStatus::CANDIDATES])
            ->andWhere(['<', 'election_national_date', time() - 172800])
            ->orderBy(['election_national_id' => SORT_ASC])
            ->each();
        foreach ($electionNationalArray as $electionNational) {
            /**
             * @var ElectionNational $electionNational
             */
            if (count($electionNational->application)) {
                $this->toOpen($electionNational);
            }
        }

        $electionNationalArray = ElectionNational::find()
            ->with(['application'])
            ->where(['election_national_election_status_id' => ElectionStatus::OPEN])
            ->andWhere(['<', 'election_national_date', time() - 259200])
            ->orderBy(['election_national_id' => SORT_ASC])
            ->each();
        foreach ($electionNationalArray as $electionNational) {
            /**
             * @var ElectionNational $electionNational
             */
            $this->toClose($electionNational);
        }
    }

    /**
     * @param ElectionNational $electionNational
     * @throws \Exception
     */
    private function toOpen(ElectionNational $electionNational)
    {
        $model = new ElectionNationalApplication();
        $model->election_national_application_election_id = $electionNational->election_national_id;
        $model->election_national_application_text = '-';
        $model->save();

        $electionNational->election_national_date = time();
        $electionNational->election_national_election_status_id = ElectionStatus::OPEN;
        $electionNational->save(true, ['election_national_date', 'election_national_election_status_id']);
    }

    /**
     * @param ElectionNational $electionNational
     * @throws \Exception
     */
    private function toClose(ElectionNational $electionNational)
    {
        $electionNationalApplicationArray = ElectionNationalApplication::find()
            ->alias('ena')
            ->joinWith([
                'electionNationalVote' => function (ActiveQuery $query) {
                    return $query
                        ->groupBy(['election_national_vote_application_id']);
                },
                'user',
            ])
            ->select(['ena.*', 'COUNT(election_national_vote_application_id) AS election_national_vote_vote'])
            ->where(['election_national_application_election_id' => $electionNational->election_national_id])
            ->andWhere(['!=', 'election_national_application_user_id', 0])
            ->andWhere([
                'not',
                ['election_national_application_user_id' => National::find()->select(['national_user_id'])]
            ])
            ->andWhere([
                'not',
                ['election_national_application_user_id' => National::find()->select(['national_vice_id'])]
            ])
            ->orderBy([
                'election_national_vote_vote' => SORT_DESC,
                'user_rating' => SORT_DESC,
                'user_date_register' => SORT_ASC,
                'election_national_application_id' => SORT_ASC,
            ])
            ->limit(2)
            ->all();
        if ($electionNationalApplicationArray) {
            if ($electionNationalApplicationArray[0]->election_national_application_user_id) {
                History::log([
                    'history_history_text_id' => HistoryText::USER_MANAGER_NATIONAL_IN,
                    'history_national_id' => $electionNational->national->national_id,
                    'history_user_id' => $electionNationalApplicationArray[0]->election_national_application_user_id,
                ]);

                if (isset($electionNationalApplicationArray[1])) {
                    History::log([
                        'history_history_text_id' => HistoryText::USER_VICE_NATIONAL_IN,
                        'history_national_id' => $electionNational->national->national_id,
                        'history_user_id' => $electionNationalApplicationArray[1]->election_national_application_user_id,
                    ]);
                }

                $electionNational->national->national_user_id = $electionNationalApplicationArray[0]->election_national_application_user_id;
                $electionNational->national->national_vice_id = isset($electionNationalApplicationArray[1]->election_national_application_user_id) ? $electionNationalApplicationArray[1]->election_national_application_user_id : 0;
                $electionNational->national->save(true, ['national_user_id', 'national_vice_id']);

                foreach ($electionNationalApplicationArray[0]->electionNationalPlayer as $electionNationalPlayer) {
                    $electionNationalPlayer->player->player_national_id = $electionNational->national->national_id;
                    $electionNationalPlayer->player->save(true, ['player_national_id']);
                }
            }
        }

        $electionNational->election_national_election_status_id = ElectionStatus::CLOSE;
        $electionNational->save(true, ['election_national_election_status_id']);
    }
}
