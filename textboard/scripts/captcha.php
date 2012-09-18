<?php
header("Content-type: image/jpeg");
session_start();

$sequence = "AABBCCDDEEFFGGHHIIJJKKLLMMNNOOPPQQRRSSTTUUVVWWXXYYZZ";
$match = substr(str_shuffle($sequence), 0, 5);

$_SESSION['secure_captcha'] = strtolower($match);

$start_x = rand(5, 10);

$text_font = "fonts/captcha1.ttf";
$text_size = 35;
$image_width = $text_size * strlen($match) + 20 + $start_x;
$image_height = 80;

$captcha = imagecreate($image_width, $image_height);

imagecolorallocate($captcha, 41, 48, 52);
$text_color = imagecolorallocate($captcha, 0, 0, 0);

// Draw random line slashes
for ($n=0; $n<35; $n++)
{
	$x1 = rand(1, $image_width);
	$x2 = rand(1, $image_width);
	$y1 = rand(5, $image_height-5);
	$y2 = rand(5, $image_height-5);
	
	imageline($captcha, $x2, $y2, $x1, $y1, $text_color);
}

imagettftext($captcha, $text_size, 0, $start_x, 60, $text_color, $text_font, $match);
imagepng($captcha);

?>