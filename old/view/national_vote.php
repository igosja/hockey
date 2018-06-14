<?php
/**
 * @var $electionnational_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                <h1>Выборы тренера сборной</h1>
            </div>
        </div>
        <div class="row margin-top">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
                <?= $electionnational_array[0]['electionstatus_name']; ?>
            </div>
        </div>
        <?php foreach ($electionnational_array as $item) { ?>
            <div class="row margin-top">
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
                    <?php if (0 != $item['user_id']) { ?>
                        <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                            <?= $item['user_login']; ?>
                        </a>
                    <?php } else { ?>
                        Против всех
                    <?php } ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
                    <?= $item['electionnationalapplication_count']; ?>
                    (<?= round($item['electionnationalapplication_count'] / $electionnational_array[0]['count'] * 100); ?>%)
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
                        Рейтинг менеджера:
                        <?= $item['userrating_rating']; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        Текст программы:
                        <br/>
                        <?= nl2br($item['electionnationalapplication_text']); ?>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>