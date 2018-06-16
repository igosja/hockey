<?php
/**
 * @var $num_get integer
 * @var $teamask_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $teamask_array[0]['team_name']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/teamask_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/teamask_update.php?num=<?= $num_get; ?>">
            Одобрить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/teamask_delete.php?num=<?= $num_get; ?>">
            Удалить
        </a>
    </li>
</ul>
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
                    <a href="/admin/team_view.php?num=<?= $teamask_array[0]['team_id']; ?>">
                        <?= $teamask_array[0]['team_name']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Пользователь
                </td>
                <td>
                    <a href="/admin/user_view.php?num=<?= $teamask_array[0]['user_id']; ?>">
                        <?= $teamask_array[0]['user_login']; ?>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>