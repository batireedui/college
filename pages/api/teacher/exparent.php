<?php
require ROOT . '/pages/api/header.php';

$user_id = trim($obj["user_id"]);
$expo = trim($obj["expo"]);

if (!empty($user_id)) {
    $tok = tokenGen();
    $success = _exec(
            "UPDATE teacher SET expo = ? WHERE id=?",
            'si',
            [$expo, $user_id],
            $count
        );
}