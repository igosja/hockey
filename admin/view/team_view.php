<?php
/**
 * @var $num_get integer
 * @var $team_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $team_array[0]['team_name']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/team_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/team_update.php?num=<?= $num_get; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/team_delete.php?num=<?= $num_get; ?>">
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
                    <?= $team_array[0]['team_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Название
                </td>
                <td>
                    <?= $team_array[0]['team_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Стадион
                </td>
                <td>
                    <a href="/admin/stadium_view.php?num=<?= $team_array[0]['stadium_id']; ?>">
                        <?= $team_array[0]['stadium_name']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Город
                </td>
                <td>
                    <a href="/admin/city_view.php?num=<?= $team_array[0]['city_id']; ?>">
                        <?= $team_array[0]['city_name']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Страна
                </td>
                <td>
                    <a href="/admin/country_view.php?num=<?= $team_array[0]['country_id']; ?>">
                        <?= $team_array[0]['country_name']; ?>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>