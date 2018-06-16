<?php
/**
 * @var $breadcrumb_array array
 */
?>
<?php if (count($breadcrumb_array)) { ?>
    <ol class="breadcrumb">
        <li>
            <a href="/admin/">
                Главная
            </a>
        </li>
        <?php for ($i = 0, $count_breadcrunb = count($breadcrumb_array) - 1; $i < $count_breadcrunb; $i++) { ?>
            <li>
                <a href="/admin/<?= $breadcrumb_array[$i]['url']; ?>">
                    <?= $breadcrumb_array[$i]['text']; ?>
                </a>
            </li>
        <?php } ?>
        <li class="active"><?= end($breadcrumb_array); ?></li>
    </ol>
<?php } ?>