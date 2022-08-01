<?php
$startX = ($_GET["width"] - $_GET["textWidth"])/2;
$startY = ($_GET["height"] - $_GET["textHeight"])/2;
//var_dump($startX);
//die();
header("Content-Type: image/png");
$im = @imagecreate($_GET["width"], $_GET["height"])
or die("Невозможно создать поток изображения");



$font = "./arial.ttf"; // путь к шрифту
$font_size = 12; // размер шрифта
$box = imagettfbbox($font_size, 0, $font, $_GET["text"]);
$x = ($_GET['width']/2)-($box[2]-$box[0])/2;
$y = ($_GET['height']/2)-($box[3]-$box[5])/2;


$background_color = imagecolorallocate($im, 0, 0, 0);
$text_color = imagecolorallocate($im, 233, 14, 91);
imagettftext($im, $font_size,null, $x, $y,  $text_color,$font,$_GET['text']);
imagepng($im);
imagedestroy($im);



?>
