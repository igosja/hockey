<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Версия сайта</h3>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <strong>
            Текущая версия
            <?=
            $site_array[0]['site_version_1']
            . '.'
            . $site_array[0]['site_version_2']
            . '.'
            . $site_array[0]['site_version_3']
            . '.'
            . $site_array[0]['site_version_4'];
            ?>
            от
            <?= f_igosja_ufu_date($site_array[0]['site_version_date']); ?>
        </strong>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ul class="list-inline preview-links">
            <li>
                <a href="/admin/site_version.php?num=1">
                    <button class="btn btn-default">+</button>
                </a>
                - Полное или очень существенное переписывание системы
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ul class="list-inline preview-links">
            <li>
                <a href="/admin/site_version.php?num=2">
                    <button class="btn btn-default">+</button>
                </a>
                - Добавление нового функционала или страниц
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ul class="list-inline preview-links">
            <li>
                <a href="/admin/site_version.php?num=3">
                    <button class="btn btn-default">+</button>
                </a>
                - Рефакторинг кода и запросов
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ul class="list-inline preview-links">
            <li>
                <a href="/admin/site_version.php?num=4">
                    <button class="btn btn-default">+</button>
                </a>
                - Исправление багов, опечаток
            </li>
        </ul>
    </div>
</div>