<?php

/**
 * @var \common\models\AchievementPlayer[] $achievementArray
 * @var \yii\web\View $this
 */

print $this->render('_player');
print $this->render('_links');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-5" title="Season">S</th>
                <th>Team</th>
                <th>Tournament</th>
                <th class="col-10">Position</th>
            </tr>
            <?php foreach ($achievementArray as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item->achievement_player_season_id; ?></td>
                    <td><?= $item->achievement_player_team_id; ?></td>
                    <td><?= $item->achievement_player_tournament_type_id; ?></td>
                    <td class="text-center"><?= $item->achievement_player_stage_id; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Season">S</th>
                <th>Team</th>
                <th>Tournament</th>
                <th class="col-10">Position</th>
            </tr>
        </table>
    </div>
</div>
<?= $this->render('_links'); ?>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Show full table
        </a>
    </div>
</div>