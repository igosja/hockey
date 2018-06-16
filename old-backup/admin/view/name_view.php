<?php
/**
 * @var $country_array array
 * @var $name_array array
 * @var $num_get integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $name_array[0]['name_name']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/name_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/name_update.php?num=<?= $num_get; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/name_delete.php?num=<?= $num_get; ?>">
            Удалить
        </a>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Id
                </td>
                <td>
                    <?= $name_array[0]['name_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Имя
                </td>
                <td>
                    <?= $name_array[0]['name_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Страны
                </td>
                <td>
                    <?php foreach ($country_array as $item) { ?>
                        <a href="/admin/country/view/<?= $item['country_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                        <br/>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>