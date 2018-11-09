<?php
$imagesDir = 'images/';

$images = glob($imagesDir . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

$randomImage = $images[array_rand($images)];

echo $randomImage;
echo "<img src='$randomImage'/>";

