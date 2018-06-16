<?php
/**
 * @var $money_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>История платежей</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/shop_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-15">Дата</th>
                <th class="col-10 hidden-xs">Было</th>
                <th class="col-10">+/-</th>
                <th class="col-10 hidden-xs">Стало</th>
                <th>Комментарий</th>
            </tr>
            <?php foreach ($money_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date_time($item['money_date']); ?></td>
                    <td class="hidden-xs text-right"><?= $item['money_value_before']; ?></td>
                    <td class="text-right"><?= $item['money_value']; ?></td>
                    <td class="hidden-xs text-right"><?= $item['money_value_after']; ?></td>
                    <td><?= $item['moneytext_name']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th class="hidden-xs">Было</th>
                <th>+/-</th>
                <th class="hidden-xs">Стало</th>
                <th>Комментарий</th>
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