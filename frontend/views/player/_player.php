<?php

use common\components\ErrorHelper;
use common\models\Player;
use common\models\Squad;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * @var \frontend\controllers\BaseController $context
 * @var \yii\web\View $this
 */

$context = $this->context;

$playerId = Yii::$app->request->get('id');

$player = Player::find()
    ->with([
        'country' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['country_id', 'country_name']);
        },
        'loanTeam' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['team_id', 'team_name']);
        },
        'name' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['name_id', 'name_name']);
        },
        'physical' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['physical_id', 'physical_name']);
        },
        'playerPosition' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['player_position_player_id', 'player_position_position_id']);
        },
        'playerPosition.position' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['position_id', 'position_name']);
        },
        'playerSpecial' => function (ActiveQuery $query): ActiveQuery {
            return $query->select([
                'player_special_level',
                'player_special_player_id',
                'player_special_special_id',
            ]);
        },
        'playerSpecial.special' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['special_id', 'special_name']);
        },
        'style' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['style_id', 'style_name']);
        },
        'surname' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['surname_id', 'surname_name']);
        },
        'team' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['team_id', 'team_name']);
        },
    ])
    ->select([
        'player_age',
        'player_country_id',
        'player_id',
        'player_injury_day',
        'player_loan_day',
        'player_loan_on',
        'player_loan_team_id',
        'player_name_id',
        'player_national_id',
        'player_physical_id',
        'player_power_nominal',
        'player_power_real',
        'player_price',
        'player_salary',
        'player_squad_id',
        'player_style_id',
        'player_surname_id',
        'player_team_id',
        'player_tire',
        'player_transfer_on',
    ])
    ->where(['player_id' => $playerId])
    ->one();

$myPlayer = false;

if ('view' == $context->action->id && $context->myTeam && $context->myTeam->team_id == $player->player_team_id) {
    $myPlayer = true;
    $squadArray = Squad::find()->all();
    $squardStyle = [];
    foreach ($squadArray as $item) {
        $squardStyle[$item->squad_id] = ['style' => ['background-color' => '#' . $item->squad_color]];
    }
}

?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-size-1 strong">
                <?= $player->name->name_name; ?> <?= $player->surname->surname_name; ?>
            </div>
            <?php if (isset($squadArray)): ?>
                <?php if ($myPlayer): ?>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                <label for="select-line">Squad:</label>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                <?= Html::dropDownList(
                                    'squad_id',
                                    $player->player_squad_id,
                                    ArrayHelper::map($squadArray, 'squad_id', 'squad_name'),
                                    [
                                        'class' => 'form-control',
                                        'data' => ['player' => $player->player_id],
                                        'id' => 'select-squad',
                                        'options' => $squardStyle,
                                    ]
                                ); ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Nationality:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= Html::a(
                            Html::img(
                                '/img/country/12/' . $player->country->country_id . '.png',
                                [
                                    'alt' => $player->country->country_name,
                                    'title' => $player->country->country_name,
                                ]
                            ),
                            ['country/team', 'id' => $player->country->country_id]
                        ); ?>
                        <?= Html::a(
                            $player->country->country_name,
                            ['country/team', 'id' => $player->country->country_id]
                        ); ?>
                        <?= $player->iconNational(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Age:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= $player->player_age; ?>
                        <?= $player->iconPension(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Power:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= $player->player_power_nominal; ?>
                        <?= $player->iconDeal(); ?>
                        <?= $player->iconTraining(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Tiredness:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if ($myPlayer) : ?>
                            <?= $player->player_tire; ?>%
                        <?php else: ?>
                            ?
                        <?php endif; ?>
                        <?= $player->iconInjury(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Physical form:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if ($myPlayer) : ?>
                            <?= Html::img(
                                '/img/physical/' . $player->physical->physical_id . '.png',
                                [
                                    'alt' => $player->physical->physical_name,
                                    'title' => $player->physical->physical_name,
                                ]
                            ); ?>
                        <?php else: ?>
                            ?
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Real power:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if ($myPlayer) : ?>
                            <?= $player->player_power_real; ?>
                        <?php else: ?>
                            ~<?= $player->player_power_nominal; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Style:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= Html::img(
                            '/img/style/' . $player->style->style_id . '.png',
                            [
                                'alt' => $player->style->style_name,
                                'title' => $player->style->style_name,
                            ]
                        ); ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Team:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= Html::a(
                            $player->team->team_name,
                            ['team/view', 'id' => $player->team->team_id]
                        ); ?>
                    </div>
                </div>
                <?php if ($player->loanTeam->team_id) { ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            On loan:
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <?= Html::a(
                                $player->loanTeam->team_name,
                                ['team/view', 'id' => $player->loanTeam->team_id]
                            ); ?>
                            (<?= $player->player_loan_day; ?>)
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Position:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= $player->position(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Special abilities:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= $player->special(); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Salary per day:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php

                        try {
                            print Yii::$app->formatter->asCurrency($player->player_salary, 'USD');
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        };

                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Price:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php

                        try {
                            print Yii::$app->formatter->asCurrency($player->player_price, 'USD');
                        } catch (Exception $e) {
                            ErrorHelper::log($e);
                        };

                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>