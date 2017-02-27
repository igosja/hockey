<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
        - <?= $rosterphrase_array[0]['rosterphrase_text']; ?> -
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="no-underline" href="/friendly.php">
            <img src="/img/roster/friendly.png" title="Friendly"/>
        </a>
        <a class="no-underline" href="/training.php">
            <img src="/img/roster/training.png" title="Training"/>
        </a>
        <a class="no-underline" href="/scout.php">
            <img src="/img/roster/scout.png" title="Scout"/>
        </a>
        <a class="no-underline" href="/phisical.php">
            <img src="/img/roster/phisical.png" title="Phisical"/>
        </a>
        <a class="no-underline" href="/school.php">
            <img src="/img/roster/school.png" title="School"/>
        </a>
    </div>
    <?php foreach ($latest_array as $item) { ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
            <?= f_igosja_ufu_date_time($item['shedule_date']); ?>
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
            <?= f_igosja_ufu_date_time($item['shedule_date']); ?>
            -
            <?= $item['tournamenttype_name']; ?>
            -
            <?= $item['home_guest']; ?>
            -
            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                <?= $item['team_name']; ?>
            </a>
            -
            <?php if (isset($auth_team_id) && $auth_team_id == $num_get) { ?>
                <a href="/game_send.php?num=<?= $item['game_id']; ?>">
                    Отпр.
                </a>
            <?php } else { ?>
                <a href="/game_preview.php?num=<?= $item['game_id']; ?>">
                    ?:?
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>