<?php

include(__DIR__ . '/include/include.php');

if (!$num_get = (int) f_igosja_request_get('num'))
{
    $num_get = time();
}

$text = f_igosja_ufu_date($num_get);

header("Content-type: image/png");

$image      = imagecreate(20, 90);
$back_color = imagecolorallocate($image, 40, 96, 144);
$text_color = imagecolorallocate($image, 255, 255, 255);

imagestringup($image, 3, 3, 81, $text, $text_color);
imagepng($image);
imagedestroy($image);