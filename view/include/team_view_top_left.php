<?php
/**
 * @var $auth_user_id integer
 * @var $num_get integer
 * @var $team_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        <?= $team_array[0]['team_name']; ?>
        (<?= $team_array[0]['city_name']; ?>, <?= $team_array[0]['country_name']; ?>)
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
        Дивизон:
        <?php if ($team_array[0]['division_id']) { ?>
            <a href="/championship.php?country_id=<?= $team_array[0]['country_id']; ?>&division_id=<?= $team_array[0]['division_id']; ?>">
                <?= $team_array[0]['country_name']; ?>,
                <?= $team_array[0]['division_name']; ?>,
                <?= $team_array[0]['championship_place']; ?> место
            </a>
        <?php } else { ?>
            <a href="/conference_table.php">
                Конференция, <?= $team_array[0]['conference_place']; ?> место
            </a>
        <?php } ?>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Менежер:
        <?php if (isset($auth_user_id) && $team_array[0]['user_id'] && $team_array[0]['user_id'] != $auth_user_id) { ?>
            <a href="/dialog.php?num=<?= $team_array[0]['user_id']; ?>">
                <img src="/img/letter.png" title="Написать письмо" />
            </a>
        <?php } ?>
        <a class="strong" href="/user_view.php?num=<?= $team_array[0]['user_id']; ?>">
            <?php if ($team_array[0]['user_name'] || $team_array[0]['user_surname']) { ?>
                <?= $team_array[0]['user_name']; ?> <?= $team_array[0]['user_surname']; ?>
            <?php } else { ?>
                Новый менеджер
            <?php } ?>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Ник:
        <?php if ($team_array[0]['user_date_vip'] > time()) { ?>
            <img src="/img/vip.png" title="VIP" />
        <?php } ?>
        <a class="strong" href="/user_view.php?num=<?= $team_array[0]['user_id']; ?>">
            <?= $team_array[0]['user_login']; ?>
        </a>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Стадион:
        <?= $team_array[0]['stadium_name']; ?>,
        <strong><?= $team_array[0]['stadium_capacity']; ?></strong>
        <?php if ($team_array[0]['count_buildingstadium']) { ?>
            <img alt="Идет строительство стадиона" src="/img/cog.png" title="Идет строительство стадиона" />
        <?php } ?>
        <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
            <a href="/stadium_increase.php?num=<?= $num_get; ?>">
                <img alt="Подробнее" src="/img/loupe.png"/>
            </a>
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        База: <span class="strong"><?= $team_array[0]['base_level']; ?></span> уровень
        (<span class="strong"><?= $team_array[0]['base_slot_used']; ?></span>
        из
        <span class="strong"><?= $team_array[0]['base_slot_max']; ?></span> слотов)
        <?php if ($team_array[0]['count_buildingbase']) { ?>
            <img alt="Идет строительство базы команды" src="/img/cog.png" title="Идет строительство базы команды" />
        <?php } ?>
        <a href="/base.php?num=<?= $num_get; ?>">
            <img alt="Подробнее" src="/img/loupe.png"/>
        </a>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Финансы:
        <span class="strong"><?= f_igosja_money_format($team_array[0]['team_finance']); ?></span>
    </div>
</div>