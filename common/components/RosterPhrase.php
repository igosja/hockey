<?php

namespace common\components;

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
            'Уезжая надолго и без интернета - не забудьте поставить статус ' . Html::a('в отпуске', ['user/holiday']),
            Html::a('Пригласите друзей', ['user/referral']) . 'в Лигу и получите вознаграждение',
            'Если у вас есть вопросы - задайте их специалистам ' . Html::a('тех.поддержки',
                ['support/index']) . ' Лиги',
            'Можно достичь высоких результатов, не нарушая правил',
            'Играйте честно - так интереснее выигрывать',
        ];
        return $data[array_rand($data)];
    }
}
