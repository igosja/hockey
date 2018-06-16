<?php
/**
 * @var $user_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Пользователи</h3>
    </div>
</div>
<form>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <?php include(__DIR__ . '/include/summary.php'); ?>
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">Id</th>
                    <th>Пользователь</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <label class="hidden" for="user_id"></label>
                        <input
                            class="form-control"
                            id="user_id"
                            name="filter[user_id]"
                            value="<?= f_igosja_request_get('filter', 'user_id'); ?>"
                        />
                    </td>
                    <td>
                        <label class="hidden" for="user_login"></label>
                        <input
                            class="form-control"
                            id="user_login"
                            name="filter[user_login]"
                            value="<?= f_igosja_request_get('filter', 'user_login'); ?>"
                        >
                    </td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($user_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['user_id']; ?></td>
                        <td><?= $item['user_login']; ?></td>
                        <td class="text-center">
                            <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>" class="no-underline">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <a href="/admin/user_update.php?num=<?= $item['user_id']; ?>" class="no-underline">
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