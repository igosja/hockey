<?php
/**
 * @var $count_page integer
 * @var $news_array array
 * @var $num_get integer
 * @var $total integer
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<form method="GET">
    <input name="num" type="hidden" value="<?= $num_get; ?>">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            Всего новостей: <?= $total; ?>
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
                    <a class="strong text-size-3" href="/country_newscomment.php?num=<?= $num_get; ?>&news_id=<?= $item['news_id']; ?>">
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