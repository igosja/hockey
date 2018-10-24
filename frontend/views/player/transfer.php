<?php

/**
 * @var \frontend\controllers\BaseController $context
 * @var \frontend\models\TransferApplicationFrom $modelTransferApplicationFrom
 * @var \frontend\models\TransferApplicationTo $modelTransferApplicationTo
 * @var \frontend\models\TransferFrom $modelTransferFrom
 * @var \frontend\models\TransferTo $modelTransferTo
 * @var bool $myPlayer
 * @var int $onTransfer
 * @var \common\models\Player $player
 * @var \yii\web\View $this
 */

$context = $this->context;

print $this->render('_player');

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_links'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Трансфер игрока</th>
            </tr>
        </table>
    </div>
</div>
<?php if (!$context->myTeam) : ?>
    <?= $this->render('_transfer_no_team'); ?>
<?php elseif ($myPlayer) : ?>
    <?php if ($onTransfer) : ?>
        <?= $this->render('_transfer_from', [
            'model' => $modelTransferFrom,
        ]); ?>
    <?php else: ?>
        <?= $this->render('_transfer_to', [
            'model' => $modelTransferTo,
        ]); ?>
    <?php endif; ?>
<?php else: ?>
    <?php if ($onTransfer) : ?>
        <?= $this->render('_transfer_application', [
            'model' => $modelTransferApplicationTo,
            'modelFrom' => $modelTransferApplicationFrom,
        ]); ?>
    <?php else: ?>
        <?= $this->render('_transfer_no'); ?>
    <?php endif; ?>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Трансфер игрока</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= $this->render('_links'); ?>
    </div>
</div>
