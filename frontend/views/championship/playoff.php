<?php

use common\models\Stage;
use yii\helpers\Html;

/**
 * @var array $divisionArray
 * @var int $divisionId
 * @var array $playoffArray
 * @var array $reviewArray
 * @var bool $reviewCreate
 * @var array $roundArray
 * @var array $scheduleId
 * @var array $seasonArray
 * @var int $seasonId
 */

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            <?= Html::a(
                $country->country_name,
                ['country/news', 'id' => $country->country_id],
                ['class' => 'country-header-link']
            ); ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//championship/_division-links', ['divisionArray' => $divisionArray]); ?>
    </div>
</div>
<?= Html::beginForm(['championship/index'], 'get'); ?>
<?= Html::hiddenInput('divisionId', $divisionId); ?>
<?= Html::hiddenInput('countryId', $country->country_id); ?>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <p class="text-justify">
            Чемпионаты стран - это основные турниры в Лиге.
            В каждой из стран, где зарегистрированы 16 или более клубов, проводятся национальные чемпионаты.
            Все команды, которые были созданы на момент старта очередных чемпионатов, принимают в них участие.
            Национальные чемпионаты проводятся один раз в сезон.
        </p>
        <p>
            В одном национальном чемпионате может быть несколько дивизионов, в зависимости от числа команд в стране.
            Победители низших дивизионов получают право в следующем сезоне играть в более высоком дивизионе.
            Проигравшие вылетают в более низкий дивизион.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= $this->render('//championship/_round-links', ['roundArray' => $roundArray]); ?>
    </div>
</div>
<?php foreach ($playoffArray as $round) : ?>
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
                        <td class="text-right col-35 <?php if (Stage::FINAL_GAME == $round['stage']->stage_id) : ?>col-30-sm<?php endif; ?>">
                            <?= $participant['home']->teamLink('string', true); ?>
                        </td>
                        <td class="text-center col-30 <?php if (Stage::FINAL_GAME == $round['stage']->stage_id) : ?>col-40-sm<?php endif; ?>">
                            <?= implode(' | ', $participant['game']); ?>
                        </td>
                        <td>
                            <?= $participant['guest']->teamLink('string', true); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
<?php endforeach; ?>
<?php if ($reviewArray) : ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong margin-top text-center">
            Обзоры:
        </div>
    </div>
    <?php foreach ($reviewArray as $review) : ?>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-1"></div>
            <div class="col-lg-9 col-md-9 col-sm-10 col-xs-11">
                <?= $review->stage->stage_name; ?> -
                <?= Html::a($review->review_title, ['review/view', 'id' => $review->review_id]); ?>
                -
                <?= $review->user->userLink(); ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>
            <?= Html::a(
                'Статистика',
                [
                    'championship/statistics',
                    'countryId' => $country->country_id,
                    'divisionId' => $divisionId,
                    'roundId' => 2,
                    'seasonId' => $seasonId,
                ],
                ['class' => 'btn margin']
            ); ?>
            <?php if ($reviewCreate && false) : ?>
                <?= Html::a(
                    'Написать обзор',
                    [
                        'review/create',
                        'countryId' => $country->country_id,
                        'divisionId' => $divisionId,
                        'scheduleId' => $scheduleId,
                        'seasonId' => $seasonId,
                    ],
                    ['class' => 'btn margin']
                ); ?>
            <?php endif; ?>
        </p>
    </div>
</div>