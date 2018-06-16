<?php
/**
 * @var $auth_use_bb integer
 * @var $auth_user_id integer
 * @var $message_array array
 * @var $limit integer
 * @var $lazy integer
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
        <div class="message-scroll">
            <div id="lazy" data-continue="<?= $lazy; ?>" data-limit="<?= $limit; ?>" data-offset="<?= $limit; ?>"></div>
            <?php foreach ($message_array as $item) { ?>
                <div class="row margin-top">
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 text-size-3">
                        <?= f_igosja_ufu_date_time($item['message_date']); ?>,
                        <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 message <?php if ($auth_user_id == $item['user_id']) { ?>message-from-me<?php } else { ?>message-to-me<?php } ?>">
                        <?= f_igosja_bb_decode($item['message_text']); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <label for="message"><span class="strong">Ваше сообщение:</span></label>
            </div>
        </div>
        <form id="message-form" method="POST">
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" data-bb="<?= $auth_use_bb; ?>" id="message" name="data[text]" rows="5"></textarea>
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