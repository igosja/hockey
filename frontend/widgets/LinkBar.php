<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class LinkBar
 * @package common\widgets
 *
 * @property string $bar
 * @property array $item
 * @property array $items
 * @property array $params
 * @property string $route
 */
class LinkBar extends Widget
{
    /**
     * @var array $items
     */
    public $items;
    /**
     * @var string $bar
     */
    private $bar;
    /**
     * @var array $item
     */
    private $item;

    /**
     * @var string $route
     */
    private $route;

    /**
     * @var array $params
     */
    private $params;

    /**
     * @return void
     */
    public function init(): void
    {
        parent::init();
        if ($this->route === null && Yii::$app->controller !== null) {
            $this->route = Yii::$app->controller->getRoute();
        }
        if ($this->params === null) {
            $this->params = Yii::$app->request->getQueryParams();
        }
    }

    /**
     * @return string
     */
    public function run(): string
    {
        $this->renderBar();
        return $this->bar;
    }

    /**
     * @return void
     */
    private function renderBar(): void
    {
        $result = [];
        foreach ($this->items as $item) {
            $this->item = $item;
            $result[] = $this->renderItem();
        }
        $this->bar = implode(' | ', $result);
    }

    /**
     * @return string
     */
    private function renderItem(): string
    {
        if ($this->isActive()) {
            return Html::tag('span', $this->item['text'], ['class' => 'strong']);
        } else {
            return Html::a($this->item['text'], $this->item['url']);
        }
    }

    /**
     * @return bool
     */
    private function isActive(): bool
    {
        if (isset($this->item['url']) && is_array($this->item['url']) && isset($this->item['url'][0])) {
            $route = $this->item['url'][0];
            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }
            if (ltrim($route, '/') !== $this->route) {
                return false;
            }
            unset($this->item['url']['#']);
            if (count($this->item['url']) > 1) {
                $params = $this->item['url'];
                unset($params[0]);
                foreach ($params as $name => $value) {
                    if ($value !== null && (!isset($this->params[$name]) || $this->params[$name] != $value)) {
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }
}
