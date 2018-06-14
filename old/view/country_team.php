<?php
/**
 * @var $team_array array
 * @var $team_sql mysqli_result
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        Всего команд: <?= $team_sql->num_rows; ?>
        <table class="table table-bordered table-hover">
            <tr>
                <th>Команда</th>
                <th class="col-40">Менеджер</th>
                <th class="col-20 hidden-xs">Последний визит</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr <?php if (isset ($auth_team_id) && $auth_team_id == $item['team_id']) { ?>class="info"<?php } ?>>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            <span class="hidden-xs">(<?= $item['city_name']; ?>)</span>
                        </a>
                    </td>
                    <td class="text-center">
                        <?= f_igosja_user_vip($item['user_date_vip']); ?>
                        <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    </td>
                    <td class="hidden-xs text-center"><?= f_igosja_ufu_last_visit($item['user_date_login']); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Команда</th>
                <th>Менеджер</th>
                <th class="hidden-xs">Последний визит</th>
            </tr>
        </table>
    </div>
</div>
<div class="row hidden-lg hidden-md hidden-sm">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <a class="btn show-full-table" href="javascript:">
            Показать полную таблицу
        </a>
    </div>
</div>