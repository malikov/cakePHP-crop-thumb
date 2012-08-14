<?php
include('File.php')
// Get the width and height of image to crop
$image_width  = 771;
$image_height = 771;

$image_thumb = 200;
$image_thumb = 200;

$orig_file = 'dock.jpg';
$new_file = 'prova.jpg';


//CROP
// Starting cordinates of the original image
$source_x = 405;
$source_y = 428;
// Create jpeg image from the src image
$src = imagecreatefromjpeg($orig_file);
// Create a new image to paste the cropped image part
$dest = imagecreatetruecolor($image_width, $image_height);
// Copy the image to destination
imagecopy($dest, $src, 0, 0, $source_x, $source_y, $image_width, $image_height);
// Output and free from memory
//nuova
//
imagejpeg($dest);
//SCALE
$tmpimg = imagecreatetruecolor( $image_thumb, $image_thumb );
imagecopyresampled( $tmpimg, $dest, 0, 0, 0, 0, $image_thumb, $image_thumb, $image_width, $image_height );
imagejpeg( $tmpimg, $new_file);

imagedestroy($dest);
imagedestroy($tmpimg);
imagedestroy($src);
//fine nuova

/*
header('Content-Type: image/jpeg');
imagejpeg($dest);
imagedestroy($dest);
imagedestroy($src);
 */
?>
