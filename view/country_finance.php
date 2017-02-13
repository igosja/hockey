<?php include (__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-15">Дата</th>
                <th class="col-10">Было</th>
                <th class="col-10">+/-</th>
                <th class="col-10">Стало</th>
                <th>Комментарий</th>
            </tr>
            <?php foreach ($finance_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['finance_date']); ?></td>
                    <td class="text-right"><?= f_igosja_money($item['finance_value_before']); ?></td>
                    <td class="text-right"><?= f_igosja_money($item['finance_value']); ?></td>
                    <td class="text-right"><?= f_igosja_money($item['finance_value_after']); ?></td>
                    <td><?= $item['financetext_name']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th>Было</th>
                <th>+/-</th>
                <th>Стало</th>
                <th>Комментарий</th>
            </tr>
        </table>
    </div>
</div>