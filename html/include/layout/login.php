<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>SB Admin 2 - Bootstrap Admin Theme</title>
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/sb-admin-2.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php

    if (file_exists(__DIR__ . '/../../admin/' . $route_path . '/' . $route_file . '.php')) {
        include(__DIR__ . '/../../admin/' . $route_path . '/' . $route_file . '.php');
    } else {
        print $route_file . '.html не найден';
    }

    ?>
</div>
</body>
</html>
