<?php
/**
 * @var $country_array array
 * @var $country_id integer
 * @var $division_id integer
 * @var $review_array array
 * @var $review_create boolean
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
            <a href="/country_news.php?num=<?= $country_id; ?>" class="country-header-link">
                <?= $country_array[0]['country_name']; ?>
            </a>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/championship_table_link.php'); ?>
    </div>
</div>
<form method="GET">
    <input name="country_id" type="hidden" value="<?= $country_id; ?>">
    <input name="division_id" type="hidden" value="<?= $division_id; ?>">
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
            Чемпионаты стран - это основные турниры в Лиге.
            В каждой из стран, где зарегистрированы 16 или более клубов, проводятся национальные чемпионаты.
            Все команды, которые были созданы на момент старта очередных чемпионатов, принимают в них участие.
            Национальные чемпионаты проводятся один раз в сезон.
        </p>
        <p>
            В одном национальном чемпионате может быть от двух до четырех дивизионов, в зависимости от числа команд в стране.
            Победители низших дивизионов получают право в следующем сезоне играть в более высоком дивизионе.
            Проигравшие вылетают в более низкий дивизион.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/championship_table_round_link.php'); ?>
    </div>
</div>
<?php if (ROUND_SEASON == $round_id) { ?>
    <?php include(__DIR__ . '/include/championship_season.php'); ?>
<?php } else { ?>
    <?php include(__DIR__ . '/include/championship_playoff.php'); ?>
<?php } ?>
<?php if ($review_array) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong margin-top text-center">
            Обзоры:
        </div>
    </div>
    <?php foreach ($review_array as $item) { ?>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-1"></div>
            <div class="col-lg-9 col-md-9 col-sm-10 col-xs-11">
                <?= $item['stage_name']; ?> -
                <a href="/review_view.php?num=<?= $item['review_id']; ?>">
                    <?= $item['review_title']; ?>
                </a>
                -
                <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                    <?= $item['user_login']; ?>
                </a>
            </div>
        </div>
    <?php } ?>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <a href="/championship_statistic.php?country_id=<?= $country_id; ?>&division_id=<?= $division_id; ?>&season_id=<?= $season_id; ?>&round_id=<?= $round_id; ?>" class="btn">
                Статистика
            </a>
            <?php if ($review_create) { ?>
                <a href="/review_create.php?country_id=<?= $country_id; ?>&division_id=<?= $division_id; ?>&season_id=<?= $season_id; ?>&stage_id=<?= $stage_id; ?>&schedule_id=<?= $schedule_id; ?>" class="btn">
                    Написать обзор
                </a>
            <?php } ?>
        </p>
    </div>
</div>