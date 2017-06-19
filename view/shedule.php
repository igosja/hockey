<?php
/**
 * @var $shedule_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Рассписание</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-20">Дата</th>
                <th>Соревнования</th>
                <th class="col-20">Стадия</th>
            </tr>
            <?php foreach ($shedule_array as $item) { ?>
                <tr<?php if (date('Y-m-d', $item['shedule_date']) == date('Y-m-d')) { ?> class="info"<?php } ?>>
                    <td class="text-center"><?= f_igosja_ufu_date_time($item['shedule_date']); ?></td>
                    <td class="text-center">
                        <a href="/game_list.php?num=<?= $item['shedule_id']; ?>">
                            <?= $item['tournamenttype_name']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= $item['stage_name']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th>Соревнования</th>
                <th>Стадия</th>
            </tr>
        </table>
    </div>
</div>