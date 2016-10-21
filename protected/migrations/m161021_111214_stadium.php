<?php

class m161021_111214_stadium extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{stadium}}', array(
            'stadium_id' => 'pk',
            'stadium_capacity' => 'INT(11) DEFAULT 100',
            'stadium_city_id' => 'INT(11) DEFAULT 0',
            'stadium_name' => 'VARCHAR(255) NOT NULL',
        ));

        $this->createIndex('stadium_city_id', '{{stadium}}', 'stadium_city_id');

        $this->insertMultiple('{{stadium}}', array(
            array('stadium_city_id' => 1, 'stadium_name' => 'Юбилейный'),
            array('stadium_city_id' => 29, 'stadium_name' => 'Хонда-центр'),
            array('stadium_city_id' => 2, 'stadium_name' => 'Балашиха-Арена'),
            array('stadium_city_id' => 30, 'stadium_name' => 'Робобанк-арена'),
            array('stadium_city_id' => 31, 'stadium_name' => 'ТД-гарден'),
            array('stadium_city_id' => 32, 'stadium_name' => 'КиБэнк-центр'),
            array('stadium_city_id' => 33, 'stadium_name' => 'Верайзон-центр'),
            array('stadium_city_id' => 3, 'stadium_name' => 'Фетисов-Арена'),
            array('stadium_city_id' => 34, 'stadium_name' => 'Хила Ривер-арена'),
            array('stadium_city_id' => 35, 'stadium_name' => 'Ван Андел-арена'),
            array('stadium_city_id' => 36, 'stadium_name' => 'Американ Эйрлайнс-центр'),
            array('stadium_city_id' => 37, 'stadium_name' => 'Велс Фарго-арена'),
            array('stadium_city_id' => 38, 'stadium_name' => 'Пепси-центр'),
            array('stadium_city_id' => 39, 'stadium_name' => 'Джо Луис Арена'),
            array('stadium_city_id' => 4, 'stadium_name' => 'Уралец'),
            array('stadium_city_id' => 5, 'stadium_name' => 'Татнефть-Арена'),
            array('stadium_city_id' => 40, 'stadium_name' => 'Куикен Лоанс-арена'),
            array('stadium_city_id' => 41, 'stadium_name' => 'Нэшнуайд-арена'),
            array('stadium_city_id' => 42, 'stadium_name' => 'Стэйплс-центр'),
            array('stadium_city_id' => 6, 'stadium_name' => 'Арена-Металлург'),
            array('stadium_city_id' => 43, 'stadium_name' => 'Гарис Бредли-центр'),
            array('stadium_city_id' => 7, 'stadium_name' => 'Ледовый Дворец'),
            array('stadium_city_id' => 7, 'stadium_name' => 'Крылья Советов'),
            array('stadium_city_id' => 7, 'stadium_name' => 'Лужники'),
            array('stadium_city_id' => 7, 'stadium_name' => 'ЦСКА'),
            array('stadium_city_id' => 8, 'stadium_name' => 'Арена Мытищи'),
            array('stadium_city_id' => 9, 'stadium_name' => 'Нефтекамск'),
            array('stadium_city_id' => 10, 'stadium_name' => 'Нефтехимик'),
            array('stadium_city_id' => 11, 'stadium_name' => 'Нагорный'),
            array('stadium_city_id' => 12, 'stadium_name' => 'Кузнецких металлургов'),
            array('stadium_city_id' => 13, 'stadium_name' => 'Сибирь'),
            array('stadium_city_id' => 44, 'stadium_name' => 'Барклайс-центр'),
            array('stadium_city_id' => 44, 'stadium_name' => 'Мэдисон-сквер-гарден'),
            array('stadium_city_id' => 45, 'stadium_name' => 'Пруденшал-центр'),
            array('stadium_city_id' => 46, 'stadium_name' => 'Бриджстоун-арена'),
            array('stadium_city_id' => 14, 'stadium_name' => 'Арена Омск'),
            array('stadium_city_id' => 15, 'stadium_name' => 'Дизель-Арена'),
            array('stadium_city_id' => 47, 'stadium_name' => 'Консол Энерджи-центр'),
            array('stadium_city_id' => 16, 'stadium_name' => 'Витязь'),
            array('stadium_city_id' => 48, 'stadium_name' => 'Гарис Банк-центр'),
            array('stadium_city_id' => 49, 'stadium_name' => 'PNC-арена'),
            array('stadium_city_id' => 50, 'stadium_name' => 'SAP-центр'),
            array('stadium_city_id' => 17, 'stadium_name' => 'Ледовый Дворец'),
            array('stadium_city_id' => 51, 'stadium_name' => 'BB&T-центр'),
            array('stadium_city_id' => 18, 'stadium_name' => 'Кристалл'),
            array('stadium_city_id' => 52, 'stadium_name' => 'Седар Парк-центр'),
            array('stadium_city_id' => 53, 'stadium_name' => 'Скоттрэйд-центр'),
            array('stadium_city_id' => 54, 'stadium_name' => 'Эксел Энерджи-центр'),
            array('stadium_city_id' => 19, 'stadium_name' => 'Большой'),
            array('stadium_city_id' => 55, 'stadium_name' => 'Стоктон-арена'),
            array('stadium_city_id' => 56, 'stadium_name' => 'Амали-арена'),
            array('stadium_city_id' => 20, 'stadium_name' => 'Лада-Арена'),
            array('stadium_city_id' => 21, 'stadium_name' => 'Дворец спорта'),
            array('stadium_city_id' => 22, 'stadium_name' => 'Уфа-Арена'),
            array('stadium_city_id' => 57, 'stadium_name' => 'Веллс-Фарго-центр'),
            array('stadium_city_id' => 23, 'stadium_name' => 'Платинум Арена'),
            array('stadium_city_id' => 24, 'stadium_name' => 'Арена-Югра'),
            array('stadium_city_id' => 25, 'stadium_name' => 'Трактор'),
            array('stadium_city_id' => 25, 'stadium_name' => 'Юность'),
            array('stadium_city_id' => 26, 'stadium_name' => 'Ледовый Дворец'),
            array('stadium_city_id' => 58, 'stadium_name' => 'Юнайтед-центр'),
            array('stadium_city_id' => 58, 'stadium_name' => 'Олстейт-арена'),
            array('stadium_city_id' => 27, 'stadium_name' => 'Кристалл'),
            array('stadium_city_id' => 28, 'stadium_name' => 'Арена 2000'),
        ));
    }

    public function down()
    {
        $this->dropTable('{{stadium}}');
    }
}