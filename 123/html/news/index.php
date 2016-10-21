<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($news_array as $item) { ?>
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                    <?= f_igosja_ufu_date_time($item['date']); ?>
                </div>
                <div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
                            <?= $item['title']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= $item['text']; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= $item['user_login']; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>