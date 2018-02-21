<?php
/**
 * @var $achievement_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th title="Сезон" class="col-5">С</th>
                <th>Турнир</th>
                <th class="col-10">Позиция</th>
            </tr>
            <?php foreach ($achievement_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['achievement_season_id']; ?></td>
                    <td><?= f_igosja_achievement_tournament($item); ?></td>
                    <td class="text-center"><?= f_igosja_achievement_position($item); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Сезон" class="col-1">С</th>
                <th>Турнир</th>
                <th>Позиция</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>