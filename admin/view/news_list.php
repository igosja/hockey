<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Новости</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a href="/admin/news_create.php">
            <button class="btn btn-default">Создать</button>
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
                        <th>Дата</th>
                        <th>Заголовок</th>
                        <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                    </tr>
                    <tr id="filters">
                        <td>
                            <input
                                class="form-control"
                                name="filter[news_id]"
                                type="text"
                                value="<?= f_igosja_get('filter', 'news_id'); ?>"
                            />
                        </td>
                        <td></td>
                        <td>
                            <input
                                class="form-control"
                                name="filter[news_title]"
                                type="text"
                                value="<?= f_igosja_get('filter', 'news_title'); ?>"
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