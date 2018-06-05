<?php
/**
 * @var $prenews_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Предварительные новости</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/prenews_update.php">
            Изменить
        </a>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Новое на сайте
                </td>
                <td>
                    <?= $prenews_array[0]['prenews_new']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Работа над ошибками
                </td>
                <td>
                    <?= $prenews_array[0]['prenews_error']; ?>
                </td>
            </tr>
        </table>
    </div>
</div>