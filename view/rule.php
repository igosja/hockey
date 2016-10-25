<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php if (0 == $num_get) { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <h1>Правила</h1>
                </div>
            </div>
            <ul>
                <?php foreach ($rule_array as $item) { ?>
                    <li><a href="/rule.php?num=<?= $item['rule_id']; ?>"><?= $item['rule_title']; ?></a></li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <h1><?= $rule_array[0]['rule_title']; ?></h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <?= $rule_array[0]['rule_text']; ?>
                </div>
            </div>
            <div class="row margin-top">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
                    <a href="/rule.php">Назад</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>