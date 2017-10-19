<?php
/**
 * @var $vote_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
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
        <form method="POST">
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
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input
                            id="answer-<?= $item['voteanswer_id']; ?>"
                            name="data[answer]"
                            type="radio"
                            value="<?= $item['voteanswer_id']; ?>"
                        />
                        <label for="answer-<?= $item['voteanswer_id']; ?>">
                            <?= $item['voteanswer_text']; ?>
                        </label>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Голосовать" />
                </div>
            </div>
        </form>
    </div>
</div>