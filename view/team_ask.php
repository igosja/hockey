<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Получение команды</h1>
    </div>
</div>
<?php if ($teamask_array[0]['count']) { ?>
    <div class="row margin-bottom">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center success">
            Ваша заявка рассматривается администратором
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-bordered">
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Страна</th>
                <th>Див</th>
                <th>База</th>
                <th>Стадион</th>
                <th>Финансы</th>
                <th title="Рейтинг силы с учетом спецвозможностей">Vs</th>
            </tr>
            <?php foreach ($team_array as $item) { ?>
                <tr>
                    <td class="text-center">
                        <a href="/team_ask.php?num=<?= $item['team_id']; ?>">
                            <img src="/img/check.png"/>
                        </a>
                    </td>
                    <td>
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?> (<?= $item['city_name']; ?>)
                        </a>
                    </td>
                    <td>
                        <img src="/img/country/12/<?= $item['country_id']; ?>.png"/>
                        <a href="/country_view.php?num=<?= $item['country_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="javascript:;">
                            D1
                        </a>
                    </td>
                    <td class="text-center"><?= $item['team_base_slot_used']; ?> из <?= $item['team_base_id']; ?></td>
                    <td class="text-right"><?= $item['stadium_capacity']; ?></td>
                    <td class="text-right"><?= $item['team_finance']; ?></td>
                    <td class="text-right">123</td>
                </tr>
            <?php } ?>
            <tr>
                <th></th>
                <th>Команда</th>
                <th>Страна</th>
                <th>Див</th>
                <th>База</th>
                <th>Стадион</th>
                <th>Финансы</th>
                <th title="Рейтинг силы с учетом спецвозможностей">Vs</th>
            </tr>
        </table>
    </div>
</div>