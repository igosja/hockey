<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Список команд
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th class="col-1"></th>
                <th>Страна</th>
                <th>Команд</th>
            </tr>
            <?php foreach ($country_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/country_team.php?num=<?= $item['country_id']; ?>">
                            <img src="/img/country/12/<?= $item['country_id']; ?>.png" />
                        </a>
                    </td>
                    <td>
                        <a href="/country_team.php?num=<?= $item['country_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                    </td>
                    <td class="text-center"><?= $item['count_team']; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <th></th>
                <th>Страна</th>
                <th>Команд</th>
            </tr>
        </table>
    </div>
</div>