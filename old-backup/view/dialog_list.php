<?php
/**
 * @var $message_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Личные сообщения
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php foreach ($message_array as $item) { ?>
            <div class="row border-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
                    <a href="/user_view.php?num=<?= $item['user_id']; ?>">
                        <?= $item['user_login']; ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Последний визит: <?= f_igosja_ufu_last_visit($item['user_date_login']); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    Рейтинг: <span class="strong"><?= $item['user_rating']; ?></span>
                </div>
            </div>
            <?php if ($item['team_id']) { ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        Команда:
                        <img alt="<?= $item['country_name']; ?>" src="/img/country/12/<?= $item['country_id']; ?>.png" title="country" />
                        <a href="/team_view.php?num=<?= $item['team_id']; ?>">
                            <?= $item['team_name']; ?>
                            <span class="hidden-xs">(<?= $item['city_name']; ?>)</span>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?php if (0 == $item['message_read']) { ?>
                        <a class="strong" href="/dialog.php?num=<?= $item['user_id']; ?>">Читать новые</a>
                        |
                    <?php } ?>
                    <a href="/dialog.php?num=<?= $item['user_id']; ?>">Написать</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>