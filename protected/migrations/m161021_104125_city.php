<?php

class m161021_104125_city extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{city}}', array(
            'city_id' => 'pk',
            'city_country_id' => 'INT(11) DEFAULT 0',
            'city_name' => 'VARCHAR(255) NOT NULL',
        ));

        $this->createIndex('city_country_id', '{{city}}', 'city_country_id');

        $this->insertMultiple('{{city}}', array(
            array('city_country_id' => 133, 'city_name' => 'Альметьевск'),
            array('city_country_id' => 133, 'city_name' => 'Балашиха'),
            array('city_country_id' => 133, 'city_name' => 'Владивосток'),
            array('city_country_id' => 133, 'city_name' => 'Екатеринбург'),
            array('city_country_id' => 133, 'city_name' => 'Казань'),
            array('city_country_id' => 133, 'city_name' => 'Магнитогорск'),
            array('city_country_id' => 133, 'city_name' => 'Москва'),
            array('city_country_id' => 133, 'city_name' => 'Мытищи'),
            array('city_country_id' => 133, 'city_name' => 'Нефтекамск'),
            array('city_country_id' => 133, 'city_name' => 'Нижнекамск'),
            array('city_country_id' => 133, 'city_name' => 'Нижний Новгород'),
            array('city_country_id' => 133, 'city_name' => 'Новокузнецк'),
            array('city_country_id' => 133, 'city_name' => 'Новосибирск'),
            array('city_country_id' => 133, 'city_name' => 'Омск'),
            array('city_country_id' => 133, 'city_name' => 'Пенза'),
            array('city_country_id' => 133, 'city_name' => 'Подольск'),
            array('city_country_id' => 133, 'city_name' => 'Санкт-Петербург'),
            array('city_country_id' => 133, 'city_name' => 'Саратов'),
            array('city_country_id' => 133, 'city_name' => 'Сочи'),
            array('city_country_id' => 133, 'city_name' => 'Тольятти'),
            array('city_country_id' => 133, 'city_name' => 'Тюмень'),
            array('city_country_id' => 133, 'city_name' => 'Уфа'),
            array('city_country_id' => 133, 'city_name' => 'Хабаровск'),
            array('city_country_id' => 133, 'city_name' => 'Ханты-Мансийск'),
            array('city_country_id' => 133, 'city_name' => 'Челябинск'),
            array('city_country_id' => 133, 'city_name' => 'Череповец'),
            array('city_country_id' => 133, 'city_name' => 'Электросталь'),
            array('city_country_id' => 133, 'city_name' => 'Ярославль'),
        ));

        $this->insertMultiple('{{city}}', array(
            array('city_country_id' => 157, 'city_name' => 'Анахайм'),
            array('city_country_id' => 157, 'city_name' => 'Бейкерсфилд'),
            array('city_country_id' => 157, 'city_name' => 'Бостон'),
            array('city_country_id' => 157, 'city_name' => 'Буффало'),
            array('city_country_id' => 157, 'city_name' => 'Вашингтон'),
            array('city_country_id' => 157, 'city_name' => 'Глендейл'),
            array('city_country_id' => 157, 'city_name' => 'Гранд-Рапидс'),
            array('city_country_id' => 157, 'city_name' => 'Даллас'),
            array('city_country_id' => 157, 'city_name' => 'Де-Мойн'),
            array('city_country_id' => 157, 'city_name' => 'Денвер'),
            array('city_country_id' => 157, 'city_name' => 'Детройт'),
            array('city_country_id' => 157, 'city_name' => 'Кливленд'),
            array('city_country_id' => 157, 'city_name' => 'Колумбус'),
            array('city_country_id' => 157, 'city_name' => 'Лос-Анджелес'),
            array('city_country_id' => 157, 'city_name' => 'Милуоки'),
            array('city_country_id' => 157, 'city_name' => 'Нью-Йорк'),
            array('city_country_id' => 157, 'city_name' => 'Ньюарк'),
            array('city_country_id' => 157, 'city_name' => 'Нэшвилл'),
            array('city_country_id' => 157, 'city_name' => 'Питтсбург'),
            array('city_country_id' => 157, 'city_name' => 'Рокфорд'),
            array('city_country_id' => 157, 'city_name' => 'Роли'),
            array('city_country_id' => 157, 'city_name' => 'Сан-Хосе'),
            array('city_country_id' => 157, 'city_name' => 'Санрайз'),
            array('city_country_id' => 157, 'city_name' => 'Седар Парк'),
            array('city_country_id' => 157, 'city_name' => 'Сент-Луис'),
            array('city_country_id' => 157, 'city_name' => 'Сент-Пол'),
            array('city_country_id' => 157, 'city_name' => 'Стоктон'),
            array('city_country_id' => 157, 'city_name' => 'Тампа'),
            array('city_country_id' => 157, 'city_name' => 'Филадельфия'),
            array('city_country_id' => 157, 'city_name' => 'Чикаго'),
        ));
    }

    public function down()
    {
        $this->dropTable('{{city}}');
    }
}