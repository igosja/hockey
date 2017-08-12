<?php
/**
 * @var $num_get integer
 * @var $rule_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $rule_array[0]['rule_title']; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/rule_list.php">
            Список
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/rule_update.php?num=<?= $num_get; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/rule_delete.php?num=<?= $num_get; ?>">
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
                    <?= $rule_array[0]['rule_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Заголовок
                </td>
                <td>
                    <?= $rule_array[0]['rule_title']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Текст
                </td>
                <td>
                    <?= $rule_array[0]['rule_text']; ?>
                </td>
            </tr>
        </table>
    </div>
</div>