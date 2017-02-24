<?php include (__DIR__ . '/include/country_view.php'); ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Команда</th>
                <th class="col-40">Менеджер</th>
                <th class="col-20 hidden-xs">Последний визит</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr <?php if (isset ($auth_team_id) && $auth_team_id == $item['team_id']) { ?>class="current"<?php } ?>>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                            <span class="hidden-xs">
                                <?php if ($item['user_name'] || $item['user_surname']) { ?>
                                    (<?= $item['user_name']; ?> <?= $item['user_surname']; ?>)
                                <?php } ?>
                            </span>
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