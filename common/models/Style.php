<?php

namespace common\models;

use Yii;

/**
 * Class Style
 * @package common\models
 */
class Style
{
    const NORMAL = 1;
    const POWER = 2;
    const SPEED = 3;
    const TECHNIQUE = 4;
    const ALL_STYLES = [
        self::NORMAL,
        self::POWER,
        self::SPEED,
        self::TECHNIQUE,
    ];
    const PLAYER_STYLES = [
        self::POWER,
        self::SPEED,
        self::TECHNIQUE,
    ];

    /**
     * @return array
     */
    public static function getLabels(): array
    {
        return [
            self::NORMAL => Yii::t('common-models-style', 'label-normal'),
            self::POWER => Yii::t('common-models-style', 'label-power'),
            self::SPEED => Yii::t('common-models-style', 'label-speed'),
            self::TECHNIQUE => Yii::t('common-models-style', 'label-technique'),
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public static function getLabel($id): string
    {
        if (!in_array($id, self::ALL_STYLES)) {
            return self::getLabel(self::NORMAL);
        }
        return self::getLabels()[$id];
    }

    /**
     * @return int
     */
    public static function getRandStyleId(): int
    {
        return self::PLAYER_STYLES[array_rand(self::PLAYER_STYLES)];
    }
}
