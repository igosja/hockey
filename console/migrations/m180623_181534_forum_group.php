<?php

use yii\db\Migration;

/**
 * Class m180623_181534_forum_group
 */
class m180623_181534_forum_group extends Migration
{
    const TABLE = '{{%forum_group}}';

    /**
     * @return bool|void
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE, [
            'forum_group_id' => $this->primaryKey(11),
            'forum_group_country_id' => $this->integer(3)->defaultValue(0),
            'forum_group_description' => $this->text(),
            'forum_group_forum_chapter_id' => $this->integer(11)->defaultValue(0),
            'forum_group_name' => $this->string(255),
            'forum_group_order' => $this->integer(3)->defaultValue(0),
        ]);

        $this->batchInsert(
            self::TABLE,
            [
                'forum_group_country_id',
                'forum_group_name',
                'forum_group_description',
                'forum_group_forum_chapter_id',
                'forum_group_order'
            ],
            [
                [
                    0,
                    'О Лиге',
                    'вопросы и комментарии о лиге глобального характера, творчество, что нравится/не нравится',
                    1,
                    1
                ],
                [
                    0,
                    'Скорая помощь',
                    'сверxсрочные проблемы, не терпящие отлагательств, а то будет поздно - остальное в баги или вопросы новичков',
                    1,
                    2
                ],
                [
                    0,
                    'Вопросы новичков',
                    'для обсуждения с опытными менеджерами возникающих у новичков самых простых вопросов',
                    1,
                    3
                ],
                [
                    0,
                    'Регистрация и команды',
                    '[пере]регистрация, выставление/раздача свободных команд, переходы из клуба в клуб, верните команду и т.д.',
                    1,
                    4
                ],
                [
                    0,
                    'Идеи и предложения',
                    'высказывание интересных мыслей и конкретных идей по поводу развития лиги',
                    1,
                    5
                ],
                [0, 'Правила', 'обсуждение, трактовка, серьезные вопросы по поводу действующих правил', 1, 6],
                [0, 'Трансферы', 'если хотите договориться о купле/продаже игроков', 2, 7],
                [0, 'Товарищеские Матчи', 'поиск соперников на товы', 2, 8],
                [0, 'Аренда', 'если хотите договориться об аренде игроков', 2, 9],
                [0, 'Встречи', 'встречи менеджеров в реале - на стадион сходить, пивка попить', 3, 10],
                [0, 'Реальный хоккей', 'обсуждение реальных событий, хоккейный оффтопик', 3, 11],
                [0, 'Оффтопик', 'обсуждение всего чего угодно за пределами Лиги', 3, 12],
                [18, 'Белоруссия', 'национальный форум', 4, 13],
                [43, 'Германия', 'национальный форум', 4, 14],
                [71, 'Канада', 'национальный форум', 4, 15],
                [122, 'Норвегия', 'национальный форум', 4, 16],
                [133, 'Россия', 'национальный форум', 4, 17],
                [151, 'Словакия', 'национальный форум', 4, 18],
                [157, 'США', 'национальный форум', 4, 19],
                [171, 'Украина', 'национальный форум', 4, 20],
                [176, 'Финляндия', 'национальный форум', 4, 21],
                [182, 'Чехия', 'национальный форум', 4, 22],
                [184, 'Швейцария', 'национальный форум', 4, 23],
                [185, 'Швеция', 'национальный форум', 4, 24],
            ]
        );
    }

    /**
     * @return bool|void
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE);
    }
}