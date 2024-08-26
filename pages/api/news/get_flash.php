<?php
require ROOT . '/pages/api/header.php';
$response = array();

_selectNoParam(
    $stmt,
    $count,
    "select image, link from flashnews where status = 1",
    $image, $link
);
while (_fetch($stmt)){
    $item = new stdClass();
    $item->image = $image;
    $item->link = $link;
    array_push($response, $item);
}
echo json_encode($response);