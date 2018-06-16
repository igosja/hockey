<?php
/**
 * @var $teamask_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Заявки на команды</h3>
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
                    <th>Время заявки</th>
                    <th class="col-lg-4 col-md-3 col-sm-3 col-xs-3">Пользователь</th>
                    <th class="col-lg-4 col-md-3 col-sm-3 col-xs-3">Команда</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <label class="hidden" for="teamask_id"></label>
                        <input
                            class="form-control"
                            id="teamask_id"
                            name="filter[teamask_id]"
                            value="<?= f_igosja_request_get('filter', 'teamask_id'); ?>"
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
                    <td>
                        <label class="hidden" for="team_name"></label>
                        <input
                            class="form-control"
                            id="team_name"
                            name="filter[team_name]"
                            value="<?= f_igosja_request_get('filter', 'team_name'); ?>"
                        >
                    </td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($teamask_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['teamask_id']; ?></td>
                        <td><?= f_igosja_ufu_date_time($item['teamask_date']); ?></td>
                        <td>
                            <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>">
                                <?= $item['user_login']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="/admin/team_view.php?num=<?= $item['team_id']; ?>">
                                <?= $item['team_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/admin/teamask_view.php?num=<?= $item['teamask_id']; ?>" class="no-underline">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <a href="/admin/teamask_delete.php?num=<?= $item['teamask_id']; ?>" class="no-underline">
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