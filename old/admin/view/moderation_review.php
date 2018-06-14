<?php
/**
 * @var $review_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header">Обзор тура</h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/moderation_review_ok.php?num=<?= $review_array[0]['review_id']; ?>">
            Одобрить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/moderation_review_update.php?num=<?= $review_array[0]['review_id']; ?>">
            Изменить
        </a>
    </li>
    <li>
        <a class="btn btn-default" href="/admin/moderation_review_delete.php?num=<?= $review_array[0]['review_id']; ?>">
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
                    <a href="/admin/user_view.php?num=<?= $review_array[0]['user_id']; ?>">
                        <?= $review_array[0]['user_login']; ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?= f_igosja_bb_decode($review_array[0]['review_text']); ?>
                </td>
            </tr>
        </table>
    </div>
</div>