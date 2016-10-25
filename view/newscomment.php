<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row margin-top">
            <div class="col-lg-2 col-md-3 col-sm-3 col-xs-12 text-center">
                <?= f_igosja_ufu_date_time($news_array[0]['news_date']); ?>
                <br/>
                <a href="/user_view.php?num=<?= $news_array[0]['user_id']; ?>">
                    <?= $news_array[0]['user_login']; ?>
                </a>
            </div>
            <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
                <span class="strong"><?= $news_array[0]['news_title']; ?></span>
                <br/>
                <?= $news_array[0]['news_text']; ?>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <span class="strong">Последние комментарии:</span>
            </div>
        </div>
        <?php foreach ($newscomment_array as $item) { ?>
            <div class="row border-top margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                    <?= f_igosja_ufu_date_time($item['newscomment_date']); ?>,
                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= $item['newscomment_text']; ?>
                </div>
            </div>
        <?php } ?>
        <?php if (isset($auth_user_id)) { ?>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <label for="newscomment_text"><span class="strong">Ваш комментарий:</span></label>
                </div>
            </div>
            <form method="POST">
                <div class="row margin-top">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <textarea class="form-control" id="newscomment_text" name="data[text]" rows="5"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                        <input class="btn margin" type="submit" value="Комментировать">
                    </div>
                </div>
            </form>
        <?php } ?>
    </div>
</div>