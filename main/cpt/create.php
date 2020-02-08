<?php
session_start();

$text = $_SESSION[$_GET['c']];
$fontSize = 20;

$imageWidth = 164;
$imageHeight = 40;

$image = imagecreate($imageWidth, $imageHeight);
imagecolorallocate($image, 255, 255, 255);

$fontColor = imagecolorallocate($image, 0, 0, 0);
imagettftext($image, $fontSize, 0, 6, $imageHeight - 12, $fontColor, dirname(__FILE__) . "/" . rand(1 ,2) . '.ttf', $text);


for($i=1; $i<13; $i++) {
	$x1 = rand(6, $imageWidth -6);
	$y1 = rand(8, $imageHeight -12);
	$x2 = rand(6, $imageWidth -6);
	$y2 = rand(8, $imageHeight -12);
	imageline($image, $x1, $y1, $x2, $y2, $fontColor);
}

header('Content-type: image/jpg');
imagejpeg($image);