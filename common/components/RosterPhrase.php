<?php

namespace common\components;

use Yii;
use yii\helpers\Html;

/**
 * Class RosterPhrase
 * @package common\components
 */
class RosterPhrase
{
    /**
     * @return string
     */
    public static function rand(): string
    {
        $data = [
            Yii::t('common-components-roster-phrase', 'text-1', [
                'link' => Html::a(Yii::t('common-components-roster-phrase', 'link-1'), ['user/holiday'])
            ]),
            Yii::t('common-components-roster-phrase', 'text-2', [
                'link' => Html::a(Yii::t('common-components-roster-phrase', 'link-2'), ['user/referral'])
            ]),
            Yii::t('common-components-roster-phrase', 'text-3', [
                'link' => Html::a(Yii::t('common-components-roster-phrase', 'link-3'), ['support/index'])
            ]),
            Yii::t('common-components-roster-phrase', 'text-4'),
            Yii::t('common-components-roster-phrase', 'text-5'),
        ];
        return $data[array_rand($data)];
    }
}
