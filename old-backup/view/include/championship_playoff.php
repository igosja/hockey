<?php
/**
 * @var $country_id integer
 * @var $playoff_array array
 */
?>
<?php foreach ($playoff_array as $round) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $round['stage_name']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <?php foreach ($round['participant'] as $participant) { ?>
                    <tr>
                        <td class="text-right col-35 <?php if (STAGE_FINAL == $round['stage_id']) { ?>col-30-sm<?php } ?>">
                            <a <?php if ($round['stage_id'] == $participant['home_stage_id']) { ?>class="font-grey"<?php } ?> href="/team_view.php?num=<?= $participant['home_team_id']; ?>">
                                <?= $participant['home_team_name']; ?>
                                <span class="hidden-xs">(<?= $participant['home_city_name']; ?>)</span>
                            </a>
                        </td>
                        <td class="text-center col-30 <?php if (STAGE_FINAL == $round['stage_id']) { ?>col-40-sm<?php } ?>">
                            <?= implode(' | ', $participant['game']); ?>
                        </td>
                        <td>
                            <a <?php if ($round['stage_id'] == $participant['guest_stage_id']) { ?>class="font-grey"<?php } ?> href="/team_view.php?num=<?= $participant['guest_team_id']; ?>">
                                <?= $participant['guest_team_name']; ?>
                                <span class="hidden-xs">(<?= $participant['guest_city_name']; ?>)</span>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
<?php } ?>