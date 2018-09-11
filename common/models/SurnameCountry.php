<?php

namespace common\models;

use yii\db\ActiveRecord;

/**
 * Class SurnameCountry
 * @package common\models
 *
 * @property integer $surname_country_id
 * @property integer $surname_country_country_id
 * @property integer $surname_country_surname_id
 */
class SurnameCountry extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%surname_country}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['surname_country_country_id'], 'in', 'range' => Country::find()->select(['country_id'])->column()],
            [['surname_country_surname_id'], 'in', 'range' => Surname::find()->select(['surname_id'])->column()],
            [['surname_country_id'], 'integer'],
            [['surname_country_country_id', 'surname_country_surname_id'], 'required'],
        ];
    }

    /**
     * @param integer $countryId
     * @param string $andWhere
     * @return false|null|string
     */
    public static function getRandSurnameId(int $countryId, $andWhere = '1=1')
    {
        return self::find()
            ->select(['surname_country_surname_id'])
            ->where(['surname_country_country_id' => $countryId])
            ->andWhere($andWhere)
            ->orderBy('RAND()')
            ->limit(1)
            ->scalar();
    }

    /**
     * @param int $teamId
     * @param int $countryId
     * @param int $length
     * @return int
     */
    public static function getRandFreeSurnameId(int $teamId, int $countryId, int $length = 1): int
    {
        $teamSurnameArray = Surname::find()
            ->joinWith(['player'])
            ->select('SUBSTRING(surname_name, 1, ' . $length . ') AS surname_name')
            ->where(['player_team_id' => $teamId])
            ->orderBy(['player_id' => SORT_ASC])
            ->column();

        if (0 == count($teamSurnameArray)) {
            $surnameId = self::getRandSurnameId($countryId);
        } else {
            $surnameId = self::getRandSurnameId(
                $countryId,
                ['not', ['SUBSTRING(`surname_name`, 1, ' . $length . ')' => $teamSurnameArray]]
            );

            if (!$surnameId) {
                $length++;
                $surnameId = self::getRandFreeSurnameId($teamId, $countryId, $length);
            }
        }

        return $surnameId;
    }
}
