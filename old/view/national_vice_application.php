<?php
/**
 * @var $applicationplayer_array array
 * @var $c_array array
 * @var $country_array array
 * @var $electionnationalapplication_array array
 * @var $error_array array
 * @var $gk_array array
 * @var $ld_array array
 * @var $lw_array array
 * @var $rd_array array
 * @var $rw_array array
 */
?>
<?php include(__DIR__ . '/include/country_view.php'); ?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Подача заявки на пост заместителя сборной)</h1>
    </div>
</div>
<form method="POST">
    <?php if (isset($error_array)) { ?>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center alert error">
                <?php foreach ($error_array as $item) { ?>
                    <?= $item; ?><br />
                <?php } ?>
            </div>
        </div>
    <?php } ?>
    <div class="row margin-top">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label class="strong" for="application-text">Текст программы:</label>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <textarea
                class="form-control"
                id="application-text"
                name="data[text]"
                required
                rows="5"
            ><?= (isset($data['text']) ? $data['text'] : (isset($electionnationalviceapplication_array[0]['electionnationalviceapplication_text']) ? $electionnationalviceapplication_array[0]['electionnationalviceapplication_text'] : '')); ?></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
            <button type="submit" class="btn margin">
                Сохранить
            </button>
        </div>
    </div>
</form>