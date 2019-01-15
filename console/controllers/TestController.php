<?php

namespace console\controllers;

/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends AbstractController
{
    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $model = new \DateTime();
        $this->stdout($model->format('H:i:s'));
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionDatabase()
    {
        $tableArray = \Yii::$app->db->createCommand('SHOW TABLES')->queryAll();
        foreach ($tableArray as $table) {
            $table = array_values($table);
            if (isset($table[0]) && $table[0]) {
                $table = $table[0];
                $this->stdout($table);
                \Yii::$app->db->createCommand('ALTER TABLE `' . $table . '` ENGINE = InnoDB;')->execute();
                $this->stdout('... done' . PHP_EOL);
            }
        }
    }
}
