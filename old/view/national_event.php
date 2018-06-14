<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/national_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/national_view_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/national_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-1" title="Сезон">С</th>
                <th class="col-15">Дата</th>
                <th>Событие</th>
            </tr>
            <?php foreach ($event_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['history_season_id']; ?></td>
                    <td class="text-center"><?= f_igosja_ufu_date($item['history_date']); ?></td>
                    <td><?= $item['historytext_name']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th title="Сезон">С</th>
                <th>Дата</th>
                <th>Событие</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/national_table_link.php'); ?>
    </div>
</div>