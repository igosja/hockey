<?php

class m161021_111206_country extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{country}}', array(
            'country_id' => 'pk',
            'country_finance' => 'INT(11) DEFAULT 0',
            'country_name' => 'VARCHAR(255) NOT NULL',
            'country_president_id' => 'INT(11) DEFAULT 0',
        ));

        $this->createIndex('country_president_id', '{{country}}', 'country_president_id');

        $this->insertMultiple('{{country}}', array(
            array('country_name' => 'Австралия'),
            array('country_name' => 'Австрия'),
            array('country_name' => 'Азербайджан'),
            array('country_name' => 'Албания'),
            array('country_name' => 'Алжир'),
            array('country_name' => 'Англия'),
            array('country_name' => 'Ангола'),
            array('country_name' => 'Андорра'),
            array('country_name' => 'Антигуа и Барбуда'),
            array('country_name' => 'Аргентина'),
            array('country_name' => 'Армения'),
            array('country_name' => 'Афганистан'),
            array('country_name' => 'Багамы'),
            array('country_name' => 'Бангладеш'),
            array('country_name' => 'Барбадос'),
            array('country_name' => 'Бахрейн'),
            array('country_name' => 'Белиз'),
            array('country_name' => 'Белоруссия'),
            array('country_name' => 'Бельгия'),
            array('country_name' => 'Бенин'),
            array('country_name' => 'Болгария'),
            array('country_name' => 'Боливия'),
            array('country_name' => 'Босния и Герцеговина'),
            array('country_name' => 'Ботсвана'),
            array('country_name' => 'Бразилия'),
            array('country_name' => 'Бруней'),
            array('country_name' => 'Буркина-Фасо'),
            array('country_name' => 'Бурунди'),
            array('country_name' => 'Бутан'),
            array('country_name' => 'Вануату'),
            array('country_name' => 'Венгрия'),
            array('country_name' => 'Венесуэла'),
            array('country_name' => 'Восточный Тимор'),
            array('country_name' => 'Вьетнам'),
            array('country_name' => 'Габон'),
            array('country_name' => 'Гаити'),
            array('country_name' => 'Гайана'),
            array('country_name' => 'Гамбия'),
            array('country_name' => 'Гана'),
            array('country_name' => 'Гватемала'),
            array('country_name' => 'Гвинея'),
            array('country_name' => 'Гвинея-Бисау'),
            array('country_name' => 'Германия'),
            array('country_name' => 'Гондурас'),
            array('country_name' => 'Гренада'),
            array('country_name' => 'Греция'),
            array('country_name' => 'Грузия'),
            array('country_name' => 'Дания'),
            array('country_name' => 'Джибути'),
            array('country_name' => 'Доминика'),
            array('country_name' => 'Доминиканская Республика'),
            array('country_name' => 'ДР Конго'),
            array('country_name' => 'Египет'),
            array('country_name' => 'Замбия'),
            array('country_name' => 'Зимбабве'),
            array('country_name' => 'Израиль'),
            array('country_name' => 'Индия'),
            array('country_name' => 'Индонезия'),
            array('country_name' => 'Иордания'),
            array('country_name' => 'Ирак'),
            array('country_name' => 'Иран'),
            array('country_name' => 'Ирландия'),
            array('country_name' => 'Исландия'),
            array('country_name' => 'Испания'),
            array('country_name' => 'Италия'),
            array('country_name' => 'Йемен'),
            array('country_name' => 'Кабо-Верде'),
            array('country_name' => 'Казахстан'),
            array('country_name' => 'Камбоджа'),
            array('country_name' => 'Камерун'),
            array('country_name' => 'Канада'),
            array('country_name' => 'Катар'),
            array('country_name' => 'Кения'),
            array('country_name' => 'Кипр'),
            array('country_name' => 'Киргизия'),
            array('country_name' => 'Кирибати'),
            array('country_name' => 'Китай'),
            array('country_name' => 'КНДР'),
            array('country_name' => 'Колумбия'),
            array('country_name' => 'Коморы'),
            array('country_name' => 'Конго'),
            array('country_name' => 'Корея'),
            array('country_name' => 'Коста-Рика'),
            array('country_name' => 'Кот-д’Ивуар'),
            array('country_name' => 'Куба'),
            array('country_name' => 'Кувейт'),
            array('country_name' => 'Лаос'),
            array('country_name' => 'Латвия'),
            array('country_name' => 'Лесото'),
            array('country_name' => 'Либерия'),
            array('country_name' => 'Ливан'),
            array('country_name' => 'Ливия'),
            array('country_name' => 'Литва'),
            array('country_name' => 'Лихтенштейн'),
            array('country_name' => 'Люксембург'),
            array('country_name' => 'Маврикий'),
            array('country_name' => 'Мавритания'),
            array('country_name' => 'Мадагаскар'),
            array('country_name' => 'Македония'),
            array('country_name' => 'Малави'),
            array('country_name' => 'Малайзия'),
            array('country_name' => 'Мали'),
            array('country_name' => 'Мальдивы'),
            array('country_name' => 'Мальта'),
            array('country_name' => 'Марокко'),
            array('country_name' => 'Маршалловы Острова'),
            array('country_name' => 'Мексика'),
            array('country_name' => 'Микронезия'),
            array('country_name' => 'Мозамбик'),
            array('country_name' => 'Молдавия'),
            array('country_name' => 'Монако'),
            array('country_name' => 'Монголия'),
            array('country_name' => 'Мьянма'),
            array('country_name' => 'Намибия'),
            array('country_name' => 'Науру'),
            array('country_name' => 'Непал'),
            array('country_name' => 'Нигер'),
            array('country_name' => 'Нигерия'),
            array('country_name' => 'Нидерланды'),
            array('country_name' => 'Никарагуа'),
            array('country_name' => 'Новая Зеландия'),
            array('country_name' => 'Норвегия'),
            array('country_name' => 'ОАЭ'),
            array('country_name' => 'Оман'),
            array('country_name' => 'Пакистан'),
            array('country_name' => 'Палау'),
            array('country_name' => 'Панама'),
            array('country_name' => 'Папуа Новая Гвинея'),
            array('country_name' => 'Парагвай'),
            array('country_name' => 'Перу'),
            array('country_name' => 'Польша'),
            array('country_name' => 'Португалия'),
            array('country_name' => 'Россия'),
            array('country_name' => 'Руанда'),
            array('country_name' => 'Румыния'),
            array('country_name' => 'Сальвадор'),
            array('country_name' => 'Самоа'),
            array('country_name' => 'Сан-Марино'),
            array('country_name' => 'Сан-Томе и Принсипи'),
            array('country_name' => 'Саудовская Аравия'),
            array('country_name' => 'Свазиленд'),
            array('country_name' => 'Северная Ирландия'),
            array('country_name' => 'Сейшельские Острова'),
            array('country_name' => 'Сенегал'),
            array('country_name' => 'Сент-Винсент и Гренадины'),
            array('country_name' => 'Сент-Китс и Невис'),
            array('country_name' => 'Сент-Люсия'),
            array('country_name' => 'Сербия'),
            array('country_name' => 'Сингапур'),
            array('country_name' => 'Сирия'),
            array('country_name' => 'Словакия'),
            array('country_name' => 'Словения'),
            array('country_name' => 'Соломоновы Острова'),
            array('country_name' => 'Сомали'),
            array('country_name' => 'Судан'),
            array('country_name' => 'Суринам'),
            array('country_name' => 'США'),
            array('country_name' => 'Сьерра-Леоне'),
            array('country_name' => 'Таджикистан'),
            array('country_name' => 'Таиланд'),
            array('country_name' => 'Танзания'),
            array('country_name' => 'Того'),
            array('country_name' => 'Тонга'),
            array('country_name' => 'Тринидад и Тобаго'),
            array('country_name' => 'Тувалу'),
            array('country_name' => 'Тунис'),
            array('country_name' => 'Туркмения'),
            array('country_name' => 'Турция'),
            array('country_name' => 'Уганда'),
            array('country_name' => 'Узбекистан'),
            array('country_name' => 'Украина'),
            array('country_name' => 'Уругвай'),
            array('country_name' => 'Уэльс'),
            array('country_name' => 'Фиджи'),
            array('country_name' => 'Филиппины'),
            array('country_name' => 'Финляндия'),
            array('country_name' => 'Франция'),
            array('country_name' => 'Хорватия'),
            array('country_name' => 'ЦАР'),
            array('country_name' => 'Чад'),
            array('country_name' => 'Черногория'),
            array('country_name' => 'Чехия'),
            array('country_name' => 'Чили'),
            array('country_name' => 'Швейцария'),
            array('country_name' => 'Швеция'),
            array('country_name' => 'Шотландия'),
            array('country_name' => 'Шри-Ланка'),
            array('country_name' => 'Эквадор'),
            array('country_name' => 'Экваториальная Гвинея'),
            array('country_name' => 'Эритрея'),
            array('country_name' => 'Эстония'),
            array('country_name' => 'Эфиопия'),
            array('country_name' => 'ЮАР'),
            array('country_name' => 'Южный Судан'),
            array('country_name' => 'Ямайка'),
            array('country_name' => 'Япония'),
        ));
    }

    public function down()
    {
        $this->dropTable('{{country}}');
    }
}