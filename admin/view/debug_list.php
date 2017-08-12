<?php
/**
 * @var $debug_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Debugger</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/debug_truncate.php">
            Очистить
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
                    <th>Запрос</th>
                    <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Время</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <label class="hidden" for="debug_sql"></label>
                        <input
                            class="form-control"
                            id="debug_sql"
                            name="filter[debug_sql]"
                            value="<?= f_igosja_request_get('filter', 'debug_sql'); ?>"
                        >
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($debug_array as $item) { ?>
                    <tr>
                        <td><?= nl2br($item['debug_sql']); ?></td>
                        <td>
                            <?= $item['debug_time']; ?> мс
                        </td>
                        <td class="text-center">
                            <a href="/admin/debug_delete.php?num=<?= $item['debug_id']; ?>" class="no-underline">
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