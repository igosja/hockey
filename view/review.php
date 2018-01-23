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
            <?= $review_array[0]['review_title']; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-center">
            <?= $review_array[0]['country_name']; ?>, <?= $review_array[0]['division_name']; ?>, <?= $review_array[0]['stage_id']; ?>, <?= $review_array[0]['review_season_id']; ?> сезон
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            <?= nl2br($review_array[0]['review_text']); ?>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p>
            <?= f_igosja_ufu_date_time($review_array[0]['review_date']); ?>,
            <a href="/user_view.php?num=<?= $review_array[0]['user_id']; ?>">
                <?= $review_array[0]['user_login']; ?>
            </a>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center margin-top">
        <a href="/championship.php?country_id=<?= $review_array[0]['country_id']; ?>&division_id=<?= $review_array[0]['division_id']; ?>&season_id=<?= $review_array[0]['review_season_id']; ?>&stage_id=<?= $review_array[0]['stage_id']; ?>">
            Назад
        </a>
    </div>
</div>