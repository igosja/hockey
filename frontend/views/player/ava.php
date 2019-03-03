<?php

$eyeArray = ['a', 'b', 'c'];
$mouthArray = ['a', 'b', 'c'];
$faceArray = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm'];
$hairArray = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k'];

$body = rand(1, 12);
$eye = rand(1, 36);
$eye2 = $eyeArray[array_rand($eyeArray)];
$face = rand(1, 9);
$face2 = $faceArray[array_rand($faceArray)];
$hair = rand(1, 15);
$hair2 = $hairArray[array_rand($hairArray)];
$mouth = rand(1, 40);
$mouth2 = $mouthArray[array_rand($mouthArray)];
$nose = rand(1, 40);

?>
<div style="width:98px; height: 130px">
    <img src="/img/player/body/bd<?= $body; ?>_s1.png" style="left:5px;top:5px;position: absolute;" alt="">
    <img src="/img/player/face/f<?= $face; ?><?= $face2; ?>.png" style="left:5px;top:5px;position: absolute;" alt="">
    <img src="/img/player/eye/e<?= $eye; ?><?= $eye2; ?>.png" style="left:19px;top:6px;position: absolute;" alt="">
    <img src="/img/player/mouth/m<?= $mouth; ?><?= $mouth2; ?>.png" style="left:26px;top:52px;position: absolute;"
         alt="">
    <img src="/img/player/nose/n<?= $nose; ?>.png" style="left:18px;top:17px;position: absolute;" alt="">
    <img src="/img/player/hair/f<?= $face; ?>h<?= $hair; ?><?= $hair2; ?>.png"
         style="left:5px;top:5px;position: absolute;" alt="">
</div>