<?php
/**
 * @var $vote_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Опросы</h1>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <span class="strong"><?= $vote_array[0]['vote_text']; ?></span>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $vote_array[0]['votestatus_name']; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                Автор:
                <a href="/user_view.php?num=<?= $vote_array[0]['user_id']; ?>">
                    <?= $vote_array[0]['user_login']; ?>
                </a>
            </div>
        </div>
        <?php foreach ($vote_array as $item) { ?>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <?= $item['voteanswer_text']; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                    <?= $item['voteanswer_count']; ?>
                    (<?= round($item['voteanswer_count'] / $vote_array[0]['count'] * 100); ?>%)
                </div>
            </div>
        <?php } ?>
    </div>
</div>