<?php

namespace frontend\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Class Menu
 * @package common\widgets
 *
 * @property array $menuItemList
 * @property array $menuItems
 * @property string $menu
 */
class Menu extends Widget
{
    const ITEM_CHANGE_TEAM = 'changeTeam';
    const ITEM_FEDERATION = 'federation';
    const ITEM_FORUM = 'forum';
    const ITEM_HOME = 'home';
    const ITEM_LOAN = 'loan';
    const ITEM_MESSENGER = 'messenger';
    const ITEM_NATIONAL_TEAM = 'nationalTeam';
    const ITEM_NEWS = 'news';
    const ITEM_PASSWORD = 'password';
    const ITEM_PLAYER = 'player';
    const ITEM_POLL = 'poll';
    const ITEM_PROFILE = 'profile';
    const ITEM_RATING = 'rating';
    const ITEM_ROSTER = 'roster';
    const ITEM_RULE = 'rule';
    const ITEM_SCHEDULE = 'schedule';
    const ITEM_SING_UP = 'signUp';
    const ITEM_STORE = 'store';
    const ITEM_SUPPORT = 'support';
    const ITEM_TEAM = 'team';
    const ITEM_TOURNAMENT = 'tournament';
    const ITEM_TRANSFER = 'transfer';
    const ITEM_VIP = 'vip';

    private $menuItemList;
    private $menuItems;
    private $menu;

    /**
     * @return string
     */
    public function run()
    {
        $this->generateMenu();
        return $this->menu;
    }

    private function generateMenu()
    {
        $this->setMenuItems();
        $this->menuItemsToHtml();
    }

    private function setMenuItems()
    {
        if (Yii::$app->user->isGuest) {
            $this->setGuestMenuItems();
        } else {
            $this->setUserMenuItems();
        }
    }

    private function setGuestMenuItems()
    {
        $this->menuItems = [
            [
                [
                    self::ITEM_HOME,
                    self::ITEM_NEWS,
                    self::ITEM_RULE,
                    self::ITEM_POLL,
                ],
                [
                    self::ITEM_SING_UP,
                    self::ITEM_PASSWORD,
                ],
            ],
            [
                [
                    self::ITEM_SCHEDULE,
                    self::ITEM_TOURNAMENT,
                    self::ITEM_TEAM,
                ],
                [
                    self::ITEM_PLAYER,
                    self::ITEM_TRANSFER,
                ],
            ],
            [
                [
                    self::ITEM_LOAN,
                    self::ITEM_FORUM,
                    self::ITEM_RATING,
                ],
            ]
        ];
    }

    private function setUserMenuItems()
    {
        $this->menuItems = [
            [
                [
                    self::ITEM_HOME,
                    self::ITEM_NEWS,
                    self::ITEM_RULE,
                ],
                [
                    self::ITEM_VIP,
                    self::ITEM_POLL,
                    self::ITEM_CHANGE_TEAM,
                ],
            ],
            [
                [
                    self::ITEM_ROSTER,
                    self::ITEM_PROFILE,
                    self::ITEM_SCHEDULE,
                ],
                [
                    self::ITEM_TOURNAMENT,
                    self::ITEM_TEAM,
                    self::ITEM_PLAYER,
                ],
                [
                    self::ITEM_TRANSFER,
                    self::ITEM_LOAN,
                ],
            ],
            [
                [
                    self::ITEM_MESSENGER,
                    self::ITEM_FEDERATION,
                    self::ITEM_STORE,
                ],
                [
                    self::ITEM_FORUM,
                    self::ITEM_SUPPORT,
                    self::ITEM_RATING,
                ],
            ],
        ];
    }

    private function menuItemsToHtml()
    {
        $this->menuItemsToLinkArray();
        $rows = [];
        foreach ($this->menuItems as $itemRows) {
            $rowsMobile = [];
            foreach ($itemRows as $itemRowsMobile) {
                $rowsMobile[] = implode(' | ', $itemRowsMobile);
            }
            $rows[] = implode(
                '<span class="hidden-xs"> | </span><br class="hidden-lg hidden-md hidden-sm">',
                $rowsMobile
            );
        }
        $this->menu = implode('<br/>', $rows);
    }

