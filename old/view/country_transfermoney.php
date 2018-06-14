<?php
/**
 * @var $country_array array
 * @var $federation_array array
 * @var $team_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Перевод денег со счёта федерации</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form id="transfermoney-form" method="POST">
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    <label for="transfermoney-team">Команда</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <select class="form-control" id="transfermoney-team" name="data[team_id]">
                        <option value="0">Выберите команду</option>
                        <?php foreach ($team_array as $item) { ?>
                            <option value="<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                                (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    <label for="transfermoney-country">Федерация</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <select class="form-control" id="transfermoney-country" name="data[country_id]">
                        <option value="0">Выберите федерацию</option>
                        <?php foreach ($federation_array as $item) { ?>
                            <option value="<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center transfermoney-country-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    Доступно:
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <span class="strong"><?= f_igosja_money_format($country_array[0]['country_finance']); ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    <label for="transfermoney-sum">Сумма, $:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <input class="form-control" id="transfermoney-sum" name="data[sum]" data-available="<?= $country_array[0]['country_finance']; ?>" />
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center transfermoney-sum-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
                    <label for="transfermoney-comment">Комментарий:</label>
                </div>
                <div class="col-lg-3 col-md-5 col-sm-5 col-xs-12">
                    <textarea class="form-control" id="transfermoney-comment" name="data[comment]"></textarea>
                </div>
                <div class="col-lg-4 col-md-3 col-sm-3 col-xs-12 xs-text-center transfermoney-comment-error notification-error"></div>
            </div>
            <p class="text-center">
                <button class="btn" type="submit">Перевести</button>
            </p>
        </form>
    </div>
</div>