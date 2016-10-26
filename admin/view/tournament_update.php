<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($tournament_array[0]['tournament_name'])) { ?>
                <?= $tournament_array[0]['tournament_name']; ?>
            <?php } else { ?>
                Создание турнира
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a href="/admin/tournament_list.php">
            <button class="btn btn-default">Список</button>
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a href="/admin/tournament_view.php?num=<?= $num_get; ?>">
                <button class="btn btn-default">Просмотр</button>
            </a>
        </li>
    <?php } ?>
</ul>
<form class="form-horizontal" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="tournament_name">Название</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="tournament_name"
                            name="data[tournament_name]"
                            value="<?= isset($tournament_array[0]) ? $tournament_array[0]['tournament_name'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="tournament_city_id">Тип</label>
                    </td>
                    <td>
                        <select class="form-control" id="tournament_tournamenttype_id" name="data[tournament_tournamenttype_id]">
                            <?php foreach ($tournamenttype_array as $item) { ?>
                                <option
                                    value="<?= $item['tournamenttype_id']; ?>"
                                    <?php
                                    if (isset($tournament_array[0]) && $tournament_array[0]['tournament_tournamenttype_id'] == $item['tournamenttype_id']) {
                                    ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['tournamenttype_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="tournament_city_id">Страна</label>
                    </td>
                    <td>
                        <select class="form-control" id="tournament_country_id" name="data[tournament_country_id]">
                            <option value="0">Нет</option>
                            <?php foreach ($country_array as $item) { ?>
                                <option
                                    value="<?= $item['country_id']; ?>"
                                    <?php
                                    if (isset($tournament_array[0]) && $tournament_array[0]['tournament_country_id'] == $item['country_id']) {
                                    ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['country_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default" type="submit">Сохранить</button>
        </div>
    </div>
</form>