    private function menuItemsToLinkArray()
    {
        $this->setMenuItemList();
        $rows = [];
        foreach ($this->menuItems as $itemRows) {
            $rowsMobile = [];
            foreach ($itemRows as $itemRowsMobile) {
                $items = [];
                foreach ($itemRowsMobile as $item) {
                    $items[] = Html::a(
                        $this->menuItemList[$item]['label'],
                        $this->menuItemList[$item]['url'],
                        [
                            'class' => $this->menuItemList[$item]['css'] ?? '',
                            'target' => $this->menuItemList[$item]['target'] ?? '',
                        ]
                    );
                }
                $rowsMobile[] = $items;
            }
            $rows[] = $rowsMobile;
        }
        $this->menuItems = $rows;
    }

    private function setMenuItemList()
    {
        $this->menuItemList = [
            self::ITEM_CHANGE_TEAM => [
                'label' => Yii::t('frontend-widgets-Menu', 'change-team'),
                'url' => ['team/change'],
            ],
            self::ITEM_FEDERATION => [
                'label' => Yii::t('frontend-widgets-Menu', 'federation'),
                'url' => ['country/news'],
            ],
            self::ITEM_FORUM => [
                'label' => Yii::t('frontend-widgets-Menu', 'forum'),
                'target' => '_blank',
                'url' => ['forum/index'],
            ],
            self::ITEM_HOME => [
                'label' => Yii::t('frontend-widgets-Menu', 'home'),
                'url' => ['site/index'],
            ],
            self::ITEM_LOAN => [
                'label' => Yii::t('frontend-widgets-Menu', 'loan'),
                'url' => ['loan/index'],
            ],
            self::ITEM_MESSENGER => [
                'label' => Yii::t('frontend-widgets-Menu', 'messenger'),
                'url' => ['messenger/index'],
            ],
            self::ITEM_NATIONAL_TEAM => [
                'label' => Yii::t('frontend-widgets-Menu', 'national-team'),
                'url' => ['national/index'],
            ],
            self::ITEM_NEWS => [
                'label' => Yii::t('frontend-widgets-Menu', 'news'),
                'url' => ['news/index'],
            ],
            self::ITEM_PASSWORD => [
                'label' => Yii::t('frontend-widgets-Menu', 'password'),
                'url' => ['password/index'],
            ],
            self::ITEM_PLAYER => [
                'label' => Yii::t('frontend-widgets-Menu', 'player'),
                'url' => ['player/index'],
            ],
            self::ITEM_POLL => [
                'label' => Yii::t('frontend-widgets-Menu', 'poll'),
                'url' => ['poll/index'],
            ],
            self::ITEM_PROFILE => [
                'label' => Yii::t('frontend-widgets-Menu', 'profile'),
                'url' => ['user/view'],
            ],
            self::ITEM_RATING => [
                'label' => Yii::t('frontend-widgets-Menu', 'rating'),
                'url' => ['rating/index'],
            ],
            self::ITEM_ROSTER => [
                'css' => 'red',
                'label' => Yii::t('frontend-widgets-Menu', 'roster'),
                'url' => ['team/view'],
            ],
            self::ITEM_RULE => [
                'label' => Yii::t('frontend-widgets-Menu', 'rule'),
                'url' => ['rule/index'],
            ],
            self::ITEM_SCHEDULE => [
                'label' => Yii::t('frontend-widgets-Menu', 'schedule'),
                'url' => ['schedule/index'],
            ],
            self::ITEM_SING_UP => [
                'css' => 'red',
                'label' => Yii::t('frontend-widgets-Menu', 'sign-up'),
                'url' => ['site/sign-up'],
            ],
            self::ITEM_STORE => [
                'label' => Yii::t('frontend-widgets-Menu', 'store'),
                'url' => ['store/index'],
            ],
            self::ITEM_SUPPORT => [
                'label' => Yii::t('frontend-widgets-Menu', 'support'),
                'url' => ['support/index'],
            ],
            self::ITEM_TEAM => [
                'label' => Yii::t('frontend-widgets-Menu', 'team'),
                'url' => ['team/index'],
            ],
            self::ITEM_TOURNAMENT => [
                'label' => Yii::t('frontend-widgets-Menu', 'tournament'),
                'url' => ['tournament/index'],
            ],
            self::ITEM_TRANSFER => [
                'label' => Yii::t('frontend-widgets-Menu', 'transfer'),
                'url' => ['transfer/index'],
            ],
            self::ITEM_VIP => [
                'label' => Yii::t('frontend-widgets-Menu', 'vip'),
                'url' => ['vip/index'],
            ],
        ];
    }
}
