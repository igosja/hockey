<?php

use common\components\ErrorHelper;

/**
 * @var \common\models\History[] $eventArray
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
                <th class="col-15">Date</th>
                <th>Event</th>
            </tr>
            <?php foreach ($eventArray as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item->history_season_id; ?></td>
                    <td class="text-center">
                        <?php

                        try {
                            print Yii::$app->formatter->asDate($item->history_date);
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        }

                        ?>
                    </td>
                    <td><?= $item->getText(); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Season">S</th>
                <th>Date</th>
                <th>Event</th>
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