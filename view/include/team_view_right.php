<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 italic">
        - Уезжая надолго и без интернета - не забудьте поставить статус "в отпуске" -
        <br/>
        - Пригласите друзей в Лигу и получите вознаграждение -
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
        <img src="http://virtualsoccer.ru/menu/new/squad_big.gif"/>
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
            <a href="/game_send.php?num=<?= $item['game_id']; ?>">
                Отпр.
            </a>
        </div>
    <?php } ?>
</div>