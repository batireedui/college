<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require 'header.php';

$username = trim($obj["phone"]);
$password = trim($obj["password"]);
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
    "select id from $table where phone=? and pass=?",
    'ss',
    [$username, $password],
    $user_id
);
if (!empty($user_id)) {
    $tok = tokenGen();
    $success = _exec(
            "UPDATE $table SET token = ? WHERE id=?",
            'si',
            [$tok, $user_id],
            $count
        );
    $returnData = [
        'success' => 1,
        'message' => 'Амжилттай нэвтэрлээ.',
        'token' => $tok,
        'user'
    ];
} else {
    $returnData = msg(0, 422, 'Нууц үг буруу байна!');
}
echo json_encode($returnData);

