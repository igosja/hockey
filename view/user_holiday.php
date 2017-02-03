<div class="row margin-top">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?php include(__DIR__ . '/include/user_profile_top_left.php'); ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-size-1 strong">
                Анкетные данные
            </div>
        </div>
        <?php include(__DIR__ . '/include/user_profile_top_right.php'); ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php include(__DIR__ . '/include/user_table_link.php'); ?>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 table-responsive">
        <table class="table">
            <tr>
                <th>Отпуск менеджера</th>
            </tr>
        </table>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <label for="holiday">
                Поставьте здесь галочку, если собираетесь уехать в отпуск и временно не сможете управлять своими командами:
            </label>
            <input name="data[user_holiday]" type="hidden" value="0" />
            <input
                id="holiday"
                name="data[user_holiday]"
                type="checkbox"
                value="1"
                <?php if ($holiday_array[0]['user_holiday']) { ?>
                    checked
                <?php } ?>
            />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <p class="text-center">
                <button type="submit" class="btn">
                    Сохранить
                </button>
            </p>
        </div>
    </div>
</form>