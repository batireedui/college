<?php
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


if ($userType == "1") $table = "teacher";
else $table = "parent";
_selectRow(
    "select id, pass from $table where phone=?",
    's',
    [$username],
    $user_id,
    $user_pass
);
if (!empty($user_id)) {
    if (password_verify($password, $user_pass)) {
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
} else {
    $returnData = msg(0, 422, 'Нууц үг буруу байна!');
}
echo json_encode($returnData);
