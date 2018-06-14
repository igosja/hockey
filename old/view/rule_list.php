<?php
/**
 * @var $rule_array array
 */
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
    </div>
</div>