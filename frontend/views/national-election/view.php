<?php

/**
 * @var \common\models\ElectionPresident $electionPresident
 */

print $this->render('//country/_country');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Выборы тренера национальной сборной</h1>
            </div>
        </div>
        <div class="row border-top">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $electionPresident->electionStatus->election_status_name; ?>
            </div>
        </div>
        <?php foreach ($electionPresident->applications() as $application) : ?>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <?= $application['user']; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                    <?= $application['count']; ?>
                    (<?= $application['percent']; ?>%)
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
