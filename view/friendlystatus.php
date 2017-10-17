<?php
/**
 * @var $friendlystatus_array array
 * @var $team_array array
 */
?>
<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-size-1">
                <?= $team_array[0]['team_name']; ?>
                (<?= $team_array[0]['city_name']; ?>, <?= $team_array[0]['country_name']; ?>)
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong text-right text-size-1">
                Организация товарищеских матчей
            </div>
        </div>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 strong">
        Ваш статус в товарищеских матчах:
    </div>
</div>
<form method="POST">
    <div class="row">
        <?php foreach ($friendlystatus_array as $item) { ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <input
                    id="friendlystatus-<?= $item['friendlystatus_id']; ?>"
                    name="data[friendlystatus_id]"
                    type="radio"
                    value="<?= $item['friendlystatus_id']; ?>"
                    <?php if ($item['friendlystatus_id'] == $team_array[0]['user_friendlystatus_id']) { ?>
                        checked
                    <?php } ?>
                />
                <label for="friendlystatus-<?= $item['friendlystatus_id']; ?>">
                    <?= $item['friendlystatus_name']; ?>
                </label>
            </div>
        <?php } ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <p>
                <button class="btn" type="submit">
                    Сохранить
                </button>
                <a class="btn" href="friendly.php">Назад</a>
            </p>
        </div>
    </div>
</form>