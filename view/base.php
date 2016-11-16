<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                <?= $team_array[0]['team_name']; ?>
                (<?= $team_array[0]['city_name']; ?>, <?= $team_array[0]['country_name']; ?>)
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Кубок межсезонья: <a href="javascript:;">12345 место</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Дивизон: <a href="javascript:;">Страна, Дивизион, 12 место</a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Менежер:
                (Письмо) <a class="strong" href="javascript:;"><?= $team_array[0]['user_login']; ?></a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник:
                (ВИП)
                <a class="strong" href="javascript:;">
                    <?= $team_array[0]['user_name']; ?> <?= $team_array[0]['user_surname']; ?>
                </a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Заместитель: (Письмо) <a class="strong" href="javascript:;">Имя</a>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Ник: (ВИП) <a class="strong" href="javascript:;">Логин</a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Стадион:
                <?= $team_array[0]['stadium_name']; ?>,
                <strong><?= $team_array[0]['stadium_capacity']; ?></strong>
                <img src="/img/cog.png"/>
                <img src="/img/loupe.png"/>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                База: <span class="strong"><?= $team_array[0]['team_base_id']; ?></span> уровень
                (<span class="italic"><?= $team_array[0]['team_base_slot_used']; ?></span>
                из
                <span class="strong">22</span> слотов)
                <img src="/img/cog.png"/>
                <a href="base.php?num=<?= $num_get; ?>"><img src="/img/loupe.png"/></a>
            </div>
        </div>
        <div class="row text-size-4"><?= SPACE; ?></div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Финансы:
                <span class="strong"><?= f_igosja_money($team_array[0]['team_finance']); ?></span>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                - Уезжая надолго и без интернета - не забудьте поставить статус "в отпуске" -
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
                <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - 3:2
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - 3:2
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="row text-size-4"><?= SPACE; ?></div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - Ред.
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - Отпр.
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
                5 октября, 22:00 - Кубок межсезонья - Д - Команда - Отпр.
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">База команды</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/base.jpg" />
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $base_array[0]['base_level']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Стоимость: <span class="strong">123 456</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Слотов: <span class="strong"><?= $base_array[0]['base_slot_min']; ?>-<?= $base_array[0]['base_slot_max']; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Занято слотов: <span class="strong">1</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Содержание: <span class="strong">4 321</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="javascript:;" class="btn margin">Строить</a>
                    <a href="javascript:;" class="btn margin">Продать</a>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Тренировочный центр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/training.jpg" />
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $base_array[0]['basetraining_level']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Доступно:
                            <span class="strong"><?= $base_array[0]['basetraining_power_count']; ?></span> бал.
                            |
                            <span class="strong"><?= $base_array[0]['basetraining_special_count']; ?></span> спец.
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Скорость:
                            <span class="strong"><?= $base_array[0]['basetraining_training_speed_min']; ?>-<?= $base_array[0]['basetraining_training_speed_max']; ?>%</span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Осталось: <span class="strong">1</span> бал. | <span class="strong">1</span> спец.
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="javascript:;" class="btn margin">Строить</a>
                    <a href="javascript:;" class="btn margin">Продать</a>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Медцентр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/medical.jpg" />
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $base_array[0]['basemedical_level']; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Базовая усталость: <span class="strong"><?= $base_array[0]['basemedical_tire']; ?>%</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="javascript:;" class="btn margin">Строить</a>
                    <a href="javascript:;" class="btn margin">Продать</a>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Центр физподготовки</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/phisical.jpg" />
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $base_array[0]['basephisical_level']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Изменений формы: <span class="strong"><?= $base_array[0]['basephisical_change_count']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Увеличение усталости: <span class="strong"><?= $base_array[0]['basephisical_tire_bobus']; ?>%</span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Осталось изменений: <span class="strong">1</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Запланировано: <span class="strong">1</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="javascript:;" class="btn margin">Строить</a>
                    <a href="javascript:;" class="btn margin">Продать</a>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Спортшкола</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/school.jpg" />
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $base_array[0]['baseschool_level']; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Молодежь: <span class="strong"><?= $base_array[0]['baseschool_player_count']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Задано имен: <span class="strong">0</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="javascript:;" class="btn margin">Строить</a>
                    <a href="javascript:;" class="btn margin">Продать</a>
                </div>
            </div>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Скаут-центр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/scout.jpg" />
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $base_array[0]['basescout_level']; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Осталось изучений стилей:
                            <span class="strong">1</span> из <span class="strong"><?= $base_array[0]['basescout_my_style_count']; ?></span></li>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="javascript:;" class="btn margin">Строить</a>
                    <a href="javascript:;" class="btn margin">Продать</a>
                </div>
            </div>
        </fieldset>
    </div>
</div>