<?php

use common\components\ErrorHelper;
use common\components\FormatHelper;
use common\models\Game;
use common\models\Physical;
use common\models\Player;
use common\models\TournamentType;
use frontend\assets\LineupAsset;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/**
 * @var int $gk_1_id
 * @var int $gk_2_id
 * @var int $ld_1_id
 * @var int $rd_1_id
 * @var int $lw_1_id
 * @var int $cf_1_id
 * @var int $rw_1_id
 * @var int $ld_2_id
 * @var int $rd_2_id
 * @var int $lw_2_id
 * @var int $cf_2_id
 * @var int $rw_2_id
 * @var int $ld_3_id
 * @var int $rd_3_id
 * @var int $lw_3_id
 * @var int $cf_3_id
 * @var int $rw_3_id
 * @var int $ld_4_id
 * @var int $rd_4_id
 * @var int $lw_4_id
 * @var int $cf_4_id
 * @var int $rw_4_id
 * @var array $cfArray
 * @var \yii\data\ActiveDataProvider $gameDataProvider
 * @var Game $game
 * @var Player[] $gkArray
 * @var Player[] $ldArray
 * @var Player[] $lwArray
 * @var \frontend\models\GameSend $model
 * @var array $moodArray
 * @var bool $isVip
 * @var \yii\data\ActiveDataProvider $playerDataProvider
 * @var Player[] $rdArray
 * @var array $rudenessArray
 * @var Player[] $rwArray
 * @var array $styleArray
 * @var array $tacticArray
 * @var \common\models\Team $team
 * @var \yii\web\View $this
 */

LineupAsset::register($this);

