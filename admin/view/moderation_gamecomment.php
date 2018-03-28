<?php
/**
 * @var $gamecomment_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Комментарий к матчу</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/moderation_gamecomment_ok.php?num=<?= $gamecomment_array[0]['gamecomment_id']; ?>">
            Одобрить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/moderation_gamecomment_update.php?num=<?= $gamecomment_array[0]['gamecomment_id']; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/moderation_gamecomment_delete.php?num=<?= $gamecomment_array[0]['gamecomment_id']; ?>">
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
                    <a href="/admin/user_view.php?num=<?= $gamecomment_array[0]['user_id']; ?>">
                        <?= $gamecomment_array[0]['user_login']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?= f_igosja_bb_decode($gamecomment_array[0]['gamecomment_text']); ?>
                </td>
            </tr>
        </table>
    </div>
</div>