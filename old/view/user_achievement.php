<?php
/**
 * @var $achievement_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Достижения
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th title="Сезон" class="col-5">С</th>
                <th>Команда</th>
                <th>Турнир</th>
                <th class="col-10">Позиция</th>
            </tr>
            <?php foreach ($achievement_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['achievement_season_id']; ?></td>
                    <td>
                        <img src="/img/country/12/<?= $item['team_country_id']; ?>.png" title="<?= $item['team_country_name']; ?>"/>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            (<?= $item['city_name']; ?>)
                        </a>
                    </td>
                    <td><?= f_igosja_achievement_tournament($item); ?></td>
                    <td class="text-center"><?= f_igosja_achievement_position($item); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Сезон">С</th>
                <th>Команда</th>
                <th>Турнир</th>
                <th>Позиция</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
    </div>
</div>