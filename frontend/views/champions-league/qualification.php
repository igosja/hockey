<?php

use common\models\TournamentType;
use yii\helpers\Html;

/**
 * @var array $qualificationArray
 * @var array $roundArray
 * @var array $scheduleId
 * @var array $seasonArray
 * @var int $seasonId
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Лига Чемпионов
        </h1>
    </div>
</div>
<?= Html::beginForm(['champions-league/qualification'], 'get'); ?>
<div class="row margin-top-small">
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
        <?= Html::label('Сезон', 'seasonId'); ?>
    </div>
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
        <?= Html::dropDownList(
            'seasonId',
            $seasonId,
            $seasonArray,
            ['class' => 'form-control submit-on-change', 'id' => 'seasonId']
        ); ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
</div>
<?= Html::endForm(); ?>
<div class="row">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-center team-logo-div">
        <?= Html::img(
            '/img/tournament_type/' . TournamentType::LEAGUE . '.png?v=' . filemtime(Yii::getAlias('@webroot') . '/img/tournament_type/' . TournamentType::LEAGUE . '.png'),
            [
                'alt' => 'Лига Чемпионов',
                'class' => 'country-logo',
                'title' => 'Лига Чемпионов',
            ]
        ); ?>
    </div>
    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <p class="text-justify">
                    Лига чемпионов - самый престижный клубный турнир Лиги, куда попадают лучшие команды предыдущего сезона.
                    Число мест в розыгрыше от каждой федерации и стартовый этап для каждой команды определяется согласно
                    клубному рейтингу стран.
                    В турнире есть отборочные раунды, групповой двухкруговой турнир, раунды плей-офф и финал.
                </p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//champions-league/_round-links', ['roundArray' => $roundArray]); ?>
    </div>
</div>
<?php foreach ($qualificationArray as $round) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?= $round['stage']->stage_name; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table">
                <?php foreach ($round['participant'] as $participant) : ?>
                    <tr>
                        <td class="text-right col-40">
                            <?= $participant['home']->teamLink('img', true); ?>
                        </td>
                        <td class="text-center col-20">
                            <?= implode(' | ', $participant['game']); ?>
                        </td>
                        <td>
                            <?= $participant['guest']->teamLink('img', true); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endforeach; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= Html::a(
                'Статистика',
                [
                    'champions-league/statistics',
                    'seasonId' => $seasonId,
                ],
                ['class' => 'btn margin']
            ); ?>
        </p>
    </div>
</div>