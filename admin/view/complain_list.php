<?php
/**
 * @var $num_get integer
 * @var $complain_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Жалобы на форуме</h3>
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
                        <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Время жалобы</th>
                        <th>Сообщение</th>
                        <th>Пользователь</th>
                        <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                    </tr>
                    <tr id="filters">
                        <td>
                            <label class="hidden" for="complain_id"></label>
                            <input
                                class="form-control"
                                id="complain_id"
                                name="filter[complain_id]"
                                value="<?= f_igosja_request_get('filter', 'complain_id'); ?>"
                            />
                        </td>
                        <td></td>
                        <td></td>
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
                    <?php foreach ($complain_array as $item) { ?>
                        <tr>
                            <td class="text-center"><?= $item['complain_id']; ?></td>
                            <td>
                                <?= f_igosja_ufu_date_time($item['complain_date']); ?>
                            </td>
                            <td>
                                <a href="<?= $item['complain_url']; ?>" target="_blank">
                                    <?= $item['complain_url']; ?>
                                </a>
                            </td>
                            <td>
                                <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="/admin/complain_delete.php?num=<?= $item['complain_id']; ?>" class="no-underline">
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