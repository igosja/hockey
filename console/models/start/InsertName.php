<?php

namespace console\models\start;

use common\components\ErrorHelper;
use common\models\Country;
use common\models\Name;
use common\models\NameCountry;
use Yii;
use yii\db\Exception;

/**
 * Class InsertName
 * @package console\models\start
 */
class InsertName
{
    /**
     * @throws Exception
     * @return void
     */
    public function execute(): void
    {
        $cheName = [
            'Адам',
            'Давид',
            'Даниель',
            'Доминик',
            'Зденек',
            'Иаков',
            'Иржи',
            'Йозеф',
            'Карел',
            'Карл',
            'Ладислав',
            'Лукаш',
            'Майкл',
            'Марек',
            'Мартин',
            'Матей',
            'Милан',
            'Мирослав',
            'Михал',
            'Ондржей',
            'Павел',
            'Петр',
            'Питер',
            'Пол',
            'Томас',
            'Филипп',
            'Франтишек',
            'Шимон',
            'Штепан',
            'Якуб',
            'Ян',
            'Ярослав',
        ];
        $engName = [
            'Адам',
            'Алекс',
            'Альберт',
            'Артур',
            'Арчи',
            'Бенджамин',
            'Блейк',
            'Бобби',
            'Гарри',
            'Генри',
            'Даниэль',
            'Декстер',
            'Джейден',
            'Джейк',
            'Джейкоб',
            'Джейми',
            'Джеймс',
            'Джек',
            'Дженсон',
            'Джозеф',
            'Джордж',
            'Джошуа',
            'Джуд',
            'Дилан',
            'Дэвид',
            'Итан',
            'Кай',
            'Каллум',
            'Коннор',
            'Кэмерон',
            'Лео',
            'Леон',
            'Логан',
            'Луис',
            'Лукас',
            'Льюис',
            'Люк',
            'Майкл',
            'Макс',
            'Мейсон',
            'Мэтью',
            'Натан',
            'Оливер',
            'Олли',
            'Оскар',
            'Остин',
            'Оуэн',
            'Райан',
            'Райли',
            'Роберт',
            'Ронни',
            'Рубен',
            'Себастьян',
            'Сонни',
            'Стэнли',
            'Тайлер',
            'Тедди',
            'Тео',
            'Теодор',
            'Тоби',
            'Томас',
            'Томми',
            'Уильям',
            'Феликс',
            'Финли',
            'Фредди',
            'Фредерик',
            'Фрэнки',
            'Харви',
            'Харли',
            'Харрисон',
            'Хьюго',
            'Чарльз',
            'Эван',
            'Эдвард',
            'Эйден',
            'Элайджа',
            'Эллиот',
        ];
        $finName = [
            'Антеро',
            'Антти',
            'Ильмари',
            'Йоханнес',
            'Калеви',
            'Кари',
            'Матиас',
            'Матти',
            'Микаэль',
            'Олави',
            'Оливер',
            'Онни',
            'Пекка',
            'Пентти',
            'Тапани',
            'Тапио',
            'Тимо',
            'Хейкки',
            'Элиас',
            'Эркки',
            'Ээмели',
            'Юхани',
        ];
        $gerName = [
            'Александр',
            'Андреас',
            'Берд',
            'Вальтер',
            'Вацлав',
            'Вернер',
            'Владимир',
            'Вольфганг',
            'Ганс',
            'Гельмут',
            'Герхард',
            'Горст',
            'Гюнтер',
            'Джон',
            'Дитер',
            'Йенс',
            'Йорг',
            'Клаус',
            'Кристиан',
            'Манфред',
            'Мартин',
            'Матиас',
            'Михаель',
            'Питер',
            'Рольф',
            'Свен',
            'Стефан',
            'Томас',
            'Торстен',
            'Уве',
            'Франк',
            'Хайнс',
            'Юрген',
        ];
        $norName = [
            'Александр',
            'Арне',
            'Бйорн',
            'Йонас',
            'Кнут',
            'Кристиан',
            'Кьелл',
            'Ларс',
            'Лукас',
            'Магнус',
            'Маркус',
            'Матиас',
            'Оле',
            'Оливер',
            'Свейн',
            'Тобиас',
            'Томас',
            'Уильям',
            'Филип',
            'Эмиль',
            'Ян',
        ];
        $rusName = [
            'Александр',
            'Алексей',
            'Анатолий',
            'Андрей',
            'Антон',
            'Арсений',
            'Артём',
            'Артур',
            'Богдан',
            'Вадим',
            'Валерий',
            'Василий',
            'Виктор',
            'Виталий',
            'Владимир',
            'Владислав',
            'Вячеслав',
            'Георгий',
            'Глеб',
            'Григорий',
            'Даниил',
            'Денис',
            'Дмитрий',
            'Евгений',
            'Егор',
            'Иван',
            'Игорь',
            'Илья',
            'Кирилл',
            'Константин',
            'Максим',
            'Матвей',
            'Михаил',
            'Никита',
            'Николай',
            'Олег',
            'Павел',
            'Пётр',
            'Роман',
            'Руслан',
            'Святослав',
            'Семён',
            'Сергей',
            'Станислав',
            'Степан',
            'Тимофей',
            'Тимур',
            'Фёдор',
            'Юрий',
            'Ярослав',
        ];
        $sweName = [
            'Александр',
            'Андерс',
            'Андреас',
            'Бенгт',
            'Бу',
            'Гуннар',
            'Густав',
            'Даниель',
            'Йоран',
            'Карл',
            'Кристер',
            'Ларс',
            'Леннарт',
            'Магнус',
            'Мартин',
            'Микаель',
            'Нильс',
            'Оке',
            'Оскар',
            'Пер',
            'Петер',
            'Свен',
            'Стефан',
            'Томас',
            'Улоф',
            'Фредрик',
            'Ханс',
            'Эрик',
            'Юхан',
            'Ян',
        ];

        $nameArray = [
            [
                'country' => 'Канада',
                'list' => $engName,
            ],
            [
                'country' => 'Россия',
                'list' => $rusName,
            ],
            [
                'country' => 'США',
                'list' => $engName,
            ],
            [
                'country' => 'Финляндия',
                'list' => $finName,
            ],
            [
                'country' => 'Швеция',
                'list' => $sweName,
            ],
            [
                'country' => 'Чехия',
                'list' => $cheName,
            ],
            [
                'country' => 'Швейцария',
                'list' => $gerName,
            ],
            [
                'country' => 'Словакия',
                'list' => $cheName,
            ],
            [
                'country' => 'Белоруссия',
                'list' => $rusName,
            ],
            [
                'country' => 'Германия',
                'list' => $gerName,
            ],
            [
                'country' => 'Норвегия',
                'list' => $norName,
            ],
            [
                'country' => 'Украина',
                'list' => $rusName,
            ],
        ];

        $data = [];
        foreach ($nameArray as $country) {
            $countryId = Country::find()
                ->select(['country_id'])
                ->where(['country_name' => $country['country']])
                ->limit(1)
                ->scalar();

            $nameCountryList = Name::find()
                ->where(['name_name' => $country['list']])
                ->indexBy(['name_name'])
                ->all();
            foreach ($country['list'] as $item) {
                if (isset($nameCountryList[$item])) {
                    $data[] = [$countryId, $nameCountryList[$item]->name_id];
                    continue;
                }

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $name = new Name();
                    $name->name_name = $item;
                    if (!$name->save()) {
                        throw new Exception(ErrorHelper::modelErrorsToString($name));
                    }
                    $transaction->commit();
                    $data[] = [$countryId, $name->name_id];
                } catch (Exception $e) {
                    $transaction->rollBack();
                    ErrorHelper::log($e);
                }
            }
        }

        Yii::$app->db
            ->createCommand()
            ->batchInsert(
                NameCountry::tableName(),
                ['name_country_country_id', 'name_country_name_id'],
                $data
            )
            ->execute();
    }
}
