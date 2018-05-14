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

$image      = imagecreate(20, 200);
$back_color = imagecolorallocate($image, 40, 96, 144);
$text_color = imagecolorallocate($image, 255, 255, 255);

//imagestringup($image, 3, 3, 81, iso2uni(convert_cyr_string($text ,"w","i")), $text_color);
imagettftext($image, 11, 90, 15, 191, $text_color, __DIR__ . '/fonts/HelveticaNeue.ttf', $text);
imagepng($image);
imagedestroy($image);