<?php
/**
 * @var $forummessage_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Сообщение на форуме</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/moderation_forummessage_ok.php?num=<?= $forummessage_array[0]['forummessage_id']; ?>">
            Одобрить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/moderation_forummessage_update.php?num=<?= $forummessage_array[0]['forummessage_id']; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/moderation_forummessage_delete.php?num=<?= $forummessage_array[0]['forummessage_id']; ?>">
            Удалить
        </a>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Автор
                </td>
                <td>
                    <a href="/admin/user_view.php?num=<?= $forummessage_array[0]['user_id']; ?>">
                        <?= $forummessage_array[0]['user_login']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Раздел
                </td>
                <td>
                    <?= $forummessage_array[0]['forumchapter_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Группа
                </td>
                <td>
                    <?= $forummessage_array[0]['forumgroup_name']; ?>
                </td>
            </tr>
            <tr>
                <td class="text-right col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Тема
                </td>
                <td>
                    <?= $forummessage_array[0]['forumtheme_name']; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?= f_igosja_bb_decode($forummessage_array[0]['forummessage_text']); ?>
                </td>
            </tr>
        </table>
    </div>
</div>