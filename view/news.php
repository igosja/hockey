<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h1>Новости</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($news_array as $item) { ?>
            <div class="row margin-top">
                <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 text-center">
                    <?= f_igosja_ufu_date_time($item['news_date']); ?>
                    <br/>
                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                    <br/>
                    <a class="text-size-3" href="/newscomment.php?num=<?= $item['news_id']; ?>">
                        Комментариев: <?= $item['count_newscomment']; ?>
                    </a>
                </div>
                <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
                    <span class="strong"><?= $item['news_title']; ?></span>
                    <br/>
                    <?= $item['news_text']; ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>