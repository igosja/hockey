<?php
/**
 * @var $count_page integer
 * @var $news_array array
 * @var $total integer
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Новости</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        Всего новостей: <?= $total; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($news_array as $item) { ?>
            <div class="row border-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                    <?= $item['news_title']; ?>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3 font-grey">
                    <?= f_igosja_ufu_date_time($item['news_date']); ?>
                    -
                    <a class="strong" href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                    -
                    <a class="strong text-size-3" href="/newscomment.php?num=<?= $item['news_id']; ?>">
                        Комментариев: <?= $item['count_newscomment']; ?>
                    </a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= $item['news_text']; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php include(__DIR__ . '/include/pagination.php'); ?>