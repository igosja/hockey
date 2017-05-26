<?php
/**
 * @var $building_id integer
 * @var $constructiontype_id integer
 * @var $count_buildingbase integer
 * @var $num_get integer
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"></div>
</div>
<?php if ($count_buildingbase) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
            На базе сейчас идет строительство.
        </div>
    </div>
<?php } ?>
<?php if (isset($base_error)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
            Строить нельзя: <?= $base_error; ?>
        </div>
    </div>
<?php } ?>
<?php if (isset($base_accept)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $base_accept; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/base.php?building_id=<?= $building_id; ?>&constructiontype_id=<?= $constructiontype_id; ?>&ok=1" class="btn margin">Строить</a>
            <a href="/base.php" class="btn margin">Отказаться</a>
        </div>
    </div>
<?php } ?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">База команды</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/base.png" />
                </div>
                <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Уровень: <span class="strong"><?= $base_array[0]['base_level']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Стоимость: <span class="strong"><?= f_igosja_money($base_array[0]['base_price_buy']); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Слотов: <span class="strong"><?= $base_array[0]['base_slot_min']; ?>-<?= $base_array[0]['base_slot_max']; ?></span>
                        </div>
                    </div>
                    <div class="row margin-top">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Занято слотов: <span class="strong"><?= $base_array[0]['base_slot_used']; ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Содержание: <span class="strong"><?= f_igosja_money($base_array[0]['base_maintenance']); ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <a href="/base.php?building_id=<?= BUILDING_BASE; ?>&constructiontype_id=<?= CONSTRUCTION_BUILD; ?>" class="btn margin">Строить</a>
                        <a href="/base.php?building_id=<?= BUILDING_BASE; ?>&constructiontype_id=<?= CONSTRUCTION_DESTROY; ?>" class="btn margin">Продать</a>
                    </div>
                </div>
            <?php } ?>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Тренировочный центр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/training.png" />
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
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <a href="/base.php?building_id=<?= BUILDING_BASETRAINING; ?>&constructiontype_id=<?= CONSTRUCTION_BUILD; ?>" class="btn margin">Строить</a>
                        <a href="/base.php?building_id=<?= BUILDING_BASETRAINING; ?>&constructiontype_id=<?= CONSTRUCTION_DESTROY; ?>" class="btn margin">Продать</a>
                        <a href="/training.php" class="btn margin">Тренировка</a>
                    </div>
                </div>
            <?php } ?>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Медцентр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/medical.png" />
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
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <a href="/base.php?building_id=<?= BUILDING_BASEMEDICAL; ?>&constructiontype_id=<?= CONSTRUCTION_BUILD; ?>" class="btn margin">Строить</a>
                        <a href="/base.php?building_id=<?= BUILDING_BASEMEDICAL; ?>&constructiontype_id=<?= CONSTRUCTION_DESTROY; ?>" class="btn margin">Продать</a>
                    </div>
                </div>
            <?php } ?>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Центр физподготовки</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/phisical.png" />
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
                            Увеличение усталости: <span class="strong"><?= $base_array[0]['basephisical_tire_bonus']; ?>%</span>
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
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <a href="/base.php?building_id=<?= BUILDING_BASEPHISICAL; ?>&constructiontype_id=<?= CONSTRUCTION_BUILD; ?>" class="btn margin">Строить</a>
                        <a href="/base.php?building_id=<?= BUILDING_BASEPHISICAL; ?>&constructiontype_id=<?= CONSTRUCTION_DESTROY; ?>" class="btn margin">Продать</a>
                        <a href="/phisical.php" class="btn margin">Форма</a>
                    </div>
                </div>
            <?php } ?>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Спортшкола</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/school.png" />
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
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <a href="/base.php?building_id=<?= BUILDING_BASESCHOOL; ?>&constructiontype_id=<?= CONSTRUCTION_BUILD; ?>" class="btn margin">Строить</a>
                        <a href="/base.php?building_id=<?= BUILDING_BASESCHOOL; ?>&constructiontype_id=<?= CONSTRUCTION_DESTROY; ?>" class="btn margin">Продать</a>
                        <a href="/school.php" class="btn margin">Молодежь</a>
                    </div>
                </div>
            <?php } ?>
        </fieldset>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <fieldset>
            <legend class="strong text-center">Скаут-центр</legend>
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                    <img class="img-border" src="/img/base/scout.png" />
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
                            <span class="strong">1</span> из <span class="strong"><?= $base_array[0]['basescout_my_style_count']; ?></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <a href="/base.php?building_id=<?= BUILDING_BASESCOUT; ?>&constructiontype_id=<?= CONSTRUCTION_BUILD; ?>" class="btn margin">Строить</a>
                        <a href="/base.php?building_id=<?= BUILDING_BASESCOUT; ?>&constructiontype_id=<?= CONSTRUCTION_DESTROY; ?>" class="btn margin">Продать</a>
                        <a href="/scout.php" class="btn margin">Изучить</a>
                    </div>
                </div>
            <?php } ?>
        </fieldset>
    </div>
</div>