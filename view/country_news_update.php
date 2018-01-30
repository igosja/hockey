<?php
/**
 * @var $auth_use_bb integer
 * @var $news_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <form id="news-form" method="POST">
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    <label for="newstitle">Заголовок новости:</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <input class="form-control" id="newstitle" name="data[title]" value="<?= $news_array[0]['news_title']; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center newstitle-error notification-error"></div>
            </div>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
                    <label for="newstext">Текст новости:</label>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <textarea class="form-control" data-bb="<?= $auth_use_bb; ?>" id="newstext" name="data[text]" rows="5"><?= $news_array[0]['news_text']; ?></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center newstext-error notification-error"></div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <button class="btn margin">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>