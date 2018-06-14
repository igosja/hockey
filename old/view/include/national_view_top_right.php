<?php
/**
 * @var $auth_national_id array
 * @var $auth_nationalvice_id array
 * @var $auth_user_id array
 * @var $latest_array array
 * @var $nearest_array array
 * @var $num_get integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (isset($auth_user_id)) { ?>
            <a class="no-underline" href="/national_player.php">
                <img alt="Изменить состав сборной" src="/img/roster/substitute.png" title="Изменить состав сборной"/>
            </a>
            <?php if (($auth_user_id == $national_array[0]['user_id'] && $national_array[0]['vice_user_id']) || $auth_user_id == $national_array[0]['vice_user_id']) { ?>
                <a class="no-underline" href="/national_fire.php">
                    <img alt="Отказаться от должности" src="/img/roster/fire.png" title="Отказаться от должности"/>
                </a>
            <?php } ?>
        <?php } else { ?>
            <a class="no-underline" href="/signup.php">
                <img alt="Зарегистрироваться" src="/img/roster/questionnaire.png" title="Зарегистрироваться" />
            </a>
        <?php } ?>
    </div>
    <?php foreach ($latest_array as $item) { ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
            <?= f_igosja_ufu_date_time($item['schedule_date']); ?>
            -
            <?= $item['tournamenttype_name']; ?>
            -
            <?= $item['home_guest']; ?>
            -
            <a href="/national_view.php?num=<?= $item['national_id']; ?>">
                <?= $item['country_name']; ?>
            </a>
            -
            <a href="/game_view.php?num=<?= $item['game_id']; ?>">
                <?= $item['home_score']; ?>:<?= $item['guest_score']; ?>
            </a>
        </div>
    <?php } ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
    <?php foreach ($nearest_array as $item) { ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
            <?= f_igosja_ufu_date_time($item['schedule_date']); ?>
            -
            <?= $item['tournamenttype_name']; ?>
            -
            <?= $item['home_guest']; ?>
            -
            <a href="/national_view.php?num=<?= $item['national_id']; ?>">
                <?= $item['country_name']; ?>
            </a>
            -
            <?php if (isset($auth_national_id) && in_array($num_get, array($auth_national_id, $auth_nationalvice_id))) { ?>
                <a href="/game_send_national.php?num=<?= $item['game_id']; ?>">
                    <?php if ($item['game_tactic_id']) { ?>Ред.<?php } else { ?>Отпр.<?php } ?>
                </a>
            <?php } else { ?>
                <a href="/game_preview.php?num=<?= $item['game_id']; ?>">
                    ?:?
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>