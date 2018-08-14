<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <p class="text-center">
            Игрок находится на трансфере.
            <br/>
            Начальная стоимоcть игрока составляет <span class="strong"><?= 123; ?></span>.
        </p>
        <?php if (true) { ?>
            <p class="text-center">
                В случае отсутствия спроса игрок будет продан Лиге
            </p>
        <?php } ?>
        <form method="POST">
            <input name="data[off]" type="hidden" value="1"/>
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
            <?php foreach ([] as $item) { ?>
                <tr>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            (<?= $item['city_name']; ?>, <?= $item['country_name']; ?>)
                        </a>
                    </td>
                    <td class="text-center"><?= ($item['transferapplication_date']); ?></td>
                    <td class="text-right"><?= ($item['transferapplication_price']); ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>