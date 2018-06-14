<?php
/**
 * @var $num_get integer
 * @var $stadium_array array
 * @var $team_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($team_array[0])) { ?>
                <?= $team_array[0]['team_name']; ?>
            <?php } else { ?>
                Создание команды
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/team_list.php">
            Список
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a class="btn btn-default" href="/admin/team_view.php?num=<?= $num_get; ?>">
                Просмотр
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
                        <label class="control-label" for="stadium_name">Название</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="stadium_name"
                            name="data[team_name]"
                            value="<?= isset($team_array[0]) ? $team_array[0]['team_name'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="team_stadium_id">Стадион</label>
                    </td>
                    <td>
                        <select class="form-control" id="team_stadium_id" name="data[team_stadium_id]">
                            <?php foreach ($stadium_array as $item) { ?>
                                <option
                                    value="<?= $item['stadium_id']; ?>"
                                    <?php
                                    if (isset($team_array[0]) && $team_array[0]['team_stadium_id'] == $item['stadium_id']) {
                                    ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['stadium_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default">Сохранить</button>
        </div>
    </div>
</form>