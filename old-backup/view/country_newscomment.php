<?php
/**
 * @var $auth_blockcomment_text string
 * @var $auth_blocknews_text string
 * @var $auth_date_block_comment integer
 * @var $auth_date_block_newscomment integer
 * @var $auth_user_id integer
 * @var $auth_userrole_id integer
 * @var $news_array array
 * @var $news_id integer
 * @var $newscomment_array array
 * @var $num_get integer
 * @var $total integer
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2>Комментарии к новостям</h2>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
        <?= $news_array[0]['news_title']; ?>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
        <?= f_igosja_ufu_date_time($news_array[0]['news_date']); ?>
        -
        <a class="strong" href="/user_view.php?num=<?= $news_array[0]['user_id']; ?>">
            <?= $news_array[0]['user_login']; ?>
        </a>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?= f_igosja_bb_decode($news_array[0]['news_text']); ?>
    </div>
</div>
<?php if ($newscomment_array) { ?>
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <span class="strong">Последние комментарии:</span>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            Всего комментариев: <?= $total; ?>
        </div>
    </div>
    <?php foreach ($newscomment_array as $item) { ?>
        <div class="row border-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-2">
                <a class="strong" href="/user_view.php?num=<?= $item['user_id']; ?>">
                    <?= $item['user_login']; ?>
                </a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= nl2br($item['newscomment_text']); ?>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
                <?= f_igosja_ufu_date_time($item['newscomment_date']); ?>
                <?php if (isset($auth_user_id) && USERROLE_USER != $auth_userrole_id) { ?>
                    |
                    <a href="/newscomment_delete.php?num=<?= $item['newscomment_id']; ?>&news_id=<?= $news_id; ?>&country_id=<?= $num_get; ?>">
                        Удалить
                    </a>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <?php include(__DIR__ . '/include/pagination.php'); ?>
<?php } ?>
<?php if (isset($auth_user_id)) { ?>
    <?php if ($auth_date_block_newscomment < time() && $auth_date_block_comment < time()) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                <label for="newscomment">Ваш комментарий:</label>
            </div>
        </div>
        <form id="newscomment-form" method="POST">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" id="newscomment" name="data[text]" rows="5"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center newscomment-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <button class="btn margin">Комментировать</button>
                </div>
            </div>
        </form>
    <?php } elseif ($auth_date_block_newscomment >= time()) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию новостей до <?= f_igosja_ufu_date_time($auth_date_block_newscomment); ?>.
                <br/>
                Причина - <?= $auth_blocknews_text; ?>
            </div>
        </div>
    <?php } elseif ($auth_date_block_comment >= time()) { ?>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert warning">
                Вам заблокирован доступ к комментированию новостей до <?= f_igosja_ufu_date_time($auth_date_block_comment); ?>.
                <br/>
                Причина - <?= $auth_blockcomment_text; ?>
            </div>
        </div>
    <?php } ?>
<?php } ?>