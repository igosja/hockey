<?php
/**
 * @var $city_array array
 * @var $num_get integer
 * @var $stadium_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($stadium_array[0])) { ?>
                <?= $stadium_array[0]['stadium_name']; ?>
            <?php } else { ?>
                Создание стадиона
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/stadium_list.php">
            Список
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a class="btn btn-default" href="/admin/stadium_view.php?num=<?= $num_get; ?>">
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
                            name="data[stadium_name]"
                            value="<?= isset($stadium_array[0]) ? $stadium_array[0]['stadium_name'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="stadium_city_id">Город</label>
                    </td>
                    <td>
                        <select class="form-control" id="stadium_city_id" name="data[stadium_city_id]">
                            <?php foreach ($city_array as $item) { ?>
                                <option
                                    value="<?= $item['city_id']; ?>"
                                    <?php
                                    if (isset($stadium_array[0]) && $stadium_array[0]['stadium_city_id'] == $item['city_id']) {
                                    ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['city_name']; ?>
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