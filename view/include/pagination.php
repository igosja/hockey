<?php

/**
 * @var $page integer
 * @var $count_page integer
 */

$page_array = array();

if ($page >= 3)
{
    $page_array[] = 1;
}

if ($page > 1)
{
    $page_array[] = $page - 1;
}

$page_array[] = $page;

if ($page < $count_page)
{
    $page_array[] = $page + 1;
}

if ($page <= $count_page - 2)
{
    $page_array[] = $count_page;
}

$get = $_GET;

?>
<div class="row margin-top-small">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <?php foreach ($page_array as $item) { ?>
            <?php $get['page'] = $item; ?>
            <?php if ($item == $page) { ?>
                <span class="btn">
                    <?= $item; ?>
                </span>
            <?php } else { ?>
                <a class="btn pagination" href="?<?= http_build_query($get); ?>">
                    <?= $item; ?>
                </a>
            <?php } ?>
        <?php } ?>
    </div>
</div>