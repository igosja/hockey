<?php

/**
 * @var $this yii\web\View
 * @var $name string
 * @var $message string
 * @var $exception Exception
 */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h1><?= Html::encode($this->title) ?></h1>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
                <?= nl2br(Html::encode($message)) ?>
            </div>
        </div>
    </div>
</div>
