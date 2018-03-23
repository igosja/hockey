<?php
/**
 * @var $blockreason_array array
 * @var $num_get integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $blockreason_array[0]['blockreason_text']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/blockreason_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/blockreason_update.php?num=<?= $num_get; ?>">
            Изменить
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
                    <?= $blockreason_array[0]['blockreason_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Название
                </td>
                <td>
                    <?= $blockreason_array[0]['blockreason_text']; ?>
                </td>
            </tr>
        </table>
    </div>
</div>