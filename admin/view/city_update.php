<?php
/**
 * @var $city_array array
 * @var $country_array array
 * @var $num_get integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($city_array[0])) { ?>
                <?= $city_array[0]['city_name']; ?>
            <?php } else { ?>
                Создание города
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/city_list.php">
            Список
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a class="btn btn-default" href="/admin/city_view.php?num=<?= $num_get; ?>">
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
                        <label class="control-label" for="city_name">Название</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="city_name"
                            name="data[city_name]"
                            value="<?= isset($city_array[0]) ? $city_array[0]['city_name'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="city_country_id">Страна</label>
                    </td>
                    <td>
                        <select class="form-control" id="city_country_id" name="data[city_country_id]">
                            <?php foreach ($country_array as $item) { ?>
                                <option
                                    value="<?= $item['country_id']; ?>"
                                    <?php
                                    if (isset($city_array[0]) && $city_array[0]['city_country_id'] == $item['country_id']) {
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
            <button class="btn btn-default">Сохранить</button>
        </div>
    </div>
</form>