    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer text-center">
            Страница сгенерирована за <?= round(microtime(true) - $start_time, 5); ?> сек.,
            <?= $count_query; ?> запр.<br/>
            <?= number_format(memory_get_usage(), 0, ',', ' '); ?> Б памяти
        </div>
    </div>
</div>
<?php if (file_exists(__DIR__ . '/../../js/' . $tpl . '.js')) { ?>
    <script src="/js/jquery.js"></script>
    <script src="/js/<?= $tpl; ?>.js"></script>
<?php } ?>
</body>
</html>