    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 footer text-center">
            Страница сгенерирована за <?= round(microtime(true) - $start_time, 5); ?> сек.,
            <?= f_igosja_get_count_query(); ?> запр.<br/>
            <?= number_format(memory_get_usage(), 0, ',', ' '); ?> Б памяти<br/>
            Версия
            <?=
            $site_array[0]['site_version_1']
            . '.'
            . $site_array[0]['site_version_2']
            . '.'
            . $site_array[0]['site_version_3']
            . '.'
            . $site_array[0]['site_version_4'];
            ?>
            от
            <?= f_igosja_ufu_date($site_array[0]['site_version_date']); ?>
        </div>
    </div>
</div>
<?php if (file_exists(__DIR__ . '/../../js/' . $tpl . '.js')) { ?>
    <script src="/js/jquery.js"></script>
    <script src="/js/<?= $tpl; ?>.js"></script>
<?php } ?>
<?php if ('vhol.org' == $_SERVER['HTTP_HOST']) { ?>
    <!--Google analitics-->
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        ga('create', 'UA-90926144-1', 'auto');
        ga('send', 'pageview');
    </script>
    <!--/Google analitics-->
    <!--LiveInternet counter-->
    <script type="text/javascript"><!--
        new Image().src = "//counter.yadro.ru/hit?r"+
            escape(document.referrer)+((typeof(screen)=="undefined")?"":
                ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
            ";"+Math.random();//-->
    </script>
    <!--/LiveInternet-->
<?php } ?>
</body>
</html>