<?php
require ROOT . '/pages/api/header.php';
$response = array();

_selectNoParam(
    $stmt,
    $count,
    "select image from flashnews where status = 1",
    $image
);
while (_fetch($stmt)){
    array_push($response, $image);
}
echo json_encode($response);