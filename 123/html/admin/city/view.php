<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $city_array[0]['city_name']; ?></h3>
    </div>
</div>
<?php include(__DIR__ . '/../../include/admin/button/list-edit-delete.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Id
                </td>
                <td>
                    <?= $city_array[0]['city_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Название
                </td>
                <td>
                    <?= $city_array[0]['city_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Страна
                </td>
                <td>
                    <a href="/admin/country/view/<?= $city_array[0]['country_id']; ?>">
                        <?= $city_array[0]['country_name']; ?>
                    </a>
                </td>
            </tr>
        </table>
    </div>
</div>