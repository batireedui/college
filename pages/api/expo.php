<?php
require ROOT . '/pages/api/header.php';

$expo = trim($obj["expo"]);

if (!empty($expo)) {
    $success = _exec(
            "INSERT INTO expo (token) VALUES (?)",
            's',
            [$expo],
            $count
        );
}

