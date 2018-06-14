<?php
/**
 * @var $auth_team_id array
 * @var $auth_team_vice_id array
 * @var $auth_user_id array
 * @var $latest_array array
 * @var $nearest_array array
 * @var $num_get integer
 * @var $rosterphrase_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
        - <?= $rosterphrase_array[0]['rosterphrase_text']; ?> -
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (isset($auth_user_id)) { ?>
            <?php if ($auth_team_id == $num_get) { ?>
                <a class="no-underline" href="/friendly.php">
                    <img alt="Организовать товарищеский матч" src="/img/roster/friendly.png" title="Организовать товарищеский матч"/>
                </a>
                <a class="no-underline" href="/training.php">
                    <img alt="Тренировка хоккеистов" src="/img/roster/training.png" title="Тренировка хоккеистов"/>
                </a>
                <a class="no-underline" href="/scout.php">
                    <img alt="Изучение хоккеистов" src="/img/roster/scout.png" title="Изучение хоккеистов"/>
                </a>
                <a class="no-underline" href="/phisical.php">
                    <img alt="Изменение физической формы" src="/img/roster/phisical.png" title="Изменение физической формы"/>
                </a>
                <a class="no-underline" href="/school.php">
                    <img alt="Подготовка молодёжи" src="/img/roster/school.png" title="Подготовка молодёжи"/>
                </a>
            <?php } ?>
            <?php if (0 == $team_array[0]['user_id']) { ?>
                <a class="no-underline" href="/team_change.php?num=<?= $num_get; ?>">
                    <img alt="Подать заявку на получение команды" src="/img/roster/freeteam.png" title="Подать заявку на получение команды" />
                </a>
            <?php } ?>
            <a class="no-underline" href="/user_questionnaire.php">
                <img alt="Личные данные" src="/img/roster/questionnaire.png" title="Личные данные" />
            </a>
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
            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                <?= $item['team_name']; ?>
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
            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                <?= $item['team_name']; ?>
            </a>
            -
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get || isset($auth_team_vice_id) && $auth_team_vice_id == $num_get) { ?>
                <a href="/game_send.php?num=<?= $item['game_id']; ?>">
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