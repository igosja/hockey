<?php
/**
 * @var $schedule_array array
 * @var $season_array array
 * @var $season_id integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Расписание</h1>
    </div>
</div>
<form method="GET">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
            <label for="season_id">Сезон:</label>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
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
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4"></div>
    </div>
</form>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th class="col-20">Дата</th>
                <th>Соревнования</th>
                <th class="col-20">Стадия</th>
            </tr>
            <?php foreach ($schedule_array as $item) { ?>
                <tr<?php if (date('Y-m-d', $item['schedule_date']) == date('Y-m-d')) { ?> class="info"<?php } ?>>
                    <td class="text-center"><?= f_igosja_ufu_date_time($item['schedule_date']); ?></td>
                    <td class="text-center">
                        <a href="/game_list.php?num=<?= $item['schedule_id']; ?>">
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