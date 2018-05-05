<?php
/**
 * @var $electionpresident_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h2>Выборы президента федерации</h2>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $electionpresident_array[0]['electionstatus_name']; ?>
            </div>
        </div>
        <form method="POST">
            <?php foreach ($electionpresident_array as $item) { ?>
                <div class="row border-top">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <input
                            id="answer-<?= $item['electionpresidentapplication_id']; ?>"
                            name="data[answer]"
                            type="radio"
                            value="<?= $item['electionpresidentapplication_id']; ?>"
                        />
                        <label for="answer-<?= $item['electionpresidentapplication_id']; ?>">
                            <?php if (0 != $item['user_id']) { ?>
                                <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                                    <?= $item['user_login']; ?>
                                </a>
                            <?php } else { ?>
                                Против всех
                            <?php } ?>
                        </label>
                    </div>
                </div>
                <?php if (0 != $item['user_id']) { ?>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            Дата регистрации:
                            <?= f_igosja_ufu_date($item['user_date_register']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <?= nl2br($item['electionpresidentapplication_text']); ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <input class="btn margin" type="submit" value="Голосовать" />
                </div>
            </div>
        </form>
    </div>
</div>