<?php

class m161021_104125_city extends CDbMigration
{
    public function up()
    {
        $this->createTable('city', array(
            'city_id' => 'pk',
            'city_country_id' => 'INT(11) DEFAULT 0',
            'city_name' => 'VARCHAR(255) NOT NULL',
        ));

        $this->createIndex('city_country_id', 'city', 'city_country_id');

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Альметьевск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Балашиха',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Владивосток',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Екатеринбург',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Казань',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Магнитогорск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Москва',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Мытищи',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Нефтекамск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Нижнекамск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Нижний Новгород',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Новокузнецк',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Новосибирск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Омск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Пенза',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Подольск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Санкт-Петербург',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Саратов',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Сочи',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Тольятти',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Тюмень',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Уфа',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Хабаровск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Ханты-Мансийск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Челябинск',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Череповец',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Электросталь',
        ));

        $this->insert('city', array(
            'city_country_id' => 133,
            'city_name' => 'Ярославль',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Анахайм',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Бейкерсфилд',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Бостон',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Буффало',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Вашингтон',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Глендейл',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Гранд-Рапидс',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Даллас',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Де-Мойн',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Денвер',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Детройт',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Кливленд',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Колумбус',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Лос-Анджелес',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Милуоки',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Нью-Йорк',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Ньюарк',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Нэшвилл',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Питтсбург',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Рокфорд',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Роли',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Сан-Хосе',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Санрайз',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Седар Парк',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Сент-Луис',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Сент-Пол',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Стоктон',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Тампа',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Филадельфия',
        ));

        $this->insert('city', array(
            'city_country_id' => 157,
            'city_name' => 'Чикаго',
        ));
    }

    public function down()
    {
        $this->dropTable('city');
    }
}