<?php

include(__DIR__ . '/include/include.php');

if (($tournament = f_igosja_request_get('tournament')) && ($stage = f_igosja_request_get('stage')))
{
    $text = $tournament . ', ' . $stage;
}
elseif ($team = f_igosja_request_get('team'))
{
    $text = $team;
}
else
{
    $text = '-';
}

header("Content-type: image/png");

$image      = imagecreate(20, 90);
$back_color = imagecolorallocate($image, 40, 96, 144);
$text_color = imagecolorallocate($image, 255, 255, 255);

//imagestringup($image, 3, 3, 81, $text, $text_color);
imagettftext($image, 3, 90, 3, 81, $text_color, 'arial.ttf', $text);
imagepng($image);
imagedestroy($image);