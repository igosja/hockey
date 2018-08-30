<?php

namespace frontend\widgets;

use yii\helpers\Html;

class DetailView extends \yii\widgets\DetailView
{
    /**
     * @param array $attribute
     * @param integer $index
     * @return string
     */
    protected function renderAttribute($attribute, $index): string
    {
        Html::addCssClass($attribute['captionOptions'], 'col-lg-6 col-md-6 col-sm-6 col-xs-6');
        return parent::renderAttribute($attribute, $index);
    }
}
