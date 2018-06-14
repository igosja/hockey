<?php
/**
 * @var $country_array array
 * @var $num_get integer
 * @var $surname_array array
 * @var $surnamecountry_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($surname_array[0])) { ?>
                <?= $surname_array[0]['surname_name']; ?>
            <?php } else { ?>
                Создание фамилии
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/surname_list.php">
            Список
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a class="btn btn-default" href="/admin/surname_view.php?num=<?= $num_get; ?>">
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
                        <label class="control-label" for="surname_name">Имя</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="surname_name"
                            name="data[surname_name]"
                            value="<?= isset($surname_array[0]) ? $surname_array[0]['surname_name'] : ''; ?>"
                        >
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="surnamecountry_country_id">Страны</label>
                    </td>
                    <td>
                        <select
                            class="form-control"
                            id="surnamecountry_country_id"
                            multiple
                            name="array[surnamecountry_country_id][]"
                        >
                            <?php foreach ($country_array as $item) { ?>
                                <option
                                    value="<?= $item['country_id']; ?>"
                                    <?php if (isset($surnamecountry_array)) { ?>
                                        <?php foreach ($surnamecountry_array as $check) { ?>
                                            <?php if ($check['surnamecountry_country_id'] == $item['country_id']) { ?>
                                                selected
                                            <?php } ?>
                                        <?php } ?>
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