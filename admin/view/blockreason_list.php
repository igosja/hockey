<?php
/**
 * @var $blockreason_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Причины блокировки</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/blockreason_create.php">
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
                    <th>Причины блокировки</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <label class="hidden" for="blockreason_id"></label>
                        <input
                            class="form-control"
                            id="blockreason_id"
                            name="filter[blockreason_id]"
                            value="<?= f_igosja_request_get('filter', 'blockreason_id'); ?>"
                        />
                    </td>
                    <td>
                        <label class="hidden" for="blockreason_name"></label>
                        <input
                            class="form-control"
                            id="blockreason_name"
                            name="filter[blockreason_text]"
                            value="<?= f_igosja_request_get('filter', 'blockreason_text'); ?>"
                        >
                    </td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($blockreason_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['blockreason_id']; ?></td>
                        <td><?= $item['blockreason_text']; ?></td>
                        <td class="text-center">
                            <a href="/admin/blockreason_view.php?num=<?= $item['blockreason_id']; ?>" class="no-underline">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <a href="/admin/blockreason_update.php?num=<?= $item['blockreason_id']; ?>" class="no-underline">
                                <i class="fa fa-pencil fa-fw"></i>
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