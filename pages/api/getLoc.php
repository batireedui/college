<?php
_selectNoParam(
    $st,
    $ct,
    "SELECT id, lon, lat, zai FROM `location`",
    $id,
    $lon,
    $lat,
    $zai
);

$res = array();
if ($ct > 0) {
    while (_fetch($st)) {
        $row = new stdClass();
        $row->id = $id;
        $row->lon = $lon;
        $row->lat = $lat;
        $row->zai = $zai;

        array_push($res, $row);
    }
} else {
    $row = new stdClass();
    $row->id = 0;
    $row->lon = 0;
    $row->lat = 0;
    $row->zai = 0;

    array_push($res, $row);
}
echo json_encode($res);
