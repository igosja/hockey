<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $surname_array[0]['surname_name']; ?></h3>
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
                    <?= $surname_array[0]['surname_id']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Фамилия
                </td>
                <td>
                    <?= $surname_array[0]['surname_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Страны
                </td>
                <td>
                    <?php foreach ($country_array as $item) { ?>
                        <a href="/admin/country/view/<?= $item['country_id']; ?>">
                            <?= $item['country_name']; ?>
                        </a>
                        <br/>
                    <?php } ?>
                </td>
            </tr>
        </table>
    </div>
</div>