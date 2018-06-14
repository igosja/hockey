<?php
/**
 * @var $auth_relation_id integer
 * @var $auth_relation_name string
 * @var $auth_user_id integer
 * @var $country_array array
 * @var $file_name string
 * @var $rating_negative integer
 * @var $rating_neutral integer
 * @var $rating_positive integer
 * @var $relation_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>
            <?= $country_array[0]['country_name']; ?>
        </h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/country_table_link.php'); ?>
    </div>
</div>
<?php if ('country_national' == $file_name) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <?php include(__DIR__ . '/country_table_national_link.php'); ?>
        </div>
    </div>
<?php } ?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Президент:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php if ($country_array[0]['president_id']) { ?>
            <a href="/user_view.php?num=<?= $country_array[0]['president_id']; ?>">
                <?= $country_array[0]['president_login']; ?>
            </a>
        <?php } else { ?>
            -
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Последний визит:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?= f_igosja_ufu_last_visit($country_array[0]['president_date_login']); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Рейтинг президента:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <span class="font-green"><?= $rating_positive; ?>%</span>
        |
        <span class="font-yellow"><?= $rating_neutral; ?>%</span>
        |
        <span class="font-red"><?= $rating_negative; ?>%</span>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Заместитель президента:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?php if ($country_array[0]['vice_id']) { ?>
            <a href="/user_view.php?num=<?= $country_array[0]['vice_id']; ?>">
                <?= $country_array[0]['vice_login']; ?>
            </a>
        <?php } else { ?>
            -
        <?php } ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Последний визит:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?= f_igosja_ufu_last_visit($country_array[0]['vice_date_login']); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right strong">
        Фонд федерации:
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <?= f_igosja_money_format($country_array[0]['country_finance']); ?>
    </div>
</div>
<?php if (isset($relation_array)) { ?>
    <form method="post">
        <div class="row text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 relation-head">
                Ваше отношение к президенту федерации:
                <a href="javascript:" id="relation-link"><?= $auth_relation_name; ?></a>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 relation-body hidden">
                <div class="row text-left">
                    <div class="col-lg-3 col-md-3 col-sm-2"></div>
                    <?php foreach ($relation_array as $item) { ?>
                        <div class="hidden-lg hidden-md hidden-sm col-xs-3"></div>
                        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-9">
                            <input
                                id="rating-<?= $item['relation_id']; ?>"
                                name="data[vote_president]"
                                type="radio"
                                value="<?= $item['relation_id']; ?>"
                                <?php if ($auth_relation_id == $item['relation_id']) { ?>
                                    checked
                                <?php } ?>
                            />
                            <label for="rating-<?= $item['relation_id']; ?>"><?= $item['relation_name']; ?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <p>
                            <input type="submit" class="btn" value="Изменить отношение"/>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } ?>
<?php if (isset($auth_user_id) && in_array($auth_user_id, array($country_array[0]['president_id'], $country_array[0]['vice_id']))) { ?>
    <div class="row margin">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert info">
            <a href="/country_news_create.php?num=<?= $num_get; ?>">
                Создать новость
            </a>
            |
            <a href="/country_vote_create.php?num=<?= $num_get; ?>">
                Создать опрос
            </a>
            <?php if ($auth_user_id == $country_array[0]['president_id']) { ?>
                |
                <a href="/country_transfermoney.php?num=<?= $num_get; ?>">
                    Распределить фонд
                </a>
            <?php } ?>
            <?php if (($auth_user_id == $country_array[0]['president_id'] && $country_array[0]['vice_id']) || $auth_user_id == $country_array[0]['vice_id']) { ?>
                |
                <a href="/country_fire.php?num=<?= $num_get; ?>">
                    Отказаться от должности
                </a>
            <?php } ?>
        </div>
    </div>
<?php } ?>