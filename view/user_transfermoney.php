<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Перевод денег с личного счёта
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Перевод денег с личного счёта</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <p>
            Деньги на личном счете менеджера появляются как премиальные за написание обзоров,
            участие в пресс-конференциях, тренерскую работу в сборных либо за воспитание подопечных.
        </p>
        <p>
            На этой странице вы можете перевести деньги с вашего личного счета
            на счет выбранной команды или в фонд федерации.
        </p>
        <p>Заполните форму для перевода денег:</p>
        <form method="POST">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="team">Команда</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <select class="form-control" id="team" name="data[team_id]">
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
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="country">Федерация</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <select class="form-control" id="country" name="data[country_id]">
                        <option value="0">Выберите федерацию</option>
                        <?php foreach ($country_array as $item) { ?>
                            <option value="<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="sum">Доступно:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <span class="strong"><?= f_igosja_money($user_array[0]['user_finance']); ?></span>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="sum">Сумма, $:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input class="form-control" id="sum" name="data[sum]"/>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                    <label for="comment">Комментарий:</label>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <textarea class="form-control" id="comment" name="data[comment]"></textarea>
                </div>
            </div>
            <p class="text-center">
                <button class="btn" type="submit">Перевести</button>
            </p>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered table-hover">
            <tr>
                <th>Перевод денег с личного счёта</th>
            </tr>
        </table>
    </div>
</div>