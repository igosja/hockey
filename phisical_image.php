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

function iso2uni($isoline)
{
    $uniline = '';
    for ($i = 0; $i < strlen($isoline); $i++) {
        $thischar = substr($isoline, $i, 1);
        $charcode = ord($thischar);
        $uniline .= ($charcode > 175) ? "&#" . (1040 + ($charcode - 176)) . ";" : $thischar;
    }
    return $uniline;
}

header("Content-type: image/png");

$image      = imagecreate(20, 90);
$back_color = imagecolorallocate($image, 40, 96, 144);
$text_color = imagecolorallocate($image, 255, 255, 255);

//imagestringup($image, 3, 3, 81, iso2uni(convert_cyr_string($text ,"w","i")), $text_color);
imagettftext($image, 12, 90, 3, 81, $text_color, __DIR__ . '/fonts/helvetiva.otf', $text);
imagepng($image);
imagedestroy($image);