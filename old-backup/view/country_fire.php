<?php
/**
 * @var $num_get integer
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <table class="table table-bordered">
            <tr>
                <th>Отказ от должности</th>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <p>Вы собираетесь отказаться от своей должности в федерации</p>
        <a class="btn" href="?num=<?= $num_get; ?>&ok=1">Отказаться от должности</a>
    </div>
</div>