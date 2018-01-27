<?php
/**
 * @var $count_page integer
 * @var $message_array array
 * @var $page integer
 * @var $total integer
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Техподдержка
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form method="GET">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Всего сообщений: <?= $total; ?>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-4 text-right">
                    <label for="page">Страница:</label>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-2">
                    <select class="form-control" name="page" id="page">
                        <?php for ($i=1; $i<=$count_page; $i++) { ?>
                            <option
                                value="<?= $i; ?>"
                                <?php if ($page == $i) { ?>
                                    selected
                                <?php } ?>
                            >
                                <?= $i; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </form>
        <?php foreach ($message_array as $item) { ?>
            <div class="row border-top">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-size-3">
                    <?= f_igosja_ufu_date_time($item['message_date']); ?>,
                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
                    <a href="/support_delete.php?num=<?= $item['message_id']; ?>" title="Удалить сообщение">
                        &times;
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= f_igosja_bb_decode($item['message_text']); ?>
                </div>
            </div>
        <?php } ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <label for="message"><span class="strong">Ваше сообщение:</span></label>
            </div>
        </div>
        <form id="message-form" method="POST">
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" id="message" name="data[text]" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center message-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Отправить">
                </div>
            </div>
        </form>
    </div>
</div>