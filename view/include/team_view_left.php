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
        (Письмо)
        <a class="strong" href="/user_view.php?num=<?= $team_array['user_id']; ?>">
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
        (ВИП)
        <a class="strong" href="/user_view.php?num=<?= $team_array['user_id']; ?>">
            <?= $team_array[0]['user_login']; ?>
        </a>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Стадион:
        <?= $team_array[0]['stadium_name']; ?>,
        <strong><?= $team_array[0]['stadium_capacity']; ?></strong>
        <img src="/img/cog.png"/>
        <a href="/stadium_increase.php?num=<?= $num_get; ?>">
            <img src="/img/loupe.png"/>
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        База: <span class="strong"><?= $team_array[0]['base_level']; ?></span> уровень
        (<span class="strong"><?= $team_array[0]['base_slot_used']; ?></span>
        из
        <span class="strong"><?= $team_array[0]['base_slot_max']; ?></span> слотов)
        <img src="/img/cog.png"/>
        <a href="/base.php?num=<?= $num_get; ?>"><img src="/img/loupe.png"/></a>
    </div>
</div>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Финансы:
        <span class="strong"><?= f_igosja_money($team_array[0]['team_finance']); ?></span>
    </div>
</div>