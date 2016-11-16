<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Опросы</h1>
            </div>
        </div>
        <?php $vote_id = 0; ?>
        <?php foreach ($vote_array as $item) { ?>
            <?php if ($vote_id != $item['vote_id']) { ?>
                <div class="row margin-top">
                    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <a href="/vote.php?num=<?= $item['vote_id']; ?>">
                            <span class="strong"><?= $item['vote_text']; ?></span>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                        <?= $item['votestatus_name']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                        Автор:
                        <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <?= $item['voteanswer_text']; ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                    <?= $item['count_answer']; ?>
                </div>
            </div>
            <?php $vote_id = $item['vote_id']; ?>
        <?php } ?>
    </div>
</div>