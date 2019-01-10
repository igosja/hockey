<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class RatingChapter
 * @package common\models
 *
 * @property int $rating_chapter_id
 * @property string $rating_chapter_name
 * @property string $rating_chapter_order
 *
 * @property RatingType[] $ratingType
 */
class RatingChapter extends AbstractActiveRecord
{
    const TEAM = 1;
    const USER = 2;
    const COUNTRY = 3;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%rating_chapter}}';
    }

    /**
     * @return array
     */
    public static function selectOptions()
    {
        $typesArray = self::find()
            ->with(['ratingType'])
            ->select(['rating_chapter_id', 'rating_chapter_name'])
            ->orderBy(['rating_chapter_order' => SORT_ASC])
            ->all();

        $result = [];
        foreach ($typesArray as $item) {
            $result[$item->rating_chapter_name] = ArrayHelper::map(
                $item->ratingType,
                'rating_type_id',
                'rating_type_name'
            );
        }

        return $result;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['rating_chapter_id', 'rating_chapter_order'], 'integer'],
            [['rating_chapter_name'], 'required'],
            [['rating_chapter_name'], 'string', 'max' => 255],
            [['rating_chapter_name'], 'trim'],
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getRatingType()
    {
        return $this->hasMany(RatingType::class, ['rating_type_rating_chapter_id' => 'rating_chapter_id'])->cache();
    }
}
