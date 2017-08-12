<?php
/**
 * @var $rule_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Правила</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/rule_create.php">
            Создать
        </a>
    </li>
</ul>
<form>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <?php include(__DIR__ . '/include/summary.php'); ?>
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                    <tr>
                        <th class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">Id</th>
                        <th>Заголовок</th>
                        <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                    </tr>
                    <tr id="filters">
                        <td>
                            <label class="hidden" for="rule_id"></label>
                            <input
                                class="form-control"
                                id="rule_id"
                                name="filter[rule_id]"
                                value="<?= f_igosja_request_get('filter', 'rule_id'); ?>"
                            />
                        </td>
                        <td>
                            <label class="hidden" for="rule_title"></label>
                            <input
                                class="form-control"
                                id="rule_title"
                                name="filter[rule_title]"
                                value="<?= f_igosja_request_get('filter', 'rule_title'); ?>"
                            >
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rule_array as $item) { ?>
                        <tr>
                            <td class="text-center"><?= $item['rule_id']; ?></td>
                            <td><?= $item['rule_title']; ?></td>
                            <td class="text-center">
                                <a href="/admin/rule_view.php?num=<?= $item['rule_id']; ?>" class="no-underline">
                                    <i class="fa fa-eye fa-fw"></i>
                                </a>
                                <a href="/admin/rule_update.php?num=<?= $item['rule_id']; ?>" class="no-underline">
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <a href="/admin/rule_delete.php?num=<?= $item['rule_id']; ?>" class="no-underline">
                                    <i class="fa fa-trash fa-fw"></i>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</form>
<?php include(__DIR__ . '/include/pagination.php'); ?>