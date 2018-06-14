<?php
/**
 * @var $news_array array
 * @var $num_get integer
 * @var $total integer
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        Всего новостей: <?= $total; ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($news_array as $item) { ?>
            <div class="row border-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                    <?= $item['news_title']; ?>
                    <?php if (isset($auth_user_id) && $item['user_id'] == $auth_user_id && in_array($auth_user_id, array($country_array[0]['president_id'], $country_array[0]['vice_id']))) { ?>
                        <span class="text-size-3 font-grey">
                            <a href="/country_news_update.php?num=<?= $num_get; ?>&news_id=<?= $item['news_id']; ?>">
                                Редактировать
                            </a>
                            |
                            <a href="/country_news_delete.php?num=<?= $num_get; ?>&news_id=<?= $item['news_id']; ?>">
                                Удалить
                            </a>
                        </span>
                    <?php } ?>
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
                    <?= f_igosja_bb_decode($item['news_text']); ?>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?php include(__DIR__ . '/include/pagination.php'); ?>