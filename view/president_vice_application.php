<?php
/**
 * @var $error_array array
 * @var $text string
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Подача заявки на пост заместителя президента федерации</h1>
    </div>
</div>
<?php if (isset($error_array)) { ?>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
            <?php foreach ($error_array as $item) { ?>
                <?= $item; ?><br />
            <?php } ?>
        </div>
    </div>
<?php } ?>
<form id="message-form" method="POST">
    <div class="row margin-top">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center strong">
            <label for="message">Ваша программа:</label>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <textarea
                class="form-control"
                id="message"
                name="data[text]"
                rows="5"
        ><?= $text; ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center message-error notification-error"></div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Сохранить" />
        </div>
    </div>
</form>