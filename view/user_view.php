<?php include(__DIR__ . '/include/user_profile.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row text-size-4"><?= SPACE; ?></div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
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
                    <td class="text-center"><?= $item['log_season_id']; ?></td>
                    <td class="text-center"><?= f_igosja_ufu_date($item['log_date']); ?></td>
                    <td><?= $item['logtext_name']; ?></td>
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