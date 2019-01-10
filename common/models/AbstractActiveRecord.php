<?php

namespace common\models;

use common\components\ErrorHelper;
use Exception;
use yii\db\ActiveRecord;

/**
 * Class AbstractActiveRecord
 * @package common\models
 */
abstract class AbstractActiveRecord extends ActiveRecord
{
    /**
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     * @throws Exception
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        if (!parent::save($runValidation, $attributeNames)) {
            throw new Exception(ErrorHelper::modelErrorsToString($this));
        }
        return true;
    }
}
