<?php
/**
 * @var $news_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Новости</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/news_create.php">
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
                        <th class="col-lg-4 col-md-4 col-sm-4 col-xs-4">Дата</th>
                        <th>Заголовок</th>
                        <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                    </tr>
                    <tr id="filters">
                        <td>
                            <label class="hidden" for="news_id"></label>
                            <input
                                class="form-control"
                                id="news_id"
                                name="filter[news_id]"
                                value="<?= f_igosja_request_get('filter', 'news_id'); ?>"
                            />
                        </td>
                        <td></td>
                        <td>
                            <label class="hidden" for="news_title"></label>
                            <input
                                class="form-control"
                                id="news_title"
                                name="filter[news_title]"
                                value="<?= f_igosja_request_get('filter', 'news_title'); ?>"
                            >
                        </td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news_array as $item) { ?>
                        <tr>
                            <td class="text-center"><?= $item['news_id']; ?></td>
                            <td><?= f_igosja_ufu_date_time($item['news_date']); ?></td>
                            <td><?= $item['news_title']; ?></td>
                            <td class="text-center">
                                <a href="/admin/news_view.php?num=<?= $item['news_id']; ?>" class="no-underline">
                                    <i class="fa fa-eye fa-fw"></i>
                                </a>
                                <a href="/admin/news_update.php?num=<?= $item['news_id']; ?>" class="no-underline">
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a>
                                <a href="/admin/news_delete.php?num=<?= $item['news_id']; ?>" class="no-underline">
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