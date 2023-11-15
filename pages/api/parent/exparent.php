<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$json = file_get_contents('php://input');
$obj = json_decode($json, true);

$user_id = trim($obj["user_id"]);
$expo = trim($obj["expo"]);

if (!empty($user_id)) {
    $tok = tokenGen();
    $success = _exec(
            "UPDATE parent SET expo = ? WHERE id=?",
            'si',
            [$expo, $user_id],
            $count
        );
}

