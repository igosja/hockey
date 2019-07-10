<?php

use coderlex\wysibb\WysiBB;
use common\models\ElectionNationalApplication;
use common\models\Player;
use common\models\Position;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var Player[] $cfArray
 * @var Player[] $gkArray
 * @var Player[] $ldArray
 * @var Player[] $lwArray
 * @var ElectionNationalApplication $model
 * @var Player[] $rdArray
 * @var Player[] $rwArray
 */

print $this->render('//country/_country');

?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h4>Подача заявки на пост тренера сборной</h4>
    </div>
</div>
<?php $form = ActiveForm::begin([
    'fieldConfig' => [
        'errorOptions' => ['class' => 'col-lg-12 col-md-12 col-sm-12 col-xs-12 notification-error'],
        'labelOptions' => ['class' => 'strong'],
        'options' => ['class' => 'row'],
        'template' =>
            '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">{label}</div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">{input}</div>
            {error}',
    ],
]); ?>
<?= $form
    ->field($model, 'election_national_application_text')
    ->widget(WysiBB::class)
    ->label('Ваша программа'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>В заявке обязательно должно быть 32 игрока - 2 вратаря и 30 полевых хоккеистов (по шесть человек на каждую
            позицию).</p>
    </div>
</div>
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
                                'ElectionNationalApplication[player][' . $i . '][]',
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
        <?php if (!$model->isNewRecord) : ?>
            <?= Html::a('Удалить', ['delete-application'], ['class' => 'btn margin']); ?>
        <?php endif; ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
