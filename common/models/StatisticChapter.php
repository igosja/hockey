<?php

namespace common\models;

use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * Class StatisticChapter
 * @package common\models
 *
 * @property int $statistic_chapter_id
 * @property string $statistic_chapter_name
 * @property int $statistic_chapter_order
 *
 * @property StatisticType[] $statisticType
 */
class StatisticChapter extends AbstractActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%statistic_chapter}}';
    }

    /**
     * @return array
     */
    public static function selectOptions()
    {
        $typesArray = self::find()
            ->with(['statisticType'])
            ->select(['statistic_chapter_id', 'statistic_chapter_name'])
            ->orderBy(['statistic_chapter_order' => SORT_ASC])
            ->all();

        $result = [];
        foreach ($typesArray as $item) {
            $result[$item->statistic_chapter_name] = ArrayHelper::map(
                $item->statisticType,
                'statistic_type_id',
                'statistic_type_name'
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
            [['statistic_chapter_id', 'statistic_chapter_order'], 'integer'],
            [['statistic_chapter_name'], 'required'],
            [['statistic_chapter_name'], 'string', 'max' => 255],
            [['statistic_chapter_name'], 'trim'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $order = self::find()->max('statistic_chapter_order');
                if (!$order) {
                    $order = 1;
                }
                $order++;
                $this->statistic_chapter_order = $order;
            }
            return true;
        }
        return false;
    }

    /**
     * @return ActiveQuery
     */
    public function getStatisticType()
    {
        return $this->hasMany(StatisticType::class, ['statistic_type_statistic_chapter_id' => 'statistic_chapter_id']);
    }
}
