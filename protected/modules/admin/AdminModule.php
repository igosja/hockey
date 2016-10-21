<?php

class AdminModule extends CWebModule
{
    public $layout = 'main';

    public function init()
    {
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            return true;
        }
        return false;
    }
}