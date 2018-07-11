<?php

use common\components\ErrorHelper;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;

/**
 * @var integer $complaint
 * @var integer $countModeration
 * @var integer $forumMessage
 * @var integer $freeTeam
 * @var integer $gameComment
 * @var integer $loanComment
 * @var integer $logo
 * @var integer $news
 * @var integer $newsComment
 * @var \common\models\Payment[] $paymentArray
 * @var array $paymentData
 * @var array $paymentCategories
 * @var integer $review
 * @var integer $support
 * @var \yii\web\View $this
 * @var integer $transferComment
 * @var integer $vote
 */

?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title); ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-dribbble fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-freeteam"><?= $freeTeam; ?></div>
                        <div>Free teams</div>
                    </div>
                </div>
            </div>
            <?= Html::a(
                '<div class="panel-footer">
                    <span class="pull-left">Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>',
                ['team/index']
            ); ?>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-logo"
         <?php if (0 == $logo) : ?>style="display:none;"<?php endif; ?>>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shield fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-logo"><?= $logo; ?></div>
                        <div>Logos</div>
                    </div>
                </div>
            </div>
            <?= Html::a(
                '<div class="panel-footer">
                    <span class="pull-left">Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>',
                ['logo/index']
            ); ?>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-support"
         <?php if (0 == $support) : ?>style="display:none;"<?php endif; ?>>
        <div class="panel panel-red panel-support">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-support"><?= $support; ?></div>
                        <div>Support</div>
                    </div>
                </div>
            </div>
            <?= Html::a(
                '<div class="panel-footer">
                    <span class="pull-left">Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>',
                ['support/index']
            ); ?>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-complain"
         <?php if (0 == $complaint) : ?>style="display:none;"<?php endif; ?>>
        <div class="panel panel-red panel-complain">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-exclamation-circle fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-complain"><?= $complaint; ?></div>
                        <div>Complaints</div>
                    </div>
                </div>
            </div>
            <?= Html::a(
                '<div class="panel-footer">
                    <span class="pull-left">Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>',
                ['complaint/index']
            ); ?>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 panel-vote"
         <?php if (0 == $vote) : ?>style="display:none;"<?php endif; ?>>
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-bar-chart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge admin-vote"><?= $vote; ?></div>
                        <div>Polls</div>
                    </div>
                </div>
            </div>
            <?= Html::a(
                '<div class="panel-footer">
                    <span class="pull-left">Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>',
                ['vote/index']
            ); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> Payments
            </div>
            <div class="panel-body">
                <?php

                try {
                    print Highcharts::widget([
                        'options' => [
                            'credits' => ['enabled' => false],
                            'legend' => ['enabled' => false],
                            'series' => [
                                ['name' => 'Payments', 'data' => $paymentData],
                            ],
                            'title' => ['text' => 'Payments'],
                            'xAxis' => [
                                'categories' => $paymentCategories,
                                'title' => ['text' => 'Month'],
                            ],
                            'yAxis' => [
                                'title' => ['text' => 'Amount'],
                            ],
                        ]
                    ]);
                } catch (Exception $e) {
                    ErrorHelper::log($e);
                }

                ?>
                <div id="chart-payment"></div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped table-condensed">
                        <tr>
                            <th>Time</th>
                            <th>Amount</th>
                            <th>User</th>
                        </tr>
                        <?php foreach ($paymentArray as $item) : ?>
                            <tr>
                                <td>
                                    <?php

                                    try {
                                        Yii::$app->formatter->asDatetime($item->payment_date);
                                    } catch (Exception $e) {
                                        ErrorHelper::log($e);
                                    }

                                    ?>
                                </td>
                                <td>
                                    <?php

                                    try {
                                        Yii::$app->formatter->asCurrency(
                                            $item->payment_sum,
                                            Yii::$app->params['currency']
                                        );
                                    } catch (Exception $e) {
                                        ErrorHelper::log($e);
                                    }

                                    ?>
                                </td>
                                <td>
                                    <?= Html::a(
                                        $item->user->user_login,
                                        ['user/view', 'id' => $item->payment_user_id],
                                        ['target' => '_blank']
                                    ) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-bar-chart-o fa-fw"></i> To moderation (<?= $countModeration; ?>)
            </div>
            <div class="panel-body">
                <div class="list-group">
                    <?= Html::a(
                        'Forum messages <span class="pull-right text-muted small"><em>'
                        . $forumMessage
                        . '</em></span>',
                        ['moderation/forum-message'],
                        ['class' => 'list-group-item']
                    ); ?>
                    <?= Html::a(
                        'Game comments <span class="pull-right text-muted small"><em>'
                        . $gameComment
                        . '</em></span>',
                        ['moderation/game-comment'],
                        ['class' => 'list-group-item']
                    ); ?>
                    <?= Html::a(
                        'News <span class="pull-right text-muted small"><em>'
                        . $news
                        . '</em></span>',
                        ['moderation/news'],
                        ['class' => 'list-group-item']
                    ); ?>
                    <?= Html::a(
                        'News comments <span class="pull-right text-muted small"><em>'
                        . $newsComment
                        . '</em></span>',
                        ['moderation/news-comment'],
                        ['class' => 'list-group-item']
                    ); ?>
                    <?= Html::a(
                        'Loans comments <span class="pull-right text-muted small"><em>'
                        . $loanComment
                        . '</em></span>',
                        ['moderation/loan-comment'],
                        ['class' => 'list-group-item']
                    ); ?>
                    <?= Html::a(
                        'Transfers comments <span class="pull-right text-muted small"><em>'
                        . $transferComment
                        . '</em></span>',
                        ['moderation/transfer-comment'],
                        ['class' => 'list-group-item']
                    ); ?>
                    <?= Html::a(
                        'Reviews <span class="pull-right text-muted small"><em>'
                        . $review
                        . '</em></span>',
                        ['moderation/review'],
                        ['class' => 'list-group-item']
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</div>