?>
<?php if ($isVip) : ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
            <a href="javascript:" class="link-template-save">Сохранить как...</a>
            |
            <a href="javascript:" class="link-template-load">Загрузить шаблон</a>
        </div>
    </div>
    <div class="row margin-top-small div-template-save" style="display: none;">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php $form = ActiveForm::begin([
                'action' => ['lineup/template-save'],
                'fieldConfig' => [
                    'options' => ['class' => 'row'],
                    'template' =>
                        '<div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">{label}</div>
                    <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">{input}</div>',
                ],
                'id' => 'template-save',
                'options' => ['class' => 'margin-no'],
            ]); ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'name')->textInput(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn margin', 'id' => 'template-save-submit']); ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div
            class="row margin-top div-template-load"
            data-url="<?= Url::to(['lineup/template']); ?>"
            style="display: none;"
    >
    </div>
<?php endif; ?>
<div class="row margin-top">
    <?php

    try {
        $columns = [
            [
                'contentOptions' => ['class' => 'text-center'],
                'label' => 'Дата',
                'value' => function (Game $model) {
                    return FormatHelper::asDatetime($model->schedule->schedule_date);
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footerOptions' => ['class' => 'hidden-xs'],
                'label' => 'Турнир',
                'headerOptions' => ['class' => 'hidden-xs'],
                'value' => function (Game $model) {
                    return $model->schedule->tournamentType->tournament_type_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footerOptions' => ['class' => 'hidden-xs'],
                'label' => 'Стадия',
                'headerOptions' => ['class' => 'hidden-xs'],
                'value' => function (Game $model) {
                    return $model->schedule->stage->stage_name;
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'value' => function (Game $model) use ($team) {
                    return $model->game_home_team_id == $team->team_id ? 'Д' : 'Г';
                }
            ],
            [
                'attribute' => 'opponent',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'label' => '',
                'value' => function (Game $model) use ($team) {
                    if ($model->game_home_team_id == $team->team_id) {
                        return $model->teamGuest->teamLink('sting', true);
                    } else {
                        return $model->teamHome->teamLink('sting', true);
                    }
                }
            ],
            [
                'contentOptions' => ['class' => 'hidden-xs text-center'],
                'footerOptions' => ['class' => 'hidden-xs'],
                'label' => 'C/C',
                'headerOptions' => [
                    'class' => 'hidden-xs',
                    'title' => 'Соотношение сил (чем больше это число, тем сильнее ваш соперник)',
                ],
                'value' => function (Game $model) use ($team) {
                    return round($model->teamHome->team_power_vs / $team->team_power_vs * 100) . '%';
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'label' => '',
                'value' => function (Game $model) {
                    return Html::a(
                        '?',
                        ['game/preview', 'id' => $model->game_id],
                        ['target' => '_blank']
                    );
                }
            ],
            [
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'label' => '',
                'value' => function (Game $model) use ($team) {
                    return Html::a(
                        $model->game_home_team_id == $team->team_id
                            ? ($model->game_home_tactic_id_1 ? '+' : '-')
                            : ($model->game_guest_tactic_id_1 ? '+' : '-'),
                        ['lineup/view', 'id' => $model->game_id]
                    );
                }
            ],
        ];
        print GridView::widget([
            'columns' => $columns,
            'dataProvider' => $gameDataProvider,
            'rowOptions' => function (Game $model) {
                if ($model->game_id == Yii::$app->request->get('id')) {
                    return ['class' => 'info'];
                }
                return [];
            },
            'summary' => false,
        ]);
    } catch (Exception $e) {
        ErrorHelper::log($e);
    }

    ?>
</div>
<?= $this->render('//site/_show-full-table'); ?>
<?php $form = ActiveForm::begin([
    'id' => 'lineup-send',
    'options' => ['class' => 'margin-no game-form', 'data-url' => Url::to(['lineup/teamwork', 'id' => $game->game_id])],
]); ?>
<div class="row margin-top">
    <?= $form
        ->field($model, 'ticket', [
            'template' => '<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 text-right strong">
                        {label}
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-2 col-xs-4 text-center">
                        {input}
                        </div>'
        ])
        ->textInput(['class' => 'form-control', 'disabled' => !$model->home])
        ->label('Билет, $'); ?>
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-4" style="height: 20px">
        [<?= Html::a('Зрители', ['visitor/view', 'id' => $game->game_id], ['target' => '_blank']); ?>]
    </div>
    <?= $form
        ->field($model, 'mood', [
            'template' => ' <div class="col-lg-3 col-md-3 col-sm-3 col-xs-4 text-right strong">
                            {label}
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-8">
                            {input}
                            </div>'
        ])
        ->dropDownList($moodArray, ['class' => 'form-control'])
        ->label('Настрой'); ?>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <tr>
                <td></td>
                <td class="col-30 text-center strong">Тактика</td>
                <td class="col-30 text-center strong">Грубость</td>
                <td class="col-30 text-center strong">Стиль</td>
            </tr>
            <tr>
                <td class="text-right strong">1 звено:</td>
                <td>
                    <?= $form->field($model, 'tactic_1')
                        ->dropDownList($tacticArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'rudeness_1')
                        ->dropDownList($rudenessArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'style_1')
                        ->dropDownList($styleArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
            </tr>
            <tr>
                <td class="text-right strong">2 звено:</td>
                <td>
                    <?= $form->field($model, 'tactic_2')
                        ->dropDownList($tacticArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'rudeness_2')
                        ->dropDownList($rudenessArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'style_2')
                        ->dropDownList($styleArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
            </tr>
            <tr>
                <td class="text-right strong">3 звено:</td>
                <td>
                    <?= $form->field($model, 'tactic_3')
                        ->dropDownList($tacticArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'rudeness_3')
                        ->dropDownList($rudenessArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'style_3')
                        ->dropDownList($styleArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
            </tr>
            <tr>
                <td class="text-right strong">4 звено:</td>
                <td>
                    <?= $form->field($model, 'tactic_4')
                        ->dropDownList($tacticArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'rudeness_4')
                        ->dropDownList($rudenessArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
                <td>
                    <?= $form->field($model, 'style_4')
                        ->dropDownList($styleArray, ['class' => 'form-control'])
                        ->label(false); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
                Сила состава: <span class="strong span-power">0</span>
                <br/>
                Оптимальность позиций: <span class="strong span-position-percent">0</span>%
                <br/>
                Оптимальность состава: <span class="strong span-lineup-percent">0</span>%
                <br/>
                Сыгранность:
                <span class="strong span-teamwork-1">0</span>%
                |
                <span class="strong span-teamwork-2">0</span>%
                |
                <span class="strong span-teamwork-3">0</span>%
                |
                <span class="strong span-teamwork-4">0</span>%
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                Вратари:
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $form
                    ->field($model, 'line[0][0]')
                    ->dropDownList([], [
                        'class' => 'form-control lineup-change player-change',
                        'data' => [
                            'line' => 0,
                            'position' => 0,
                        ],
                        'id' => 'line-0-0',
                    ])
                    ->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $form
                    ->field($model, 'line[1][0]')
                    ->dropDownList([], [
                        'class' => 'form-control lineup-change player-change',
                        'data' => [
                            'line' => 1,
                            'position' => 0,
                        ],
                        'id' => 'line-1-0',
                    ])
                    ->label(false); ?>
            </div>
        </div>
        <?php for ($i = 1; $i <= 4; $i++) : ?>
            <?php
            if (1 == $i) {
                $line = 'Первое';
            } elseif (2 == $i) {
                $line = 'Второе';
            } elseif (3 == $i) {
                $line = 'Третье';
            } else {
                $line = 'Четвертое';
            }
            ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    <?= $line; ?> звено:
                </div>
            </div>
            <?php for ($j = 1; $j <= 5; $j++) : ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $form
                            ->field($model, 'line[' . $i . '][' . $j . ']')
                            ->dropDownList([], [
                                'class' => 'form-control lineup-change player-change',
                                'data' => [
                                    'line' => $i,
                                    'position' => $j,
                                ],
                                'id' => 'line-' . $i . '-' . $j,
                            ])
                            ->label(false); ?>
                    </div>
                </div>
            <?php endfor; ?>
        <?php endfor; ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                Капитан:
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $form
                    ->field($model, 'captain')
                    ->dropDownList([], [
                        'class' => 'form-control',
                        'data' => [
                            'id' => $model->captain,
                        ],
                        'id' => 'captain',
                    ])
                    ->label(false); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn margin']); ?>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 table-responsive">
        <?php

        try {
            $columns = [
                [
                    'attribute' => 'squad',
                    'contentOptions' => function (Player $model) {
                        if ($model->squad) {
                            return ['style' => ['background-color' => '#' . $model->squad->squad_color]];
                        }
                        return [];
                    },
                    'footer' => 'Игрок',
                    'format' => 'raw',
                    'label' => 'Игрок',
                    'value' => function (Player $model) {
                        return $model->playerLink(['target' => '_blank'])
                            . $model->iconInjury()
                            . $model->iconNational();
                    }
                ],
                [
                    'attribute' => 'country',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Нац',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Национальность'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'col-1 hidden-xs', 'title' => 'Национальность'],
                    'label' => 'Нац',
                    'value' => function (Player $model) {
                        return $model->country->countryImageLink();
                    }
                ],
                [
                    'attribute' => 'position',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Поз',
                    'footerOptions' => ['title' => 'Позиция'],
                    'headerOptions' => ['title' => 'Позиция'],
                    'label' => 'Поз',
                    'value' => function (Player $model) {
                        return $model->position();
                    }
                ],
                [
                    'attribute' => 'age',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'В',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Возраст'],
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Возраст'],
                    'label' => 'В',
                    'value' => function (Player $model) {
                        return $model->player_age;
                    }
                ],
                [
                    'attribute' => 'power_nominal',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'С',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Сила'],
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Сила'],
                    'label' => 'С',
                    'value' => function (Player $model) {
                        return $model->player_power_nominal;
                    }
                ],
                [
                    'attribute' => TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id ? '' : 'tire',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'У',
                    'footerOptions' => ['title' => 'Усталость'],
                    'headerOptions' => ['title' => 'Усталость'],
                    'label' => 'У',
                    'value' => function (Player $model) use ($game) {
                        return TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id
                            ? '25'
                            : $model->player_tire;
                    }
                ],
                [
                    'attribute' => TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id ? '' : 'physical',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Ф',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Форма'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Форма'],
                    'label' => 'Ф',
                    'value' => function (Player $model) use ($game) {
                        return TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id
                            ? (Physical::findOne(Physical::DEFAULT_ID))->image()
                            : $model->physical->image();
                    }
                ],
                [
                    'attribute' => TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id ? 'power_nominal' : 'power_real',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'РС',
                    'footerOptions' => ['title' => 'Реальная сила'],
                    'headerOptions' => ['title' => 'Реальная сила'],
                    'label' => 'РС',
                    'value' => function (Player $model) use ($game) {
                        return TournamentType::FRIENDLY == $game->schedule->schedule_tournament_type_id
                            ? round($model->player_power_nominal * 0.75)
                            : $model->player_power_real;
                    }
                ],
                [
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'Спец',
                    'footerOptions' => ['title' => 'Спецвозможности'],
                    'headerOptions' => ['title' => 'Спецвозможности'],
                    'label' => 'Спец',
                    'value' => function (Player $model) {
                        return $model->special();
                    }
                ],
                [
                    'attribute' => 'style',
                    'contentOptions' => ['class' => 'hidden-xs text-center'],
                    'footer' => 'Ст',
                    'footerOptions' => ['class' => 'hidden-xs', 'title' => 'Стиль'],
                    'format' => 'raw',
                    'headerOptions' => ['class' => 'hidden-xs', 'title' => 'Стиль'],
                    'label' => 'Ст',
                    'value' => function (Player $model) {
                        return $model->iconStyle(true);
                    }
                ],
                [
                    'attribute' => 'game_row',
                    'contentOptions' => ['class' => 'text-center'],
                    'footer' => 'ИО',
                    'footerOptions' => ['title' => 'Играл/отдыхал подряд'],
                    'headerOptions' => ['title' => 'Играл/отдыхал подряд'],
                    'label' => 'ИО',
                    'value' => function (Player $model) {
                        return $model->player_game_row;
                    }
                ],
            ];
            Pjax::begin();
            print GridView::widget([
                'columns' => $columns,
                'dataProvider' => $playerDataProvider,
                'rowOptions' => function (Player $model) {
                    return [
                        'class' => 'tr-player',
                        'id' => 'tr-' . $model->player_id,
                    ];
                },
                'showFooter' => true,
                'summary' => false,
            ]);
            Pjax::end();
        } catch (Exception $e) {
            ErrorHelper::log($e);
        }

        ?>
    </div>
</div>
<?= $this->render('//site/_show-full-table'); ?>
<?php ActiveForm::end(); ?>
<?php
$scriptBody = '';
for ($j = 0; $j <= 5; $j++) {
    $array = '';
    $fArray = [];

    if (0 == $j) {
        $array = 'gk_array';
        $fArray = $gkArray;
    } elseif (1 == $j) {
        $array = 'ld_array';
        $fArray = $ldArray;
    } elseif (2 == $j) {
        $array = 'rd_array';
        $fArray = $rdArray;
    } elseif (3 == $j) {
        $array = 'lw_array';
        $fArray = $lwArray;
    } elseif (4 == $j) {
        $array = 'cf_array';
        $fArray = $cfArray;
    } elseif (5 == $j) {
        $array = 'rw_array';
        $fArray = $rwArray;
    }

    $scriptBody = $scriptBody . '
        var ' . $array . ' =
        [
        ';
    foreach ($fArray as $item) {
        $scriptBody = $scriptBody . '[
            ' . $item['player_id'] . ',
            \'' . $item->position() . ' - ' .
            $item->player_power_real . ' - ' . $item->playerName() . '\',
            \'#' . (isset($item['squad']) ? $item['squad']['squad_color'] : '') . '\'
            ],';
    }
    $scriptBody = $scriptBody . '];';
}
$scriptBody = $scriptBody . '
    var gk_1_id = ' . $gk_1_id . ';
    var gk_2_id = ' . $gk_2_id . ';
    var ld_1_id = ' . $ld_1_id . ';
    var rd_1_id = ' . $rd_1_id . ';
    var lw_1_id = ' . $lw_1_id . ';
    var cf_1_id = ' . $cf_1_id . ';
    var rw_1_id = ' . $rw_1_id . ';
    var ld_2_id = ' . $ld_2_id . ';
    var rd_2_id = ' . $rd_2_id . ';
    var lw_2_id = ' . $lw_2_id . ';
    var cf_2_id = ' . $cf_2_id . ';
    var rw_2_id = ' . $rw_2_id . ';
    var ld_3_id = ' . $ld_3_id . ';
    var rd_3_id = ' . $rd_3_id . ';
    var lw_3_id = ' . $lw_3_id . ';
    var cf_3_id = ' . $cf_3_id . ';
    var rw_3_id = ' . $rw_3_id . ';
    var ld_4_id = ' . $ld_4_id . ';
    var rd_4_id = ' . $rd_4_id . ';
    var lw_4_id = ' . $lw_4_id . ';
    var cf_4_id = ' . $cf_4_id . ';
    var rw_4_id = ' . $rw_4_id . ';';
$script = <<< JS
    $scriptBody
    $(document).on("ready pjax:end", function() {
        player_change();
    })
JS;
$this->registerJs($script, \yii\web\View::POS_END);
?>
