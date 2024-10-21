<?php
_selectNoParam(
    $st, $co,
    "SELECT id, pass FROM parent",
    $id, $pass
    );

while(_fetch($st)){
    $newpass = password_hash($pass, PASSWORD_BCRYPT, ["cost" => 8]);
    /*_exec("UPDATE parent SET pass = ? WHERE id = ?",
    "si",
    [$newpass, $id],
    $count
    );*/
    echo "$id-$pass-$newpass<br>";
}