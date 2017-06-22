<?php
/**
 * @var $shedule_array array
 * @var $team_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                <?= $team_array[0]['team_name']; ?>
                (<?= $team_array[0]['city_name']; ?>, <?= $team_array[0]['country_name']; ?>)
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="/friendlystatus.php">
                    <?= $team_array[0]['friendlystatus_name']; ?>
                </a>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-right text-size-1">
                Организация товарищеских матчей
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-right">
                <?= f_igosja_ufu_date_time($shedule_array[0]['shedule_date']); ?>
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Ближайшие дни товарищеских матчей:
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th class="col-20">День</th>
                <th>Статус</th>
            </tr>
            <?php foreach ($shedule_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <a href="friendly.php?num=<?= $item['shedule_id']; ?>">
                            <?= f_igosja_ufu_date_time($item['shedule_date']); ?>
                        </a>
                    </td>
                    <td></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Отправленные приглашения на выбранный день:
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Менеджер</th>
                <th title="Рейтинг силы команды">Vs</th>
                <th title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                <th>Стадион</th>
                <th title="Рейтинг посещаемости">РП</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Менеджер</th>
                <th title="Рейтинг силы команды">Vs</th>
                <th title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                <th>Стадион</th>
                <th title="Рейтинг посещаемости">РП</th>
            </tr>
        </table>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Полученные приглашения на выбранный день:
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Менеджер</th>
                <th title="Рейтинг силы команды">Vs</th>
                <th title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                <th>Стадион</th>
                <th title="Рейтинг посещаемости">РП</th>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Менеджер</th>
                <th title="Рейтинг силы команды">Vs</th>
                <th title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                <th>Стадион</th>
                <th title="Рейтинг посещаемости">РП</th>
            </tr>
        </table>
    </div>
</div>