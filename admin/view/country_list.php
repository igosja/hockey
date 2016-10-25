<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Страны</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a href="/admin/country_create.php">
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
                    <th>Страна</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <input
                            class="form-control"
                            name="filter[country_id]"
                            type="text"
                            value="<?= f_igosja_get('filter', 'country_id'); ?>"
                        />
                    </td>
                    <td>
                        <input
                            class="form-control"
                            name="filter[country_name]"
                            type="text"
                            value="<?= f_igosja_get('filter', 'country_name'); ?>"
                        >
                    </td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($country_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['country_id']; ?></td>
                        <td><?= $item['country_name']; ?></td>
                        <td class="text-center">
                            <a href="/admin/country_view.php?num=<?= $item['country_id']; ?>" class="no-underline">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <a href="/admin/country_update.php?num=<?= $item['country_id']; ?>" class="no-underline">
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>
                            <a href="/admin/country_delete.php?num=<?= $item['country_id']; ?>" class="no-underline">
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