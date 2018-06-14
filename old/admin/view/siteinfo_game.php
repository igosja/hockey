<?php
/**
 * @var $game_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Игровая статистика за неделю</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    Показатель
                </th>
                <th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    Результат сайта
                </th>
                <th>
                    НХЛ
                </th>
            </tr>
            <tr>
                <td>
                    Средняя результативность
                </td>
                <td>
                    <?= $game_array[0]['score']; ?>
                </td>
                <td>
                    6
                </td>
            </tr>
            <tr>
                <td>
                    Среднее количество бросков
                </td>
                <td>
                    <?= $game_array[0]['shot']; ?>
                </td>
                <td>
                    60
                </td>
            </tr>
            <tr>
                <td>
                    Среднее количество штрафов
                </td>
                <td>
                    <?= $game_array[0]['penalty']; ?>
                </td>
                <td>
                    10
                </td>
            </tr>
        </table>
    </div>
</div>