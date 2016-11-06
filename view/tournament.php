<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>
            Турниры
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <a href="/offseason.php">Кубок межсезонья</a>
        |
        <a href="/conferecne.php">Конференция</a>
        |
        <a href="/worldcup.php">Чемпионат мира</a>
        |
        <a href="/championsleague.php">Лига чемпионов</a>
    </div>
</div>
<div class="row margin-top">
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