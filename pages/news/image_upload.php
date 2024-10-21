<?php
$img = $_POST['file_to_upload'];
$fname = $_POST['file_name'];

$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = ROOT . "/www/images/image_news/$fname.jpg";
$success = file_put_contents($file, $data);
