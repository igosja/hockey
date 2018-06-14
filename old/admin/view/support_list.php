<?php
/**
 * @var $num_get integer
 * @var $message_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Обращения в техподдержку</h3>
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
                        <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Время сообщения</th>
                        <th>Пользователь</th>
                        <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                    </tr>
                    <tr id="filters">
                        <td>
                            <label class="hidden" for="message_id"></label>
                            <input
                                class="form-control"
                                id="message_id"
                                name="filter[message_id]"
                                value="<?= f_igosja_request_get('filter', 'message_id'); ?>"
                            />
                        </td>
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
                    <?php foreach ($message_array as $item) { ?>
                        <tr>
                            <td class="text-center"><?= $item['message_id']; ?></td>
                            <td>
                                <?= f_igosja_ufu_date_time($item['message_date']); ?>
                                <?php if (0 == $item['message_read']) { ?>
                                    <i class="fa fa-clock-o fa-fw"></i>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']; ?>
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="/admin/support_view.php?num=<?= $item['user_id']; ?>" class="no-underline">
                                    <i class="fa fa-eye fa-fw"></i>
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