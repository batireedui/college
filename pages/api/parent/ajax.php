<?php
if (isset($_POST['userid']) && isset($_POST['type'])) {
    if($_POST['type'] == "myinfo"){
        $user_id = $_POST["userid"];
        _exec("UPDATE parent SET lname = ?, phone = ?, email = ? WHERE id = ?",
            "sssi",
            [$_POST['lname'], $_POST['phone'], $_POST['email'], $user_id],
            $count
        );
        echo "Таны мэдээлэл амжилттай солигдлоо.";
    }
    else if($_POST['type'] == "mypass"){
        $user_id = $_POST["userid"];
        $old = $_POST['pass'];
        $newp = $_POST['newpass'];
        $newpp = $_POST['newpasscheck'];
        
        _selectRow(
            "select pass from parent where id = ?",
            'i',
            [$user_id],
            $t
        );
        if ($old == "" || $newp == "" || $newpp == "") echo "Хоосон утга байж болохгүй!";
        else if ($newp != $newpp) echo "Нууц үг тохирохгүй байна!";
        else if (password_verify($old, $t)) {
            $success = _exec(
                "UPDATE parent SET pass=? WHERE id = ?",
                'si',
                [password_hash($newp, PASSWORD_BCRYPT, ["cost" => 8]), $user_id],
                $count
            );
            echo "Амжилттай солигдлоо!";
        } else {
            echo "Хуучин нууц үг буруу байна";
        }
    }
    else echo "Хандалт буруу байна";
} else echo "Хандалт буруу байна!";