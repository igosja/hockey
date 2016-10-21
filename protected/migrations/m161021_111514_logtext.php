<?php

class m161021_111514_logtext extends CDbMigration
{
    public function up()
    {
        $this->createTable('{{logtext}}', array(
            'logtext_id' => 'pk',
            'logtext_name' => 'VARCHAR(255) NOT NULL',
        ));

        $this->insertMultiple('{{logtext}}', array(
            array('logtext_name' => 'Команда {team} зарегистрирована в Лиге'),
            array('logtext_name' => 'Команда {team} перерегистрирована'),
            array('logtext_name' => '{user} принят на работу тренером-менеджером в команду {team}'),
            array('logtext_name' => '{user} покинул пост тренера-менеджера команды {team}'),
            array('logtext_name' => '{user} принят на работу заместителем менеджера в команду {team}'),
            array('logtext_name' => '{user} покинул пост заместителя менеджера команды {team}'),
            array('logtext_name' => '{user} принят на работу тренером-менеджером в сборную {national}'),
            array('logtext_name' => '{user} покинул пост тренера-менеджера сборной {national}'),
            array('logtext_name' => '{user} принят на работу заместителем менеджера в сборную {national}'),
            array('logtext_name' => '{user} покинул пост заместителя менеджера сборной {national}'),
            array('logtext_name' => '{user} избран президентом федерации {country}'),
            array('logtext_name' => '{user} избран заместителем президента федерации {country}'),
            array('logtext_name' => '{user} покинул пост заместителя президента федерации {country}'),
            array('logtext_name' => 'Уровень строения {building} увеличен до {level} уровня'),
            array('logtext_name' => 'Уровень строения {building} уменьшен до {level} уровня'),
            array('logtext_name' => 'Стадион расширен до {capacity} мест'),
            array('logtext_name' => 'Стадион уменьшен до {capacity} мест'),
            array('logtext_name' => 'Произведен обмен любимых стилей игроков'),
            array('logtext_name' => 'Произведен обмен спецвозможностей в команде'),
            array('logtext_name' => 'За 1 место в регулярном чемпионате страны VIP-клуб сроком 3 мес.'),
            array('logtext_name' => 'За 2 место в регулярном чемпионате страны VIP-клуб сроком 2 мес.'),
            array('logtext_name' => 'За 3 место в регулярном чемпионате страны VIP-клуб сроком 1 мес.'),
            array('logtext_name' => 'За победу в плей-офф чемпионата страны VIP-клуб сроком 2 мес.'),
            array('logtext_name' => 'Финалисту плей-офф чемпионата страны VIP-клуб сроком 1 мес.'),
            array('logtext_name' => 'Пришел из спортшколы в команду {team}'),
            array('logtext_name' => 'Объявил об уходе на пенсию'),
            array('logtext_name' => 'Вышел на пенсию'),
            array('logtext_name' => 'Натренировал +1 балл силы на базе'),
            array('logtext_name' => 'Натренировал совмещение {position} на базе'),
            array('logtext_name' => 'Натренировал спецвозможность {special} на базе'),
            array('logtext_name' => 'Получил +1 балл силы по результатам матча {game}'),
            array('logtext_name' => 'Потерял -1 балл силы по результатам матча {game}'),
            array('logtext_name' => 'Получил спецвозможность {special} по результатам чемпионата'),
            array('logtext_name' => 'Натренировал бонусный +1 балл силы на базе'),
            array('logtext_name' => 'Натренировал бонусное совмещение {position} на базе'),
            array('logtext_name' => 'Натренировал бонусную спецвозможность {special} на базе'),
            array('logtext_name' => 'Получил травму на {day} в матче {game}'),
            array('logtext_name' => 'Перешел из команды {team} в команду {team}'),
            array('logtext_name' => 'Перешел из команды {team} в команду {team} в результате обмена'),
            array('logtext_name' => 'Перешел из команды {team} в команду {team} на правах аренды'),
            array('logtext_name' => 'Вернулся в команду {team} из команды {team} по окончании аренды'),
            array('logtext_name' => 'Продан Лиге командой {team}'),
        ));
    }

    public function down()
    {
        $this->dropTable('{{logtext}}');
    }
}