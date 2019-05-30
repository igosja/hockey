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
                ])
                ->joinWith(['team.stadium.city.country'])
                ->andFilterWhere(['city_country_id' => $countryId])
                ->orderBy([$ratingType->rating_type_order => SORT_ASC, 'rating_team_team_id' => SORT_ASC]);

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
        } elseif (RatingType::USER_RATING == $id) {
            $query = RatingUser::find()
                ->with(['user'])
                ->orderBy([$ratingType->rating_type_order => SORT_ASC, 'rating_user_user_id' => SORT_ASC]);
        } else {
            $query = RatingCountry::find()
                ->joinWith(['country'])
                ->orderBy([$ratingType->rating_type_order => SORT_ASC, 'country_name' => SORT_ASC]);
        }

        $dataProvider = new ActiveDataProvider([
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSizeTable'],
            ],
            'query' => $query,
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
