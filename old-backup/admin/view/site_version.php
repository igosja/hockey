<?php
/**
 * @var $site_array array
 */
?>
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
                <a class="btn btn-default" href="/admin/site_version.php?num=1">
                    +
                </a>
                - Полное или очень существенное переписывание системы, многоязычность
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ul class="list-inline preview-links">
            <li>
                <a class="btn btn-default" href="/admin/site_version.php?num=2">
                    +
                </a>
                - Добавление новых крупных разделов
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ul class="list-inline preview-links">
            <li>
                <a class="btn btn-default" href="/admin/site_version.php?num=3">
                    +
                </a>
                - Добавления нового функционала на страницах
            </li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <ul class="list-inline preview-links">
            <li>
                <a class="btn btn-default" href="/admin/site_version.php?num=4">
                    +
                </a>
                - Исправление опечаток, багов без изменения функционала, рефакторинг кода и запросов, вывод дополнительной стратистики в таблицах и графиках
            </li>
        </ul>
    </div>
</div>