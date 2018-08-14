<?php

/**
 * @var \frontend\controllers\BaseController $context
 * @var boolean $myPlayer
 * @var integer $onTransfer
 * @var \common\models\Player $player
 * @var \yii\web\View $this
 */

$context = $this->context;

print $this->render('_player');
print $this->render('_links');

?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Player transfer</th>
                </tr>
            </table>
        </div>
    </div>
<?php if (!$context->myTeam) : ?>
    <?= $this->render('_transfer_no_team'); ?>
<?php elseif ($myPlayer) : ?>
    <?php if ($onTransfer) : ?>
        <?= $this->render('_transfer_from'); ?>
    <?php else: ?>
        <?= $this->render('_transfer_to'); ?>
    <?php endif; ?>
<?php else: ?>
    <?php if ($onTransfer) : ?>
        <?= $this->render('_transfer_application'); ?>
    <?php else: ?>
        <?= $this->render('_transfer_no'); ?>
    <?php endif; ?>
<?php endif; ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Player transfer</th>
                </tr>
            </table>
        </div>
    </div>
<?= $this->render('_links'); ?>