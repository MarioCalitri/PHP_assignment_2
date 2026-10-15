<?php
function process_image($dir, $filename) {
    // set up paths
    $dir = rtrim($dir, '/') . '/';
    $img_path = $dir . $filename;

    // image info
    $i = pathinfo($img_path);
    $name = $i['filename'];
    $ext = $i['extension'];

    // target paths
    $img_100_path = $dir . '/' . $name . '_100.' . $ext;
    $img_400_path = $dir . '/' . $name . '_400.' . $ext;

    // create 100px and 400px versions
    process_file($img_path, $img_100_path, 100, 100);
    process_file($img_path, $img_400_path, 400, 400);
}

function process_file($src_path, $dest_path, $max_width, $max_height) {
    // check original image size
    $src_info = getimagesize($src_path);
    if ($src_info === false) return;

    $src_width = $src_info[0];
    $src_height = $src_info[1];
    $type = $src_info[2];

    // calculate new dimensions
    $ratio = min($max_width / $src_width, $max_height / $src_height);
    $new_width = round($src_width * $ratio);
    $new_height = round($src_height * $ratio);

    // create image resource from source
    switch ($type) {
        case IMAGETYPE_JPEG:
            $src_img = imagecreatefromjpeg($src_path);
            break;
        case IMAGETYPE_PNG:
            $src_img = imagecreatefrompng($src_path);
            break;
        case IMAGETYPE_GIF:
            $src_img = imagecreatefromgif($src_path);
            break;
        default:
            return;
    }

    // resize image
    $new_img = imagecreatetruecolor($new_width, $new_height);
    imagecopyresampled($new_img, $src_img, 0, 0, 0, 0, $new_width, $new_height, $src_width, $src_height);

    // save resized image
    switch ($type) {
        case IMAGETYPE_JPEG:
            imagejpeg($new_img, $dest_path, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($new_img, $dest_path);
            break;
        case IMAGETYPE_GIF:
            imagegif($new_img, $dest_path);
            break;
    }

    imagedestroy($src_img);
    imagedestroy($new_img);
}
?>