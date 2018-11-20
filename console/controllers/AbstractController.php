<?php

namespace console\controllers;

use yii\console\Controller;

/**
 * Class AbstractController
 * @package console\controllers
 */
abstract class AbstractController extends Controller
{
    /**
     * @param array $modelArray
     */
    protected function progress(array $modelArray)
    {
        for ($i = 0, $countModel = count($modelArray); $i < $countModel; $i++) {
            $this->stdout('Начинаем ' . get_class($modelArray[$i]) . '...');
            $modelArray[$i]->execute();
            $this->stdout(' Готово. ' . round(($i + 1) / $countModel * 100, 1) . '% выполнено' . PHP_EOL);
        }
    }
}
