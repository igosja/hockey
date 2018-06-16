<?php
/**
 * @var $num_get integer
 * @var $logo_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $logo_array[0]['team_name']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/logo_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/logo_update.php?num=<?= $num_get; ?>">
            Одобрить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/logo_delete.php?num=<?= $num_get; ?>">
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
                    <?= $logo_array[0]['logo_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Время заявки
                </td>
                <td>
                    <?= f_igosja_ufu_date_time($logo_array[0]['logo_date']); ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Команда
                </td>
                <td>
                    <a href="/admin/team_view.php?num=<?= $logo_array[0]['team_id']; ?>">
                        <?= $logo_array[0]['team_name']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Пользователь
                </td>
                <td>
                    <a href="/admin/user_view.php?num=<?= $logo_array[0]['user_id']; ?>">
                        <?= $logo_array[0]['user_login']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Старый логотип
                </td>
                <td>
                    <?php if (file_exists(__DIR__ . '/../../img/team/125/' . $logo_array[0]['team_id'] . '.png')) { ?>
                        <img
                            alt="<?= $logo_array[0]['team_name']; ?>"
                            src="/img/team/125/<?= $logo_array[0]['team_id']; ?>.png?v=<?= filemtime(__DIR__ . '/../../img/team/125/' . $logo_array[0]['team_id'] . '.png'); ?>"
                            title="<?= $logo_array[0]['team_name']; ?>"
                        />
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Новый логотип
                </td>
                <td>
                    <img
                        alt="<?= $logo_array[0]['team_name']; ?>"
                        src="/upload/img/team/125/<?= $logo_array[0]['team_id']; ?>.png?v=<?= filemtime(__DIR__ . '/../../upload/img/team/125/' . $logo_array[0]['team_id'] . '.png'); ?>"
                        title="<?= $logo_array[0]['team_name']; ?>"
                    />
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Комментарий
                </td>
                <td>
                    <?= $logo_array[0]['logo_text']; ?>
                </td>
            </tr>
        </table>
    </div>
</div>