<?php
/**
 * @var $finance_array array
 * @var $num_get integer
 * @var $season_array array
 * @var $season_id integer
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<form method="GET">
    <input name="num" type="hidden" value="<?= $num_get; ?>" />
    <div class="row margin-top">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8"></div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="season_id">Сезон:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
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
                <th class="col-10 hidden-xs">Было</th>
                <th class="col-10">+/-</th>
                <th class="col-10 hidden-xs">Стало</th>
                <th class="hidden-xs">Комментарий</th>
            </tr>
            <?php foreach ($finance_array as $item) { ?>
                <tr>
                    <td class="text-center"><?= f_igosja_ufu_date($item['finance_date']); ?></td>
                    <td class="text-right hidden-xs"><?= f_igosja_money_format($item['finance_value_before']); ?></td>
                    <td class="text-right"><?= f_igosja_money_format($item['finance_value']); ?></td>
                    <td class="text-right hidden-xs"><?= f_igosja_money_format($item['finance_value_after']); ?></td>
                    <td class="hidden-xs"><?= $item['financetext_name']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th>Дата</th>
                <th class="hidden-xs">Было</th>
                <th>+/-</th>
                <th class="hidden-xs">Стало</th>
                <th class="hidden-xs">Комментарий</th>
            </tr>
        </table>
    </div>
</div>