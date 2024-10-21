<?php
require 'header.php';

$userType = trim($obj["userType"]);

function msg($success, $status, $message, $extra = [])
{
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ], $extra);
}

if($userType == "1") $table = "select id, concat(`fname`, ' ', `lname`) as lname, `phone`, user_role from teacher where token=?";
else $table = "select id, `lname`, `phone`, user_role from parent where token=?";

_selectRow(
    $table,
    's',
    [$token],
    $user_id,
    $user_name,
    $user_phone,
    $user_role
);
if (!empty($user_id)) {
    $returnData = [
        'success' => 1,
        'user' => ['user_id' => $user_id, 'user_name' => $user_name, 'user_phone' => $user_phone, 'user_role' => $user_role]
    ];
} else {
    $returnData = msg(0, 422, 'Нууц үг буруу байна!');
}
echo json_encode($returnData);

