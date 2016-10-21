<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $teamask_array[0]['team_name']; ?></h3>
    </div>
</div>
<?php include(__DIR__ . '/../../include/admin/button/list-ok-delete.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Id
                </td>
                <td>
                    <?= $teamask_array[0]['teamask_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Время заявки
                </td>
                <td>
                    <?= f_igosja_ufu_date_time($teamask_array[0]['teamask_date']); ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Команда
                </td>
                <td>
                    <a href="/admin/team/view/<?= $teamask_array[0]['team_id']; ?>">
                        <?= $teamask_array[0]['team_name']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Пользователь
                </td>
                <td>
                    <a href="/admin/user/view/<?= $teamask_array[0]['user_id']; ?>">
                        <?= $teamask_array[0]['user_login']; ?>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>