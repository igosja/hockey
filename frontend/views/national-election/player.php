<?php

/**
 * @var ElectionNationalApplication $electionNationalApplication
 */

print $this->render('//country/_country');

use common\models\ElectionNationalApplication; ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h4>Состав тренера сборной</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <p>Кандидат <?= $electionNationalApplication->user->userLink(); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <th>Игрок</th>
                        <th class="col-5" title="Позиция">Поз</th>
                        <th class="col-5" title="Возраст">В</th>
                        <th class="col-5" title="Номинальная сила">С</th>
                        <th class="col-10 hidden-xs" title="Спецвозможности">Спец</th>
                        <th class="col-40">Команда</th>
                    </tr>
                    <?php foreach ($electionNationalApplication->electionNationalPlayer as $electionNationalPlayer) : ?>
                        <tr>
                            <td><?= $electionNationalPlayer->player->playerLink(); ?></td>
                            <td class="text-center"><?= $electionNationalPlayer->player->position(); ?></td>
                            <td class="text-center"><?= $electionNationalPlayer->player->player_age; ?></td>
                            <td class="text-center"><?= $electionNationalPlayer->player->player_power_nominal; ?></td>
                            <td class="hidden-xs text-center"><?= $electionNationalPlayer->player->special(); ?></td>
                            <td><?= $electionNationalPlayer->player->team->teamLink('img'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
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
        <?= $this->render('//site/_show-full-table'); ?>
    </div>
</div>
