<?php include(__DIR__ . '/include/player_view_top.php'); ?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>
<?php if (isset($auth_team_id)) { ?>
    <?php if ($my_player) { ?>
        <?php if ($on_transfer) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
                    <p class="text-center">Заявки на вашего игрока:</p>
                    <table class="table table-bordered table-hover">
                        <tr>
                            <th>Команда потенциального покупателя</th>
                            <th>Время подачи</th>
                            <th>Сумма</th>
                        </tr>
                        <?php foreach ($game_array = array() as $item) { ?>
                            <tr>
                                <td>
                                    <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                                        <?= $item['team_name']; ?>
                                        (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                                    </a>
                                </td>
                                <td class="text-center"><?= f_igosja_ufu_date($item['date']); ?></td>
                                <td class="text-right"><?= f_igosja_money($item['price']); ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th>Команда потенциального покупателя</th>
                            <th>Время подачи</th>
                            <th>Сумма</th>
                        </tr>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <p>Здесь вы можете <span class="strong">поставить своего игрока на трансферный рынок</span>, чтобы он по результатам торгов был продан:</p>
                    <p>Начальная трансферная цена игрока должна быть не меньше <?= f_igosja_money(0); ?>.</p>
                    <form method="POST">
                        <label for="price">Начальная цена торгов:</label>
                        <input class="form-control" id="price" type="text" value="<?= $transfer_price; ?>" />
                        <button class="btn" type="submit">Выставить игрока на трансферный рынок</button>
                    </form>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if ($on_transfer) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <p>Ваша команда: <span class="strong">Команда</span></p>
                    <p>В кассе команды: <span class="strong"><?= f_igosja_money(0); ?></span></p>
                    <p>Начальная трансферная цена игрока должна быть не меньше <?= f_igosja_money(0); ?>.</p>
                    <form method="POST">
                        <label for="price">Ваше предложение:</label>
                        <input class="form-control" id="price" type="text" value="<?= $transfer_price; ?>" />
                        <button class="btn" type="submit">Подать заявку</button>
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
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/player_table_link.php'); ?>
    </div>
</div>