<?php
/**
 * @var $message_array array
 * @var $user_login string
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h3 class="page-header"><?= $user_login; ?></h3>
    </div>
</div>
<ul class="list-inline preview-links text-center">
    <li>
        <a class="btn btn-default" href="/admin/support_list.php">
            Список
        </a>
    </li>
</ul>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table table-striped table-bordered table-hover table-condensed">
            <?php foreach ($message_array as $item) { ?>
                <tr>
                    <td class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= f_igosja_ufu_date_time($item['message_date']); ?>,
                        <a href="/admin/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                        <br/>
                        <?= f_igosja_bb_decode($item['message_text']); ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <label for="message_text">Сообщение:</label>
            <textarea class="form-control" id="message_text" name="data[text]" rows="5"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn btn-default" type="submit" value="Отправить"/>
        </div>
    </div>
</form>