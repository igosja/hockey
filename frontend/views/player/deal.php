<?php

/**
 * @var \common\models\Loan[] $loanArray
 * @var \common\models\Transfer[] $transferArray
 * @var \yii\web\View $this
 */

print $this->render('_player');
print $this->render('_links');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <p class="text-center">Transfers:</p>
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-5" title="Season">S</th>
                <th>Position</th>
                <th>Age</th>
                <th>Power</th>
                <th>Special</th>
                <th>From</th>
                <th>To</th>
                <th>Price</th>
            </tr>
            <?php foreach ($transferArray as $item) { ?>
                <tr>
                </tr>
            <?php } ?>
            <tr>
                <th title="Season">S</th>
                <th>Position</th>
                <th>Age</th>
                <th>Power</th>
                <th>Special</th>
                <th>From</th>
                <th>To</th>
                <th>Price</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <p class="text-center">Loans:</p>
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-5" title="Season">S</th>
                <th>Position</th>
                <th>Age</th>
                <th>Power</th>
                <th>Special</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Price</th>
            </tr>
            <?php foreach ($loanArray as $item) { ?>
                <tr>
                </tr>
            <?php } ?>
            <tr>
                <th title="Season">S</th>
                <th>Position</th>
                <th>Age</th>
                <th>Power</th>
                <th>Special</th>
                <th>From</th>
                <th>To</th>
                <th>Days</th>
                <th>Price</th>
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