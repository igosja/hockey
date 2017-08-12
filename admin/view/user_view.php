<?php
/**
 * @var $num_get integer
 * @var $user_array integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $user_array[0]['user_login']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/user_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/user_update.php?num=<?= $num_get; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/auth_by_key.php?code=<?= $user_array[0]['user_code']; ?>" target="_blank">
            Вход на сайт
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
                    <?= $user_array[0]['user_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Логин
                </td>
                <td>
                    <?= $user_array[0]['user_login']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Email
                </td>
                <td>
                    <?= $user_array[0]['user_email']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Баланс
                </td>
                <td>
                    <?= $user_array[0]['user_money']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Дата последнего посещения
                </td>
                <td>
                    <?= f_igosja_ufu_last_visit($user_array[0]['user_date_login']); ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Дата регистрации
                </td>
                <td>
                    <?= f_igosja_ufu_date_time($user_array[0]['user_date_register']); ?>
                </td>
            </tr>
        </table>
    </div>
</div>