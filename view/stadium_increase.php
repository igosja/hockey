<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center text-size-1 strong">
        <?= $stadium_array[0]['stadium_name']; ?>
    </div>
</div>
<div class="row margin-top">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php include(__DIR__ . '/include/stadium_table_link.php'); ?>
    </div>
</div>
<form method="POST">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
            Текушая вместимость
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
            <?= $stadium_array[0]['stadium_capacity']; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
            Новая вместимость
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <input class="form-control" id="stadium-capacity" />
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
            Финансы команды
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
            <?= f_igosja_money($stadium_array[0]['team_finance']); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
            Стоимость строительства
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 strong">
            <span id="stadium-price">0</span> $
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
            <input class="btn margin" type="submit" value="Начать строительтво" />
        </div>
    </div>
</form>
<script>
    var capacity_current = <?= $stadium_array[0]['stadium_capacity']; ?>;
</script>