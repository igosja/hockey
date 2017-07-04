<?php
/**
 * @var $country_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <h1>Подача заявки на управление сборной</h1>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right xs-text-center">
            <label class="strong" for="application-country">Страна:</label>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <select
                class="form-control"
                id="application-country"
                name="country_id"
            >
                <?php foreach ($country_array as $item) { ?>
                    <option value="<?= $item['country_id']; ?>">
                        <?= $item['country_name']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right xs-text-center">
            <button type="submit" class="btn margin">
                Далее
            </button>
        </div>
    </div>
</form>