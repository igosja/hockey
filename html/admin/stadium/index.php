<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Города</h3>
    </div>
</div>
<?php include(__DIR__ . '/../../include/admin/button/create.php'); ?>
<form>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <?php include(__DIR__ . '/../../include/admin/summary.php'); ?>
            <table class="table table-striped table-bordered table-hover table-condensed">
                <thead>
                <tr>
                    <th class="col-lg-1 col-md-1 col-sm-1 col-xs-2 text-center">Id</th>
                    <th>Стадион</th>
                    <th>Город</th>
                    <th>Страна</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <input
                            class="form-control"
                            name="filter[stadium_id]"
                            type="text"
                            value="<?= f_igosja_get('filter', 'stadium_id'); ?>"
                        />
                    </td>
                    <td>
                        <input
                            class="form-control"
                            name="filter[stadium_name]"
                            type="text"
                            value="<?= f_igosja_get('filter', 'stadium_name'); ?>"
                        >
                    </td>
                    <td>
                        <select class="form-control" name="filter[city_id]">
                            <option value="">Все</option>
                            <?php foreach ($city_array as $item) { ?>
                                <option
                                    value="<?= $item['city_id']; ?>"
                                    <?php if (f_igosja_get('filter', 'city_id') == $item['city_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['city_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control" name="filter[country_id]">
                            <option value="">Все</option>
                            <?php foreach ($country_array as $item) { ?>
                                <option
                                    value="<?= $item['country_id']; ?>"
                                    <?php if (f_igosja_get('filter', 'country_id') == $item['country_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['country_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($stadium_array as $item) { ?>
                    <tr>
                        <td class="text-center"><?= $item['stadium_id']; ?></td>
                        <td><?= $item['stadium_name']; ?></td>
                        <td>
                            <a href="/admin/city/view/<?= $item['city_id']; ?>">
                                <?= $item['city_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="/admin/country/view/<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/admin/stadium/view/<?= $item['stadium_id']; ?>" class="no-underline">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <a href="/admin/stadium/update/<?= $item['stadium_id']; ?>" class="no-underline">
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>
                            <a href="/admin/stadium/delete/<?= $item['stadium_id']; ?>" class="no-underline">
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
<?php include(__DIR__ . '/../../include/admin/pagination.php'); ?>