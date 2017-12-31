<?php
/**
 * @var $leaguedistribution_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-20">Сезон</th>
                <th class="col-20">Групповой этап</th>
                <th class="col-20">ОР3</th>
                <th class="col-20">ОР2</th>
                <th class="col-20">ОР1</th>
            </tr>
            <?php foreach ($leaguedistribution_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= $item['leaguedistribution_season_id']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_group']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_qualification_3']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_qualification_2']; ?></td>
                    <td class="text-center"><?= $item['leaguedistribution_qualification_1']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Сезон</th>
                <th>Групповой этап</th>
                <th>ОР3</th>
                <th>ОР2</th>
                <th>ОР1</th>
            </tr>
        </table>
    </div>
</div>