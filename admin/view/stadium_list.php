<?php
/**
 * @var $city_array array
 * @var $country_array array
 * @var $stadium_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Стадионы</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/stadium_create.php">
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
                    <th>Стадион</th>
                    <th class="col-lg-3 col-md-3 col-sm-3 col-xs-2">Город</th>
                    <th class="col-lg-3 col-md-3 col-sm-3 col-xs-3">Страна</th>
                    <th class="col-lg-1 col-md-2 col-sm-2 col-xs-2 text-center"></th>
                </tr>
                <tr id="filters">
                    <td>
                        <label class="hidden" for="stadium_id"></label>
                        <input
                            class="form-control"
                            id="stadium_id"
                            name="filter[stadium_id]"
                            value="<?= f_igosja_request_get('filter', 'stadium_id'); ?>"
                        />
                    </td>
                    <td>
                        <label class="hidden" for="stadium_name"></label>
                        <input
                            class="form-control"
                            id="stadium_name"
                            name="filter[stadium_name]"
                            value="<?= f_igosja_request_get('filter', 'stadium_name'); ?>"
                        >
                    </td>
                    <td>
                        <label class="hidden" for="city_id"></label>
                        <select class="form-control" id="city_id" name="filter[city_id]">
                            <option value="">Все</option>
                            <?php foreach ($city_array as $item) { ?>
                                <option
                                    value="<?= $item['city_id']; ?>"
                                    <?php if (f_igosja_request_get('filter', 'city_id') == $item['city_id']) { ?>
                                        selected
                                    <?php } ?>
                                >
                                    <?= $item['city_name']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </td>
                    <td>
                        <label class="hidden" for="country_id"></label>
                        <select class="form-control" id="country_id" name="filter[country_id]">
                            <option value="">Все</option>
                            <?php foreach ($country_array as $item) { ?>
                                <option
                                    value="<?= $item['country_id']; ?>"
                                    <?php if (f_igosja_request_get('filter', 'country_id') == $item['country_id']) { ?>
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
                            <a href="/admin/city_view.php?num=<?= $item['city_id']; ?>">
                                <?= $item['city_name']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="/admin/country_view.php?num=<?= $item['country_id']; ?>">
                                <?= $item['country_name']; ?>
                            </a>
                        </td>
                        <td class="text-center">
                            <a href="/admin/stadium_view.php?num=<?= $item['stadium_id']; ?>" class="no-underline">
                                <i class="fa fa-eye fa-fw"></i>
                            </a>
                            <a href="/admin/stadium_update.php?num=<?= $item['stadium_id']; ?>" class="no-underline">
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>
                            <a href="/admin/stadium_delete.php?num=<?= $item['stadium_id']; ?>" class="no-underline">
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