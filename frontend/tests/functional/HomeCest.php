<?php

namespace frontend\tests\functional;

use common\fixtures\NewsFixture;
use common\fixtures\ReviewFixture;
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
            NewsFixture::class,
            ReviewFixture::class,
            UserFixture::class,
        ]);
        $I->amOnPage(Url::to(['/site/index']));
        $I->seeCurrentUrlEquals('/ru');

        $I->see('Онлайн-менеджер для истинных любителей хоккея!', 'h1');

        $I->see('Последние игровые новости', 'h2');
        $I->see('Заголовок общесайтовой новости', 'span');
        $I->see('Текст общесайтовой новости', 'p');

        $I->see('Хоккейная аналитика', 'h2');
        $I->see('Австрия', 'li');
        $I->see('(D1)', 'li');
        $I->see('1-й тур', 'li');
        $I->see('Заголовок обзора', 'a');

        $I->see('Новости федераций', 'h2');
        $I->see('Заголовок новости федерации', 'span');
        $I->see('Текст новости федерации', 'p');

        $I->see('Дни рождения', 'h2');
        $I->see('Сегодня день рождения празднуют менеджеры', 'p');
        $I->see('10-я годовщина!', 'li');
    }
}