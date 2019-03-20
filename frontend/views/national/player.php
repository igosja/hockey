<?php

use common\models\Position;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var \common\models\Player[] $cfArray
 * @var \common\models\Player[] $gkArray
 * @var \common\models\Player[] $ldArray
 * @var \common\models\Player[] $lwArray
 * @var \frontend\models\NationalPlayer $model
 * @var \common\models\National $national
 * @var \common\models\Player[] $rdArray
 * @var \common\models\Player[] $rwArray
 */

?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $this->render('//national/_national-top-left', ['national' => $national]); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?= $this->render('//national/_national-top-right', ['national' => $national]); ?>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'errorOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center notification-error'],
        'options' => ['class' => 'row'],
        'template' => '{error}',
    ],
]); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>В сборной должно быть 32 игрока - 2 вратаря и 30 полевых хоккеистов (по шесть человек на каждую позицию).</p>
    </div>
</div>
<?= $form->field($model, 'player[]')->error(); ?>
<?php for ($i = Position::GK; $i <= Position::RW; $i++) : ?>
    <?php

    if (Position::GK == $i) {
        $playerArray = $gkArray;
    } elseif (Position::LD == $i) {
        $playerArray = $ldArray;
    } elseif (Position::RD == $i) {
        $playerArray = $rdArray;
    } elseif (Position::LW == $i) {
        $playerArray = $lwArray;
    } elseif (Position::CF == $i) {
        $playerArray = $cfArray;
    } else {
        $playerArray = $rwArray;
    }

    ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="col-5"></th>
                    <th>Игрок</th>
                    <th class="col-5" title="Позиция">Поз</th>
                    <th class="col-5" title="Возраст">В</th>
                    <th class="col-5" title="Номинальная сила">С</th>
                    <th class="col-10 hidden-xs" title="Спецвозможности">Спец</th>
                    <th class="col-40">Команда</th>
                </tr>
                <?php foreach ($playerArray as $item) { ?>
                    <tr>
                        <td class="text-center">
                            <?= Html::checkbox(
                                'NationalPlayer[player][' . $i . '][]',
                                in_array($item->player_id, $model->playerArray),
                                [
                                    'value' => $item->player_id,
                                ]
                            ); ?>
                        </td>
                        <td>
                            <?= $item->playerLink(['target' => '_blank']); ?>
                        </td>
                        <td class="text-center"><?= $item->position(); ?></td>
                        <td class="text-center"><?= $item->player_age; ?></td>
                        <td class="text-center"><?= $item->player_power_nominal; ?></td>
                        <td class="hidden-xs text-center"><?= $item->special(); ?></td>
                        <td>
                            <?= $item->team->teamLink('img'); ?>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                    <th></th>
                    <th>Игрок</th>
                    <th title="Позиция">Поз</th>
                    <th title="Возраст">В</th>
                    <th title="Номинальная сила">С</th>
                    <th class="hidden-xs" title="Спецвозможности">Спец</th>
                    <th>Команда</th>
                </tr>
            </table>
        </div>
    </div>
<?php endfor; ?>
<?= $this->render('//site/_show-full-table'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn margin']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
