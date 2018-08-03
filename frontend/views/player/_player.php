<?php

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
        'name' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['name_id', 'name_name']);
        },
        'surname' => function (ActiveQuery $query): ActiveQuery {
            return $query->select(['surname_id', 'surname_name']);
        },
    ])
    ->select([
        'player_name_id',
        'player_squad_id',
        'player_surname_id',
        'player_team_id',
    ])
    ->where(['player_id' => $playerId])
    ->one();

if ('view' == $context->action->id && $context->myTeam && $context->myTeam->team_id == $player->player_team_id) {
    $squadArray = Squad::find()->all();
}

?>
    <div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-size-1 strong">
                <?= $player->name->name_name; ?> <?= $player->surname->surname_name . $this->context->action->id; ?>
            </div>
            <?php if (isset($squadArray)): ?>
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
                                ['class' => 'form-control', 'id' => 'select-squad']
                            ); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php if (false) { ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 margin-top">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Национальность:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <img
                                alt="<?= $player_array[0]['country_name']; ?>"
                                src="/img/country/12/<?= $player_array[0]['country_id']; ?>.png"
                        />
                        <a href="/country_news.php?num=<?= $player_array[0]['country_id']; ?>">
                            <?= $player_array[0]['country_name']; ?>
                        </a>
                        <?php if (0 != $player_array[0]['player_national_id']) { ?>
                            <img
                                    alt="Игрок сборной"
                                    src="/img/national.png"
                                    title="Игрок сборной"
                            />
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Возраст:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= $player_array[0]['player_age']; ?>
                        <?php if (39 == $player_array[0]['player_age']) { ?>
                            <img
                                    alt="Завершает карьеру в конце сезона"
                                    src="/img/palm.png"
                                    title="Завершает карьеру в конце сезона"
                            />
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Сила:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= $player_array[0]['player_power_nominal']; ?>
                        <?php if (in_array(1,
                            array($player_array[0]['player_rent_on'], $player_array[0]['player_transfer_on']))) { ?>
                            <img
                                    alt="Выставлен на трансфер/аренду"
                                    src="/img/market.png"
                                    title="Выставлен на трансфер/аренду"
                            />
                        <?php } ?>
                        <?= f_igosja_player_on_training($num_get, $training_array); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Усталость:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if (isset($auth_team_id) && $auth_team_id == $player_array[0]['team_id']) { ?>
                            <?= $player_array[0]['player_tire']; ?>%
                        <?php } else { ?>
                            ?
                        <?php } ?>
                        <?php if (1 == $player_array[0]['player_injury']) { ?>
                            <img
                                    alt="Травмирован на <?= $player_array[0]['player_injury_day']; ?> <?= f_igosja_count_case($player_array[0]['player_injury_day'],
                                        'день', 'дня', 'дней'); ?>"
                                    src="/img/injury.png"
                                    title="Травмирован на <?= $player_array[0]['player_injury_day']; ?> <?= f_igosja_count_case($player_array[0]['player_injury_day'],
                                        'день', 'дня', 'дней'); ?>"
                            />
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Форма на сегодня:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if (isset($auth_team_id) && $auth_team_id == $player_array[0]['team_id']) { ?>
                            <img
                                    alt="<?= $player_array[0]['phisical_name']; ?>"
                                    src="/img/phisical/<?= $player_array[0]['phisical_id']; ?>.png"
                                    title="<?= $player_array[0]['phisical_name']; ?>"
                            />
                        <?php } else { ?>
                            ?
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Реальная сила:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?php if (isset($auth_team_id) && $auth_team_id == $player_array[0]['team_id']) { ?>
                            <?= $player_array[0]['player_power_real']; ?>
                        <?php } else { ?>
                            ~<?= $player_array[0]['player_power_nominal']; ?>
                        <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Стиль:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= $style_img; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Команда:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <a href="/team_view.php?num=<?= $player_array[0]['team_id']; ?>">
                            <?= $player_array[0]['team_name']; ?>
                        </a>
                    </div>
                </div>
                <?php if ($player_array[0]['rent_team_id']) { ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            В аренде:
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <a href="/team_view.php?num=<?= $player_array[0]['rent_team_id']; ?>">
                                <?= $player_array[0]['rent_team_name']; ?>
                            </a>
                            (<?= $player_array[0]['player_rent_day']; ?>)
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Позиция:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= f_igosja_player_position($player_array[0]['player_id'], $playerposition_array); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Спецвозможности:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= f_igosja_player_special($player_array[0]['player_id'], $playerspecial_array); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Зарплата за тур:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= f_igosja_money_format($player_array[0]['player_salary']); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        Стоимость:
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= f_igosja_money_format($player_array[0]['player_price']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php } ?>