<?php
/**
 * @var $auth_user_id integer
 * @var $count_page integer
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
    <form method="GET">
        <input type="hidden" name="num" value="<?= $num_get; ?>">
        <input type="hidden" name="news_id" value="<?= $news_id; ?>">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                Всего комментариев: <?= $total; ?>
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
            </div>
        </div>
    <?php } ?>
<?php } ?>
<?php if (isset($auth_user_id)) { ?>
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
<?php } ?>