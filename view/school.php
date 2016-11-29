<?php if (isset($confirm_data['position']['id'])) { ?>
    <form method="POST">
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Начнется подготовка юниора:
                <ul>
                    <?php foreach ($confirm_data as $item) { ?>
                        <li><?= $item['name']; ?></li>
                        <input name="data[position_id]" type="hidden" value="<?= $item['id']; ?>">
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <input name="data[ok]" type="hidden" value="1">
                <input class="btn margin" type="submit" value="Начать подготовку"/>
                <a href="/school.php" class="btn margin">Отказаться</a>
            </div>
        </div>
    </form>
<?php } ?>
<form method="POST">
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>Игрок</th>
                    <th title="Национальность" class="col-1">Нац</th>
                    <th title="Возраст">В</th>
                    <th title="Позиция">Поз</th>
                    <th title="Спецвозможности">Спец</th>
                </tr>
                <tr>
                    <td>
                        Молодой игрок
                    </td>
                    <td class="text-center">
                        <a href="/country_view.php?num=<?= $team_array[0]['country_id']; ?>">
                            <img
                                src="/img/country/12/<?= $team_array[0]['country_id']; ?>.png"
                                title="<?= $team_array[0]['country_name']; ?>"
                            />
                        </a>
                    </td>
                    <td class="text-center">17</td>
                    <td class="text-center">
                        <select name="data[position_id]">
                            <option value="0"></option>
                            <?php foreach ($position_array as $item) { ?>
                                <option value="<?= $item['position_id']; ?>"><?= $item['position_name']; ?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td class="text-center">
                        <select name="data[special_id]">
                        </select>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Продолжить" />
        </div>
    </div>
</form>