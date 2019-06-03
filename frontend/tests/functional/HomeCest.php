<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;
use yii\helpers\Url;

/**
 * Class HomeCest
 * @package frontend\tests\functional
 */
class HomeCest
{
    /**
     * @param FunctionalTester $I
     */
    public function checkOpenMainPage(FunctionalTester $I)
    {
        $I->amOnPage(Url::to(['/site/index', 'language' => 'ru']));
        $I->see('Онлайн-менеджер для истинных любителей хоккея!', 'h1');
    }
}