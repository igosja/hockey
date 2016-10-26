<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Турниры
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        Кубок межсезонья |
        Конференция |
        Чемпионат мира |
        Лига чемпионов
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th>Страна</th>
            </tr>
            <?php foreach ($country_array as $item) { ?>
                <tr>
                    <td>
                        <a href="/country_team.php?num=<?= $item['country_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <th>Страна</th>
            </tr>
        </table>
    </div>
</div>