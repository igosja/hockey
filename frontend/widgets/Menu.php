<?php

namespace frontend\widgets;

use common\models\Support;
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

    /**
     * @return void
     */
    private function setMenuItemList(): void
    {
        $support = 0;
        if (!Yii::$app->user->isGuest) {
            $support = Support::find()
                ->where(['support_user_id' => Yii::$app->user->id, 'support_question' => 0, 'support_read' => 0])
                ->count();
        }

        $this->menuItemList = [
            self::ITEM_CHANGE_TEAM => [
                'label' => 'Сменить клуб',
                'url' => ['team/change'],
            ],
            self::ITEM_FEDERATION => [
                'label' => 'Федерация',
                'url' => ['country/news'],
            ],
            self::ITEM_FORUM => [
                'label' => 'Форум',
                'target' => '_blank',
                'url' => ['forum/index'],
            ],
            self::ITEM_HOME => [
                'label' => 'Главная',
                'url' => ['site/index'],
            ],
            self::ITEM_LOAN => [
                'label' => 'Аренда',
                'url' => ['loan/index'],
            ],
            self::ITEM_MESSENGER => [
                'label' => 'Общение',
                'url' => ['messenger/index'],
            ],
            self::ITEM_NATIONAL_TEAM => [
                'label' => 'Сборная',
                'url' => ['national/index'],
            ],
            self::ITEM_NEWS => [
                'label' => 'Новости',
                'url' => ['news/index'],
            ],
            self::ITEM_PASSWORD => [
                'label' => 'Забыли пароль?',
                'url' => ['site/password'],
            ],
            self::ITEM_PLAYER => [
                'label' => 'Игроки',
                'url' => ['player/index'],
            ],
            self::ITEM_POLL => [
                'label' => 'Опросы',
                'url' => ['poll/index'],
            ],
            self::ITEM_PROFILE => [
                'label' => 'Профиль',
                'url' => ['user/view'],
            ],
            self::ITEM_RATING => [
                'label' => 'Рейтинги',
                'url' => ['rating/index'],
            ],
            self::ITEM_ROSTER => [
                'css' => 'red',
                'label' => 'Ростер',
                'url' => ['team/view'],
            ],
            self::ITEM_RULE => [
                'label' => 'Правила',
                'url' => ['rule/index'],
            ],
            self::ITEM_SCHEDULE => [
                'label' => 'Расписание',
                'url' => ['schedule/index'],
            ],
            self::ITEM_SING_UP => [
                'css' => 'red',
                'label' => 'Регистрация',
                'url' => ['site/sign-up'],
            ],
            self::ITEM_STORE => [
                'label' => 'Магазин',
                'url' => ['store/index'],
            ],
            self::ITEM_SUPPORT => [
                'css' => $support ? 'red' : '',
                'label' => 'Техподдержка',
                'url' => ['support/index'],
            ],
            self::ITEM_TEAM => [
                'label' => 'Команды',
                'url' => ['team/index'],
            ],
            self::ITEM_TOURNAMENT => [
                'label' => 'Турниры',
                'url' => ['tournament/index'],
            ],
            self::ITEM_TRANSFER => [
                'label' => 'Трансфер',
                'url' => ['transfer/index'],
            ],
            self::ITEM_VIP => [
                'label' => 'VIP-клуб',
                'url' => ['vip/index'],
            ],
        ];
    }
}
