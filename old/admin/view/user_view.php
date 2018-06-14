<?php
/**
 * @var $num_get integer
 * @var $cookie_array array
 * @var $ip_array array
 * @var $user_array array
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
                    IP
                </td>
                <td>
                    <?= $user_array[0]['user_ip']; ?>
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
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Доступ к сайту
                </td>
                <td>
                    <?php if (time() < $user_array[0]['user_date_block']) { ?>
                        Заблокирован до <?= f_igosja_ufu_date_time($user_array[0]['user_date_block']); ?>
                    <?php } else { ?>
                        Открыт
                        <a class="btn btn-default btn-xs" href="/admin/user_block.php?num=<?= $num_get; ?>">
                            Блокировать
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Доступ ко всем комментариям
                </td>
                <td>
                    <?php if (time() < $user_array[0]['user_date_block_comment']) { ?>
                        Заблокирован до <?= f_igosja_ufu_date_time($user_array[0]['user_date_block_comment']); ?>
                    <?php } else { ?>
                        Открыт
                        <a class="btn btn-default btn-xs" href="/admin/user_block_comment.php?num=<?= $num_get; ?>">
                            Блокировать
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Доступ к комментариям сделок
                </td>
                <td>
                    <?php if (time() < $user_array[0]['user_date_block_dealcomment']) { ?>
                        Заблокирован до <?= f_igosja_ufu_date_time($user_array[0]['user_date_block_dealcomment']); ?>
                    <?php } else { ?>
                        Открыт
                        <a class="btn btn-default btn-xs" href="/admin/user_block_dealcomment.php?num=<?= $num_get; ?>">
                            Блокировать
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Доступ к форуму
                </td>
                <td>
                    <?php if (time() < $user_array[0]['user_date_block_forum']) { ?>
                        Заблокирован до <?= f_igosja_ufu_date_time($user_array[0]['user_date_block_forum']); ?>
                    <?php } else { ?>
                        Открыт
                        <a class="btn btn-default btn-xs" href="/admin/user_block_forum.php?num=<?= $num_get; ?>">
                            Блокировать
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Доступ к комментариям матчей
                </td>
                <td>
                    <?php if (time() < $user_array[0]['user_date_block_gamecomment']) { ?>
                        Заблокирован до <?= f_igosja_ufu_date_time($user_array[0]['user_date_block_gamecomment']); ?>
                    <?php } else { ?>
                        Открыт
                        <a class="btn btn-default btn-xs" href="/admin/user_block_gamecomment.php?num=<?= $num_get; ?>">
                            Блокировать
                        </a>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Доступ к комментариям новостей
                </td>
                <td>
                    <?php if (time() < $user_array[0]['user_date_block_newscomment']) { ?>
                        Заблокирован до <?= f_igosja_ufu_date_time($user_array[0]['user_date_block_newscomment']); ?>
                    <?php } else { ?>
                        Открыт
                        <a class="btn btn-default btn-xs" href="/admin/user_block_newscomment.php?num=<?= $num_get; ?>">
                            Блокировать
                        </a>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <th>Пересечение по ip</th>
                <th>Пользователь</th>
            </tr>
            <?php foreach ($ip_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['user_ip']; ?></td>
                    <td>
                        <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <th>Количество</th>
                <th>Пересечение по cookie</th>
                <th>Пользователь</th>
            </tr>
            <?php foreach ($cookie_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['onecomputer_count']; ?></td>
                    <td class="text-center"><?= $item['user_ip']; ?></td>
                    <td>
                        <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>