<?php
$img = $_POST['file_to_upload'];
$fname = $_POST['file_name'];

$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = ROOT . "/www/images/users/$fname.jpg";
$success = file_put_contents($file, $data);

$input_image_path = ROOT . "/www/images/users/$fname.jpg";

$percent = 0.3;

// Шинэ зургийн зам
$output_image_path = ROOT . "/www/images/users/$fname-t.jpg";

list($width, $height) = getimagesize($input_image_path);
$new_width = 80; $width * $percent;
$new_height = 60; $height * $percent;

// Эх зургийн мэдээллийг авах
list($original_width, $original_height, $image_type) = getimagesize($input_image_path);

// Зургийн төрөл тодорхойлох
switch ($image_type) {
    case IMAGETYPE_JPEG:
        $original_image = imagecreatefromjpeg($input_image_path);
        break;
    case IMAGETYPE_PNG:
        $original_image = imagecreatefrompng($input_image_path);
        break;
    case IMAGETYPE_GIF:
        $original_image = imagecreatefromgif($input_image_path);
        break;
    default:
        die('Дэмжигдээгүй зураг төрөл.');
}

// Шинэ зургийн обьект үүсгэх
$resized_image = imagecreatetruecolor($new_width, $new_height);

// Эх зургийг шинэ хэмжээгээр буулгах
imagecopyresampled($resized_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

// Шинэ зураг үүсгэх ба хадгалах
switch ($image_type) {
    case IMAGETYPE_JPEG:
        imagejpeg($resized_image, $output_image_path, 100); // JPEG чанар 90%
        break;
    case IMAGETYPE_PNG:
        imagepng($resized_image, $output_image_path);
        break;
    case IMAGETYPE_GIF:
        imagegif($resized_image, $output_image_path);
        break;
}

// Нөөцийн чөлөөлөлт
imagedestroy($original_image);
imagedestroy($resized_image);

echo "Зургийн хэмжээ амжилттай багасаж, шинэ зураг үүслээ!";