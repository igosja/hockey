<?php
/**
 * @var $prenews_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">
            Предварительные новости
        </h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/prenews_view.php">
            Просмотр
        </a>
    </li>
</ul>
<form class="form-horizontal" method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
            <table class="table table-striped table-bordered table-hover table-condensed">
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="prenews_new">Новое на сайте</label>
                    </td>
                    <td>
                        <textarea
                            class="form-control"
                            id="prenews_new"
                            name="data[prenews_new]"
                            rows="10"
                        ><?= $prenews_array[0]['prenews_new']; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <label class="control-label" for="prenews_error">Работа над ошибками</label>
                    </td>
                    <td>
                        <textarea
                            class="form-control"
                            id="prenews_error"
                            name="data[prenews_error]"
                            rows="10"
                        ><?= $prenews_array[0]['prenews_error']; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <button class="btn btn-default">Сохранить</button>
        </div>
    </div>
</form>