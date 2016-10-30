<?php

include (__DIR__ . '/../include/include.php');

print date('H:i:s d.m.Y', strtotime('Mon'));
exit;

redirect('/admin/index.php');