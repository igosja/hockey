<?php
/**
 * @var $count_page integer
 * @var $new_array array
 * @var $num_get integer
 * @var $page integer
 * @var $total integer
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
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                Всего опросов: <?= $total; ?>
            </div>
        </div>
        <?php if (isset($auth_user_id) && in_array($auth_user_id, array($country_array[0]['president_id'], $country_array[0]['vice_id']))) { ?>
            <?php foreach ($newvote_array as $item) { ?>
                <div class="row border-top">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="row">
                            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                                <a href="/country_vote.php?num=<?= $num_get; ?>&vote_id=<?= $item['vote_id']; ?>">
                                    <span class="strong"><?= $item['vote_text']; ?></span>
                                </a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                                (На модерации)
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-3">
                                Автор:
                                <a href="/user_view.php?num=<?= $num_get; ?>&vote_id=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']; ?>
                                </a>
                            </div>
                        </div>
                        <?php foreach ($item['answer'] as $answer) { ?>
                            <div class="row">
                                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                    <?= $answer['voteanswer_text']; ?>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                                    <?= $answer['voteanswer_count']; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
        <?php foreach ($vote_array as $item) { ?>
            <div class="row border-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                            <a href="/country_vote.php?num=<?= $num_get; ?>&vote_id=<?= $item['vote_id']; ?>">
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
                            <a href="/user_view.php?num=<?= $num_get; ?>&vote_id=<?= $item['user_id']; ?>">
                                <?= $item['user_login']; ?>
                            </a>
                        </div>
                    </div>
                    <?php foreach ($item['answer'] as $answer) { ?>
                        <div class="row">
                            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                                <?= $answer['voteanswer_text']; ?>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                                <?= $answer['voteanswer_count']; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <?php include(__DIR__ . '/include/pagination.php'); ?>
    </div>
</div>