<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'header.php';

$token = trim($obj["token"]);
$userType = trim($obj["userType"]);

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

if($userType == "1") $table = "teacher";
else $table = "parent";

_selectRow(
    "select id, concat(`fname`, ' ', `lname`) as lname, `phone` from $table where token=?",
    's',
    [$token],
    $user_id,
    $user_name,
    $user_phone
);
if (!empty($user_id)) {
    $returnData = [
        'success' => 1,
        'user' => ['user_id' => $user_id, 'user_name' => $user_name, 'user_phone' => $user_phone]
    ];
} else {
    $returnData = msg(0, 422, 'Нууц үг буруу байна!');
}
echo json_encode($returnData);

