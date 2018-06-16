<?php
/**
 * @var $event_array array
 * @var $num_get integer
 * @var $season_array array
 * @var $season_id integer
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/team_view_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <?php include(__DIR__ . '/include/team_view_top_right.php'); ?>
    </div>
</div>
<form method="GET">
    <input name="num" type="hidden" value="<?= $num_get; ?>">
    <div class="row margin-top">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
            <?php include(__DIR__ . '/include/team_table_link.php'); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <label for="season_id">Сезон:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control submit-on-change" name="season_id" id="season_id">
                        <?php foreach ($season_array as $item) { ?>
                            <option
                                value="<?= $item['season_id']; ?>"
                                <?php if ($season_id == $item['season_id']) { ?>
                                    selected
                                <?php } ?>
                            >
                                <?= $item['season_id']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-15">Дата</th>
                <th>Событие</th>
            </tr>
            <?php foreach ($event_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['history_date']); ?></td>
                    <td><?= $item['historytext_name']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th>Событие</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/team_table_link.php'); ?>
    </div>
</div>