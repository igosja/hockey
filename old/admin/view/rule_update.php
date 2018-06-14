<?php
/**
 * @var $num_get integer
 * @var $rule_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($rule_array[0])) { ?>
                <?= $rule_array[0]['rule_title']; ?>
            <?php } else { ?>
                Создание правила
            <?php } ?>
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/rule_list.php">
            Список
        </a>
    </li>
    <?php if (isset($num_get)) { ?>
        <li>
            <a class="btn btn-default" href="/admin/rule_view.php?num=<?= $num_get; ?>">
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
                        <label class="control-label" for="rule_title">Название</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="rule_title"
                            name="data[rule_title]"
                            value="<?= isset($rule_array[0]) ? $rule_array[0]['rule_title'] : ''; ?>"
                        />
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="rule_text">Текст</label>
                    </td>
                    <td>
                        <textarea
                            class="form-control"
                            id="rule_text"
                            name="data[rule_text]"
                            rows="10"
                        ><?= isset($rule_array[0]) ? $rule_array[0]['rule_text'] : ''; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default">Сохранить</button>
        </div>
    </div>
</form>