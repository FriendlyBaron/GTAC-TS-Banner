<?php

$url = "http://www.reddit.com/r/pccruisespics/new.json?limit=25"; //data of 25 newest posts

$json = file_get_contents($url);
 
$lastPos = 0;
$positions = array();

while (($lastPos = strpos($json, "http://i.imgur.com/", $lastPos))!== false) { //loop through all i.imgur.com links in the text, we only care about single images
    $positions[] = $lastPos;
    $lastPos = $lastPos + strlen("http://i.imgur.com/");
}

$randomLoc = array_rand($positions, 1);

if (strpos(substr($json, $positions[$randomLoc], 30), "png") > 0) //if the link ends with png (an imgur link is 30 chars), then we make a png image
{
    $im = imagecreatefrompng(substr($json, $positions[$randomLoc], 30));
}
else //otherwise assume it's a jpeg
{
    $im = imagecreatefromjpeg(substr($json, $positions[$randomLoc], 30));
}

header('Content-Type: image/png');

imagepng($im);
imagedestroy($im);
?>
