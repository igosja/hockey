<?php
/**
 * @var $count_team integer
 * @var $season_array array
 * @var $season_id integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Кубок межсезонья
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p class="text-center">
            <span class="strong">Кубок межсезонья</span> - это турнир, который проводится в самом начале сезона.
            <br/>
            Всего в Кубке межсезонья в этом сезоне <span class="strong"><?= $count_team; ?></span>
            <?= f_igosja_count_case($count_team, 'участник', 'участника', 'участника'); ?>.
        </p>
        <p class="text-center">
            <a href="/offseason_table.php">Турнирная таблица</a>
            |
            <a href="/offseason_statistic.php">Статистика</a>
        </p>
        <p class="text-justify">
            Турнир играется по швейцарской системе, когда для каждого тура сводятся в пары команды одного ранга
            (расположенные достаточно близко друг от друга в турнирной таблице, но так, чтобы не нарушались принципы турнира).
        </p>
        <p class="text-justify">
            В матчах турнира есть домашний бонус - в родных стенах команды играют сильнее.
        </p>
        <p class="text-justify">
            Каждая команда имеет право сыграть 2 матча на супере и 2 матча на отдыхе во время розыгрыша кубка межсезонья.
        </p>
        <p class="text-justify">
            В кубке межсезонья участники не могут встречаться между собой дважды и сводятся в пары,
            имеющие ближайшие места в турнирной таблице, но такие,
            которые могут играть между собой в соответствии с принципами жеребьёвки:
        </p>
        <ul class="text-left">
            <li>две команды не могут играть между собой более одного матча;</li>
            <li>ни одна из команд не может сыграть более половины матчей турнира дома или в гостях.</li>
        </ul>
    </div>
</div>