<?php
/**
 * @var $invite_send_array array
 * @var $myteam_array array
 * @var $num_get integer
 * @var $shedule_array array
 * @var $selected_date integer
 * @var $team_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                <?= $myteam_array[0]['team_name']; ?>
                (<?= $myteam_array[0]['city_name']; ?>, <?= $myteam_array[0]['country_name']; ?>)
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <a href="/friendlystatus.php">
                    <?= $myteam_array[0]['friendlystatus_name']; ?>
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
                <?= f_igosja_ufu_date_time($selected_date); ?>
            </div>
        </div>
    </div>
</div>
<?php if ($shedule_array) { ?>
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
                    <tr <?php if ($num_get == $item['shedule_id']) { ?>class="info"<?php } ?>>
                        <td class="text-center">
                            <a href="friendly.php?num=<?= $item['shedule_id']; ?>">
                                <?= f_igosja_ufu_date_time($item['shedule_date']); ?>
                            </a>
                        </td>
                        <td><?= $item['text']; ?></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <p class="text-center">В ближаещие дни не запланировано товарищеских матчей.</p>
        </div>
    </div>
<?php } ?>
<?php if ($invite_send_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
            Отправленные приглашения на выбранный день:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="col-5"></th>
                    <th>Команда</th>
                    <th class="col-58">Статус</th>
                </tr>
                <?php foreach ($invite_send_array as $item) { ?>
                    <tr>
                        <td></td>
                        <td>
                            <img
                                alt="<?$item['country_name']; ?>"
                                src="/img/country/12/<?= $item['country_id']; ?>.png"
                                title="<?$item['country_name']; ?>"
                            />
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td><?= $item['friendlyinvitestatus_name']; ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th></th>
                    <th>Команда</th>
                    <th>Статус</th>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>
<?php if ($invite_recieve_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
            Полученные приглашения на выбранный день:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="col-5"></th>
                    <th>Команда</th>
                    <?php if (0 == $check_recieve_array[0]['count']) { ?>
                        <th class="col-30">Менеджер</th>
                        <th class="col-6" title="Рейтинг силы команды">Vs</th>
                        <th class="col-6" title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                        <th class="col-10">Стадион</th>
                        <th class="col-6" title="Рейтинг посещаемости">РП</th>
                    <?php } else { ?>
                        <th class="col-58">Статус</th>
                    <?php } ?>
                </tr>
                <?php foreach ($invite_recieve_array as $item) { ?>
                    <tr>
                        <td class="text-center">
                            <?php if (FRIENDLY_INVITE_STATUS_NEW == $item['friendlyinvitestatus_id']) { ?>
                                <a href="/friendly.php?num=<?= $num_get; ?>&friendlyinvite_id=<?= $item['friendlyinvite_id']; ?>&friendlyinivitestatus_id=<?= FRIENDLY_INVITE_STATUS_APPROVE; ?>">
                                    <img src="/img/check.png"/>
                                </a>
                                <a href="/friendly.php?num=<?= $num_get; ?>&friendlyinvite_id=<?= $item['friendlyinvite_id']; ?>&friendlyinivitestatus_id=<?= FRIENDLY_INVITE_STATUS_REJECT; ?>">
                                    <img src="/img/delete.png"/>
                                </a>
                            <?php } ?>
                        </td>
                        <td>
                            <img
                                alt="<?$item['country_name']; ?>"
                                src="/img/country/12/<?= $item['country_id']; ?>.png"
                                title="<?$item['country_name']; ?>"
                            />
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <?php if (FRIENDLY_INVITE_STATUS_NEW == $item['friendlyinvitestatus_id']) { ?>
                            <td>
                                <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']?>
                                </a>
                            </td>
                            <td class="text-center"><?= $item['team_power_vs']; ?></td>
                            <td class="text-center"><?= round($item['team_power_vs'] / $myteam_array[0]['team_power_vs'] * 100); ?>%</td>
                            <td class="text-center"><?= $item['stadium_capacity']; ?></td>
                            <td class="text-center"><?= $item['team_visitor']; ?></td>
                        <?php } else { ?>
                            <td <?php if (0 == $check_recieve_array[0]['count']) { ?>colspan="5"<?php } ?>><?= $item['friendlyinvitestatus_name']; ?></td>
                        <?php } ?>
                    </tr>
                <?php } ?>
                <tr>
                    <th></th>
                    <th>Команда</th>
                    <?php if (0 == $check_recieve_array[0]['count']) { ?>
                        <th>Менеджер</th>
                        <th title="Рейтинг силы команды">Vs</th>
                        <th title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                        <th>Стадион</th>
                        <th title="Рейтинг посещаемости">РП</th>
                    <?php } else { ?>
                        <th>Статус</th>
                    <?php } ?>
                </tr>
            </table>
        </div>
    </div>
<?php } ?>
<?php if ($shedule_array && $team_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
            Отправить приглашение:
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th class="col-5"></th>
                    <th>Команда</th>
                    <th class="col-30">Менеджер</th>
                    <th class="col-6" title="Рейтинг силы команды">Vs</th>
                    <th class="col-6" title="Соотношение сил (чем больше это число, тем сильнее соперник)">С/С</th>
                    <th class="col-10">Стадион</th>
                    <th class="col-6" title="Рейтинг посещаемости">РП</th>
                </tr>
                <?php foreach ($team_array as $item) { ?>
                    <tr<?php if (FRIENDLY_STATUS_ALL == $item['user_friendlystatus_id']) { ?> class="success"<?php } ?>>
                        <td class="text-center">
                            <a href="/friendly.php?num=<?= $num_get; ?>&team_id=<?= $item['team_id']; ?>">
                                <img src="/img/check.png"/>
                            </a>
                        </td>
                        <td>
                            <img
                                alt="<?$item['country_name']; ?>"
                                src="/img/country/12/<?= $item['country_id']; ?>.png"
                                title="<?$item['country_name']; ?>"
                            />
                            <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                            </a>
                        </td>
                        <td>
                            <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                                <?= $item['user_login']?>
                            </a>
                        </td>
                        <td class="text-center"><?= $item['team_power_vs']; ?></td>
                        <td class="text-center"><?= round($item['team_power_vs'] / $myteam_array[0]['team_power_vs'] * 100); ?>%</td>
                        <td class="text-center"><?= $item['stadium_capacity']; ?></td>
                        <td class="text-center"><?= $item['team_visitor']; ?></td>
                    </tr>
                <?php } ?>
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
<?php } ?>