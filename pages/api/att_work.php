<?php
require ROOT . '/pages/api/header.php';

$lon = trim($obj["lon"]);
$lat = trim($obj["lat"]);
$userid = trim($obj["userid"]);

if (!empty($userid)) {
    _selectRowNoParam(
        "SELECT tsag FROM `att_work` WHERE userid=$userid and hezee = '" . ognooday() . "' ORDER by id DESC LIMIT 1",
        $tsag
    );
    $mins = 60;
    if (!empty($tsag)) {
        $start = strtotime(date("H:i:s"));
        $end = strtotime($tsag);
        $mins = ($end - $start) / 60;
    }
    if (abs($mins) > 10) {
        $success = _exec(
            "INSERT INTO att_work (hezee, tsag, userid, lon, lat, refer, turul) VALUES (?, ?, ?, ?, ?, ?, ?)",
            'ssissii',
            [ognooday(), date("H:i:s"), $userid, $lon, $lat, 0, 0],
            $ct
        );
        echo "Амжилттай бүртгэгдлээ!";
    } else echo "Бүртгэгдсэн байна!";
} else echo "Алдаа гарлаа!";
