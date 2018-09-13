<?php

/**
 * @var \frontend\controllers\BaseController $context
 * @var \frontend\models\LoanApplicationFrom $modelLoanApplicationFrom
 * @var \frontend\models\LoanApplicationTo $modelLoanApplicationTo
 * @var \frontend\models\LoanFrom $modelLoanFrom
 * @var \frontend\models\LoanTo $modelLoanTo
 * @var bool $myPlayer
 * @var int $onLoan
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
                <th>Player loan</th>
            </tr>
        </table>
    </div>
</div>
<?php if (!$context->myTeam) : ?>
    <?= $this->render('_loan_no_team'); ?>
<?php elseif ($myPlayer) : ?>
    <?php if ($onLoan) : ?>
        <?= $this->render('_loan_from', [
            'model' => $modelLoanFrom,
        ]); ?>
    <?php else: ?>
        <?= $this->render('_loan_to', [
            'model' => $modelLoanTo,
        ]); ?>
    <?php endif; ?>
<?php else: ?>
    <?php if ($onLoan) : ?>
        <?= $this->render('_loan_application', [
            'model' => $modelLoanApplicationTo,
            'modelFrom' => $modelLoanApplicationFrom,
        ]); ?>
    <?php else: ?>
        <?= $this->render('_loan_no'); ?>
    <?php endif; ?>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Player loan</th>
            </tr>
        </table>
    </div>
</div>
<?= $this->render('_links'); ?>
