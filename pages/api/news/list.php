<?php
require ROOT . '/pages/api/header.php';

$page = $obj['page'];

$start = 0;
$stop = 10; 

_selectRowNoParam("SELECT count(id) from news WHERE status = 1", $all_rows);

$page_limit = $all_rows/$stop+1; 
$start = ($page - 1) * $stop; 

$response = array();
if($page<=$page_limit){
    _selectNoParam(
        $stmt,
        $count,
        "select id, title, image, DATE_FORMAT(ognoo, '%Y.%m.%d') from news where status = 1 ORDER BY ognoo DESC LIMIT $start, $stop",
        $id, $title, $image, $ognoo
    );
    while (_fetch($stmt)){
        $item = new stdClass();
        
        $item->id = $id;
        $item->title = $title;
        $item->image = $image;
        $item->ognoo = $ognoo;
        
        array_push($response, $item);
    }
    echo json_encode($response);
}
else
{
    echo json_encode("nodata");
}