<?php

namespace frontend\controllers;

use common\models\RatingChapter;
use common\models\RatingCountry;
use common\models\RatingTeam;
use common\models\RatingType;
use common\models\RatingUser;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * Class RatingController
 * @package frontend\controllers
 */
class RatingController extends AbstractController
{
    /**
     * @param int $id
     * @return string
     */
    public function actionIndex($id = RatingType::TEAM_POWER)
    {
        $countryId = Yii::$app->request->get('countryId');
        $countryArray = [];

        $ratingType = RatingType::find()
            ->where(['rating_type_id' => $id])
            ->limit(1)
            ->one();
        if (!$ratingType) {
            $ratingType = RatingType::find()
                ->where(['rating_type_id' => RatingType::TEAM_POWER])
                ->limit(1)
                ->one();
        }

        if (RatingChapter::TEAM == $ratingType->rating_type_rating_chapter_id) {
            $query = RatingTeam::find()
                ->with([
                    'team',
                    'team.base',
                    'team.baseMedical',
                    'team.basePhysical',
                    'team.baseSchool',
                    'team.baseScout',
                    'team.baseTraining',
                    'team.stadium',
                    'team.stadium.city',
                    'team.stadium.city.country',
                ])
                ->joinWith(['team.stadium.city.country'], false)
                ->andFilterWhere(['city_country_id' => $countryId]);

            $countryArray = RatingTeam::find()
                ->joinWith(['team.stadium.city.country'])
                ->groupBy(['country_id'])
                ->orderBy(['country_name' => SORT_ASC])
                ->all();
            $countryArray = ArrayHelper::map(
                $countryArray,
                'team.stadium.city.country.country_id',
                'team.stadium.city.country.country_name'
            );

            $sort = ['rating_team_team_id' => SORT_ASC];
        } elseif (RatingType::USER_RATING == $id) {
            $query = RatingUser::find()
                ->with(['user']);

            $sort = ['rating_user_user_id' => SORT_ASC];
        } else {
            $query = RatingCountry::find()
                ->with(['country'])
                ->joinWith(['country'], false);

            $sort = ['country_name' => SORT_ASC];
        }

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'val' => [
                        'asc' => ArrayHelper::merge([$ratingType->rating_type_order => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge([$ratingType->rating_type_order => SORT_DESC], $sort),
                    ],
                    'game' => [
                        'asc' => ArrayHelper::merge(['country.country_game' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['country.country_game' => SORT_DESC], $sort),
                    ],
                    'auto' => [
                        'asc' => ArrayHelper::merge(['country.country_auto' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['country.country_auto' => SORT_DESC], $sort),
                    ],
                    'player_number' => [
                        'asc' => ArrayHelper::merge(['team.team_player' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_player' => SORT_DESC], $sort),
                    ],
                    'base' => [
                        'asc' => ArrayHelper::merge(['team.team_base_id' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_base_id' => SORT_DESC], $sort),
                    ],
                    'training' => [
                        'asc' => ArrayHelper::merge(['team.team_base_training_id' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_base_training_id' => SORT_DESC], $sort),
                    ],
                    'medical' => [
                        'asc' => ArrayHelper::merge(['team.team_base_medical_id' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_base_medical_id' => SORT_DESC], $sort),
                    ],
                    'physical' => [
                        'asc' => ArrayHelper::merge(['team.team_base_physical_id' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_base_physical_id' => SORT_DESC], $sort),
                    ],
                    'school' => [
                        'asc' => ArrayHelper::merge(['team.team_base_school_id' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_base_school_id' => SORT_DESC], $sort),
                    ],
                    'scout' => [
                        'asc' => ArrayHelper::merge(['team.team_base_scout_id' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_base_scout_id' => SORT_DESC], $sort),
                    ],
                    'team_name' => [
                        'asc' => ArrayHelper::merge(['team.team_name' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_name' => SORT_DESC], $sort),
                    ],
                    's_21' => [
                        'asc' => ArrayHelper::merge(['team.team_power_s_21' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_power_s_21' => SORT_DESC], $sort),
                    ],
                    's_26' => [
                        'asc' => ArrayHelper::merge(['team.team_power_s_26' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_power_s_26' => SORT_DESC], $sort),
                    ],
                    's_32' => [
                        'asc' => ArrayHelper::merge(['team.team_power_s_32' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_power_s_32' => SORT_DESC], $sort),
                    ],
                    'base_price' => [
                        'asc' => ArrayHelper::merge(['team.team_price_base' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_price_base' => SORT_DESC], $sort),
                    ],
                    'player_price' => [
                        'asc' => ArrayHelper::merge(['team.team_price_player' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_price_player' => SORT_DESC], $sort),
                    ],
                    'stadium_price' => [
                        'asc' => ArrayHelper::merge(['team.team_price_stadium' => SORT_ASC], $sort),
                        'desc' => ArrayHelper::merge(['team.team_price_stadium' => SORT_DESC], $sort),
                    ],
                ],
                'defaultOrder' => ['val' => SORT_ASC],
            ],
        ]);

        $this->setSeoTitle('Рейтинги');

        return $this->render('index', [
            'countryId' => $countryId,
            'countryArray' => $countryArray,
            'dataProvider' => $dataProvider,
            'ratingType' => $ratingType,
            'ratingTypeArray' => RatingChapter::selectOptions(),
        ]);
    }
}
