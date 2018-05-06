<?php
/**
 * @var $auth_team_id integer
 * @var $my_player boolean
 * @var $num_get integer
 * @var $on_transfer boolean
 * @var $transferapplication_array array
 * @var $transferapplication_sql mysqli_result
 * @var $transfer_only_one integer
 * @var $transfer_price integer
 * @var $start_price integer
 */
?>
<?php include(__DIR__ . '/include/player_view.php'); ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Трансфер игрока</th>
            </tr>
        </table>
    </div>
</div>
<?php if (isset($auth_team_id)) { ?>
    <?php if ($my_player) { ?>
        <?php if ($on_transfer) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                    <p class="text-center">
                        Игрок находится на трансфере.
                        <br/>
                        Начальная стоимоcть игрока составляет <span class="strong"><?= f_igosja_money_format($transfer_price); ?></span>.
                    </p>
                    <?php if (isset($transfer_array[0]['transfer_to_league']) && 1 == $transfer_array[0]['transfer_to_league']) { ?>
                        <p class="text-center">
                            В случае отсутствия спроса игрок будет продан Лиге
                        </p>
                    <?php } ?>
                    <form method="POST">
                        <input name="data[off]" type="hidden" value="1" />
                        <p class="text-center">
                            <button class="btn" type="submit">Снять с трансфера</button>
                        </p>
                    </form>
                    <p class="text-center">Заявки на вашего игрока:</p>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Команда потенциального покупателя</th>
                            <th class="col-20">Время заявки</th>
                            <th class="col-15">Сумма</th>
                        </tr>
                        <?php foreach ($transferapplication_array as $item) { ?>
                            <tr>
                                <td>
                                    <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                        <?= $item['team_name']; ?>
                                        (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                                    </a>
                                </td>
                                <td class="text-center"><?= f_igosja_ufu_date_time($item['transferapplication_date']); ?></td>
                                <td class="text-right"><?= f_igosja_money_format($item['transferapplication_price']); ?></td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <p>
                        Здесь вы можете <span class="strong">поставить своего игрока на трансферный рынок</span>.
                    </p>
                    <p>
                        Начальная трансферная цена игрока должна быть не меньше
                        <span class="strong"><?= f_igosja_money_format($transfer_price); ?></span>.
                    </p>
                    <form method="POST">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                <label for="price">Начальная цена, $:</label>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">
                                <input class="form-control" name="data[price]" id="price" type="text" value="<?= $transfer_price; ?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <input type="checkbox" name="data[to_league]" value="1" id="to-league" />
                                <label for="to-league">Продать Лиге</label>
                            </div>
                        </div>
                        <p class="text-center">
                            <button class="btn" type="submit">Выставить на трансфер</button>
                        </p>
                    </form>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if ($on_transfer) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            Ваша команда:
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="strong">
                                <a href="/team_view.php?num=<?= $team_array[0]['team_id']; ?>">
                                    <?= $team_array[0]['team_name']; ?>
                                    <span class="hidden-xs">
                                        (<?= $team_array[0]['city_name']; ?>, <?= $team_array[0]['country_name']; ?>)
                                    </span>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            В кассе команды:
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="strong"><?= f_igosja_money_format($team_array[0]['team_finance']); ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                            Начальная цена:
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <span class="strong"><?= f_igosja_money_format($start_price); ?></span>
                        </div>
                    </div>
                    <form method="POST">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                <label for="price">Ваше предложение, $:</label>
                            </div>
                            <div class="col-lg-1 col-md-2 col-sm-2 col-xs-6">
                                <input class="form-control" name="data[price]" id="price" type="text" value="<?= $transfer_price; ?>" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                                <label for="only_one">
                                    В случае победы удалить все остальные мои заявки
                                    <input name="data[only_one]" type="hidden" value="0" />
                                    <input name="data[only_one]" id="only_one" type="checkbox" value="1" <?php if (1 == $transfer_only_one) { ?>checked<?php } ?> />
                                </label>
                            </div>
                        </div>
                        <p class="text-center">
                            <?php if ($transferapplication_sql->num_rows) { ?>
                                <button class="btn" type="submit">
                                    Редактировать заявку
                                </button>
                                <a href="?num=<?= $num_get; ?>&data[off]=1" class="btn">Удалить заявку</a>
                            <?php } else { ?>
                                <button class="btn" type="submit">
                                    Подать заявку
                                </button>
                            <?php } ?>
                        </p>
                    </form>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <p class="strong">Игрок не выставлен на трансфер.</p>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
<?php } else { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p class="strong">Для действий на трансферном рынке нужно взять команду под управление.</p>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Трансфер игрока</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>