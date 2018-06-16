<?php
/**
 * @var $tpl string
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Вход в административный раздел</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/css/bootstrap.css?v=<?= filemtime(__DIR__ . '/../../css/bootstrap.css'); ?>" rel="stylesheet">
    <link href="/css/sb-admin-2.css?v=<?= filemtime(__DIR__ . '/../../css/sb-admin-2.css'); ?>" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php include(__DIR__ . '/../' . $tpl . '.php'); ?>
</div>
</body>
</html>