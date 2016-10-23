<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
        <nav>
            <ul class="pagination">
                <li class="<?= $page_prev['class']; ?>">
                    <a
                        <?php if (!$page_prev['class']) { ?>
                            href="?page=<?= $page_prev['page'] . $page_filter; ?>"
                        <?php } ?>
                    >
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <?php foreach ($page_array as $item) { ?>
                    <li class="<?= $item['class']; ?>">
                        <a
                            <?php if (!$item['class']) { ?>
                                href="?page=<?= $item['page'] . $page_filter; ?>"
                            <?php } ?>
                        >
                            <?= $item['page']; ?>
                        </a>
                    </li>
                <?php } ?>
                <li class="<?= $page_next['class']; ?>">
                    <a
                        <?php if (!$page_next['class']) { ?>
                            href="?page=<?= $page_next['page'] . $page_filter; ?>"
                        <?php } ?>
                    >
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>