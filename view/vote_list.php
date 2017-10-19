<?php
/**
 * @var $count_page integer
 * @var $page integer
 * @var $total integer
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
        <form method="GET">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    Всего опросов: <?= $total; ?>
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
        <?php foreach ($vote_array as $item) { ?>
            <div class="row border-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="row">
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
    </div>
</div>