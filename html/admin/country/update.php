<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            <?php if (isset($country_array[0]['country_name'])) { ?>
                <?= $country_array[0]['country_name']; ?>
            <?php } else { ?>
                Создание страны
            <?php } ?>
        </h3>
    </div>
</div>
<?php include(__DIR__ . '/../../include/admin/button/list-view.php'); ?>
<form class="form-horizontal" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="country_name">Название</label>
                    </td>
                    <td>
                        <input
                            class="form-control"
                            id="country_name"
                            name="data[country_name]"
                            value=
                            "<?= isset($country_array[0]['country_name']) ? $country_array[0]['country_name']:''; ?>"
                        >
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default" type="submit">Сохранить</button>
        </div>
    </div>
</form>