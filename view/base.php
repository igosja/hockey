<?php
/**
 * @var $auth_team_id integer
 * @var $building_id integer
 * @var $buildingbase_array array
 * @var $buildingbase_day string
 * @var $cancel_get integer
 * @var $cancel_price integer
 * @var $constructiontype_id integer
 * @var $count_buildingbase integer
 * @var $del_base boolean
 * @var $del_medical boolean
 * @var $del_phisical boolean
 * @var $del_school boolean
 * @var $del_scout boolean
 * @var $del_training boolean
 * @var $img_base string
 * @var $img_medical string
 * @var $img_phisical string
 * @var $img_school string
 * @var $img_scout string
 * @var $img_training string
 * @var $link_base_array array
 * @var $link_training_array array
 * @var $link_medical_array array
 * @var $link_phisical_array array
 * @var $link_school_array array
 * @var $link_scout_array array
 * @var $num_get integer
 * @var $phisical_available integer
 * @var $school_available integer
 * @var $scout_available integer
 * @var $training_available_position integer
 * @var $training_available_power integer
 * @var $training_available_special integer
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right"></div>
</div>
<?php if (isset($cancel_price)) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            Вы собираетесь отменить строительство здания.
            <?php if ($cancel_price > 0) { ?>
                Компенсансация за отмену строительства составит <span class="strong"><?= f_igosja_money_format($cancel_price); ?></span>.
            <?php } else { ?>
                Оплата за отмену строительства составит <span class="strong"><?= f_igosja_money_format(-$cancel_price); ?></span>.
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <a href="/base.php?cancel=<?= $cancel_get; ?>&ok=1" class="btn margin">Отменить строительство</a>
            <a href="/base.php" class="btn margin">Вернуться</a>
        </div>
    </div>
<?php } else { ?>
    <?php if ($count_buildingbase) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
                На базе сейчас идет строительство.
                Дата окончания строительства - <?= $buildingbase_day; ?>
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
    <?php } else { ?>
        <div class="row margin-top">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <fieldset>
                    <legend class="strong text-center">База команды</legend>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-5 col-xs-6 text-center">
                            <img
                                alt="База команды"
                                class="img-border img-base"
                                src="<?= $img_base; ?>"
                            />
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_base) { ?> del<?php } ?>">
                                    Уровень: <span class="strong"><?= $base_array[0]['base_level']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_base) { ?> del<?php } ?>">
                                    Стоимость: <span class="strong"><?= f_igosja_money_format($base_array[0]['base_price_buy']); ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_base) { ?> del<?php } ?>">
                                    Слотов: <span class="strong"><?= $base_array[0]['base_slot_min']; ?>-<?= $base_array[0]['base_slot_max']; ?></span>
                                </div>
                            </div>
                            <div class="row margin-top">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_base) { ?> del<?php } ?>">
                                    Занято слотов: <span class="strong"><?= $base_array[0]['base_slot_used']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_base) { ?> del<?php } ?>">
                                    Содержание: <span class="strong"><?= f_igosja_money_format($base_array[0]['base_maintenance']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($link_base_array) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php foreach ($link_base_array as $item) { ?>
                                    <a href="<?= $item['href']; ?>" class="btn margin"><?= $item['text']; ?></a>
                                <?php } ?>
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
                            <img
                                alt="Тренировочный центр"
                                class="img-border img-base"
                                src="<?= $img_training; ?>"
                            />
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_training) { ?> del<?php } ?>">
                                    Уровень: <span class="strong"><?= $base_array[0]['basetraining_level']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_training) { ?> del<?php } ?>">
                                    Доступно:
                                    <span class="strong"><?= $base_array[0]['basetraining_power_count']; ?></span> бал.
                                    |
                                    <span class="strong"><?= $base_array[0]['basetraining_special_count']; ?></span> спец.
                                    |
                                    <span class="strong"><?= $base_array[0]['basetraining_position_count']; ?></span> поз.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_training) { ?> del<?php } ?>">
                                    Скорость:
                                    <span class="strong"><?= $base_array[0]['basetraining_training_speed_min']; ?>-<?= $base_array[0]['basetraining_training_speed_max']; ?>%</span>
                                </div>
                            </div>
                            <div class="row margin-top">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_training) { ?> del<?php } ?>">
                                    Осталось:
                                    <span class="strong"><?= $training_available_power; ?></span> бал.
                                    |
                                    <span class="strong"><?= $training_available_special; ?></span> спец.
                                    |
                                    <span class="strong"><?= $training_available_position; ?></span> поз.
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($link_training_array) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php foreach ($link_training_array as $item) { ?>
                                    <a href="<?= $item['href']; ?>" class="btn margin"><?= $item['text']; ?></a>
                                <?php } ?>
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
                            <img
                                alt="Медцентр"
                                class="img-border img-base"
                                src="<?= $img_medical; ?>"
                            />
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_medical) { ?> del<?php } ?>">
                                    Уровень: <span class="strong"><?= $base_array[0]['basemedical_level']; ?></span>
                                </div>
                            </div>
                            <div class="row margin-top">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_medical) { ?> del<?php } ?>">
                                    Базовая усталость: <span class="strong"><?= $base_array[0]['basemedical_tire']; ?>%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($link_medical_array) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php foreach ($link_medical_array as $item) { ?>
                                    <a href="<?= $item['href']; ?>" class="btn margin"><?= $item['text']; ?></a>
                                <?php } ?>
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
                            <img
                                alt="Центр физподготовки"
                                class="img-border img-base"
                                src="<?= $img_phisical; ?>"
                            />
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_phisical) { ?> del<?php } ?>">
                                    Уровень: <span class="strong"><?= $base_array[0]['basephisical_level']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_phisical) { ?> del<?php } ?>">
                                    Изменений формы: <span class="strong"><?= $base_array[0]['basephisical_change_count']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_phisical) { ?> del<?php } ?>">
                                    Увеличение усталости: <span class="strong"><?= $base_array[0]['basephisical_tire_bonus']; ?>%</span>
                                </div>
                            </div>
                            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                                <div class="row margin-top">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_phisical) { ?> del<?php } ?>">
                                        Осталось изменений: <span class="strong"><?= $phisical_available; ?></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_phisical) { ?> del<?php } ?>">
                                        Запланировано: <span class="strong"><?= $phisical_plan_array[0]['count']; ?></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if ($link_phisical_array) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php foreach ($link_phisical_array as $item) { ?>
                                    <a href="<?= $item['href']; ?>" class="btn margin"><?= $item['text']; ?></a>
                                <?php } ?>
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
                            <img
                                alt="Спортшкола"
                                class="img-border img-base"
                                src="<?= $img_school; ?>"
                            />
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_school) { ?> del<?php } ?>">
                                    Уровень: <span class="strong"><?= $base_array[0]['baseschool_level']; ?></span>
                                </div>
                            </div>
                            <div class="row margin-top">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_school) { ?> del<?php } ?>">
                                    Молодежь: <span class="strong"><?= $base_array[0]['baseschool_player_count']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_school) { ?> del<?php } ?>">
                                    Осталось игроков: <span class="strong"><?= $school_available; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($link_school_array) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php foreach ($link_school_array as $item) { ?>
                                    <a href="<?= $item['href']; ?>" class="btn margin"><?= $item['text']; ?></a>
                                <?php } ?>
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
                            <img
                                alt="Скаут-центр"
                                class="img-border img-base"
                                src="<?= $img_scout; ?>"
                            />
                        </div>
                        <div class="col-lg-9 col-md-8 col-sm-7 col-xs-6">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_scout) { ?> del<?php } ?>">
                                    Уровень: <span class="strong"><?= $base_array[0]['basescout_level']; ?></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_scout) { ?> del<?php } ?>">
                                    Доступно изучений стилей:
                                    <span class="strong"><?= $base_array[0]['basescout_my_style_count']; ?></span>
                                </div>
                            </div>
                            <div class="row margin-top">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12<?php if ($del_scout) { ?> del<?php } ?>">
                                    Осталось изучений стилей:
                                    <span class="strong"><?= $scout_available; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if ($link_scout_array) { ?>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <?php foreach ($link_scout_array as $item) { ?>
                                    <a href="<?= $item['href']; ?>" class="btn margin"><?= $item['text']; ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </fieldset>
            </div>
        </div>
    <?php } ?>
<?php } ?>