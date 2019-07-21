<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
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
    public function checkHome(FunctionalTester $I)
    {
        $I->haveFixtures([
            UserFixture::class,
        ]);
        $I->amOnPage(Url::to(['/site/index']));
        $I->seeCurrentUrlEquals('/ru');
        $I->see('Онлайн-менеджер для истинных любителей хоккея!', 'h1');
        $I->see('Последние игровые новости', 'h2');
//        $I->see('Хоккейная аналитика', 'h2');
//        $I->see('Новости федераций', 'h2');
        $I->see('Дни рождения', 'h2');
        $I->canSee('исполняется 10 лет!', 'li');
        $I->canSee('исполняется 1 год!', 'li');
        $I->canSee('исполняется 2 года!', 'li');
    }
}