<?php
require ROOT . '/pages/api/header.php';

$lon = trim($obj["lon"]);
$lat = trim($obj["lat"]);
$userid = trim($obj["userid"]);

if (!empty($userid)) {
    $success = _exec(
            "INSERT INTO att_work (hezee, tsag, userid, lon, lat) VALUES (?, ?, ?, ?, ?)",
            'ssiss',
            [ognooday(), date("H:i:s"), $userid, $lon, $lat],
            $ct
        );
    echo "Амжилттай бүртгэгдлээ!";
} else echo "Алдаа гарлаа!";