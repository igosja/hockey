<?php

namespace frontend\controllers;

use common\models\RatingCountry;
use common\models\RatingTeam;
use common\models\RatingType;
use common\models\RatingUser;
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
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex($id = RatingType::TEAM_POWER): string
    {
        $ratingTypeArray = RatingType::find()
            ->orderBy(['rating_type_rating_chapter_id' => SORT_ASC, 'rating_type_id' => SORT_ASC])
            ->all();

        $ratingType = RatingType::find()
            ->where(['rating_type_id' => $id])
            ->one();
        $this->notFound($ratingType);

        if (in_array($id, [
            RatingType::TEAM_POWER,
            RatingType::TEAM_AGE,
            RatingType::TEAM_STADIUM,
            RatingType::TEAM_VISITOR,
            RatingType::TEAM_BASE,
            RatingType::TEAM_PRICE_BASE,
            RatingType::TEAM_PRICE_STADIUM,
            RatingType::TEAM_PLAYER,
            RatingType::TEAM_PRICE_TOTAL,
        ])) {
            $query = RatingTeam::find()
                ->orderBy([$ratingType->rating_type_order => SORT_ASC, 'rating_team_team_id' => SORT_ASC]);
        } elseif (RatingType::USER_RATING) {
            $query = RatingUser::find()
                ->orderBy([$ratingType->rating_type_order => SORT_ASC, 'rating_user_user_id' => SORT_ASC]);
        } else {
            $query = RatingCountry::find()
                ->orderBy([$ratingType->rating_type_order => SORT_ASC, 'rating_country_country_id' => SORT_ASC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->setSeoTitle('Рейтинги');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'ratingType' => $ratingType,
            'ratingTypeArray' => ArrayHelper::map($ratingTypeArray, 'rating_type_id', 'rating_type_name'),
        ]);
    }
}
