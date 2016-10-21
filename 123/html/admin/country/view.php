<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $country_array[0]['country_name']; ?></h3>
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
                    <?= $country_array[0]['country_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Название
                </td>
                <td>
                    <?= $country_array[0]['country_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Флаг
                </td>
                <td>
                    <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/img/country/12/' . $num_get . '.png')) { ?>
                        <img src="/img/country/12/<?= $num_get; ?>.png"/>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>