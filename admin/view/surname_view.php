<?php
/**
 * @var $country_array array
 * @var $num_get integer
 * @var $surname_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $surname_array[0]['surname_name']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/surname_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/surname_update.php?num=<?= $num_get; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/surname_delete.php?num=<?= $num_get; ?>">
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
                    <?= $surname_array[0]['surname_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Фамилия
                </td>
                <td>
                    <?= $surname_array[0]['surname_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Страны
                </td>
                <td>
                    <?php foreach ($country_array as $item) { ?>
                        <a href="/admin/country_view.php?num=<?= $item['country_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                        <br/>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>