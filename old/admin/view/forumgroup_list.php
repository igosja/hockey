<?php
/**
 * @var $forumchapter_array array
 * @var $forumgroup_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Группы на форуме</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/forumgroup_create.php">
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
                    <th class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">Id</th>
                    <th class="col-lg-5 col-md-5 col-sm-5 col-xs-4">Группа</th>
                    <th>Раздел</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <label class="hidden" for="forumgroup_id"></label>
                        <input
                            class="form-control"
                            id="forumgroup_id"
                            name="filter[forumgroup_id]"
                            value="<?= f_igosja_request_get('filter', 'forumgroup_id'); ?>"
                        />
                    </td>
                    <td>
                        <label class="hidden" for="forumgroup_name"></label>
                        <input
                            class="form-control"
                            id="forumgroup_name"
                            name="filter[forumgroup_name]"
                            value="<?= f_igosja_request_get('filter', 'forumgroup_name'); ?>"
                        >
                    </td>
                    <td>
                        <label class="hidden" for="forumchapter_id"></label>
                        <select class="form-control" id="forumchapter_id" name="filter[forumchapter_id]">
                            <option value="">Все</option>
                            <?php foreach ($forumchapter_array as $item) { ?>
                                <option
                                    value="<?= $item['forumchapter_id']; ?>"
                                    <?php if (f_igosja_request_get('filter', 'forumchapter_id') == $item['forumchapter_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['forumchapter_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($forumgroup_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['forumgroup_id']; ?></td>
                        <td><?= $item['forumgroup_name']; ?></td>
                        <td>
                            <a href="/admin/forumchapter_view.php?num=<?= $item['forumchapter_id']; ?>">
                                <?= $item['forumchapter_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/admin/forumgroup_view.php?num=<?= $item['forumgroup_id']; ?>" class="no-underline">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <a href="/admin/forumgroup_update.php?num=<?= $item['forumgroup_id']; ?>" class="no-underline">
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>
                            <a href="/admin/forumgroup_delete.php?num=<?= $item['forumgroup_id']; ?>" class="no-underline">
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