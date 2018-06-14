<?php

/**
 * @var $national_array array
 */

?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Сборная</th>
                <th class="col-25">Тренер</th>
                <th class="col-25">Финансы</th>
            </tr>
            <tr>
                <td>
                    <a href="/national_view.php?num=<?= $national_array[0]['national_id']; ?>">
                        <?= $national_array[0]['nationaltype_name']; ?>
                    </a>
                </td>
                <td class="text-center">
                    <a href="/user_view.php?num=<?= $national_array[0]['user_id']; ?>">
                        <?= $national_array[0]['user_login']; ?>
                    </a>
                </td>
                <td class="text-right">
                    <?= f_igosja_money_format($national_array[0]['national_finance']); ?>
                </td>
            </tr>
            <tr>
                <th>Сборная</th>
                <th>Тренер</th>
                <th>Финансы</th>
            </tr>
        </table>
    </div>
</div>
