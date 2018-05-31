<?php
/**
 * @var $round_id integer
 * @var $season_array array
 * @var $season_id integer
 * @var $schedule_id integer
 * @var $stage_id integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Лига Чемпионов
        </h1>
    </div>
</div>
<form method="GET">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="season_id">Сезон:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
            <select class="form-control submit-on-change" name="season_id" id="season_id">
                <?php foreach ($season_array as $item) { ?>
                    <option
                        value="<?= $item['season_id']; ?>"
                        <?php if ($season_id == $item['season_id']) { ?>
                            selected
                        <?php } ?>
                    >
                        <?= $item['season_id']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            Лига чемпионов - самый престижный клубный турнир Лиги, куда попадают лучшие команды предыдущего сезона.
            Число мест в розыгрыше от каждой федерации и стартовый этап для каждой команды определяется согласно клубному рейтингу стран.
            В турнире есть отборочные раунды, групповой двухкруговой турнир, раунды плей-офф и финал.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/league_table_round_link.php'); ?>
    </div>
</div>
<?php if (ROUND_GROUP == $round_id) { ?>
    <?php include(__DIR__ . '/include/league_group.php'); ?>
<?php } else { ?>
    <?php include(__DIR__ . '/include/league_playoff.php'); ?>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <a href="/league_statistic.php?season_id=<?= $season_id; ?>" class="btn">
                Статистика
            </a>
        </p>
    </div>
</div>