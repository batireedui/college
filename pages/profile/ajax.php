<?php
if (isset($_SESSION['user_id'])) {
    $mode = @$_POST['mode'];
    if ($mode == 2) {
        $old = $_POST['old'];
        $newp = $_POST['newp'];
        $newpp = $_POST['newpp'];

        _selectRow(
            "select pass from teacher where id = ?",
            'i',
            [$_SESSION['user_id']],
            $t
        );
        if ($old == "" || $newp == "" || $newpp == "") echo "<div class='alert alert-danger'>Хоосон утга байж болохгүй!</div>";
        else if ($newp != $newpp) echo "<div class='alert alert-danger'>Нууц үг тохирохгүй байна</div>";
        else if (password_verify($old, $t)) {
            $success = _exec(
                "UPDATE teacher SET pass=? WHERE id = ?",
                'si',
                [password_hash($p2, PASSWORD_BCRYPT, ["cost" => 8]), $_SESSION['user_id']],
                $count
            );
            echo "<div class='alert alert-success'>Амжилттай солигдлоо!</div>";
        } else {
            echo "<div class='alert alert-danger'>Хуучин нууц үг буруу байна</div>";
        }
    } elseif (isset($_POST['fname'])) {
        if ($_POST['fname'] == "" || $_POST['lname'] == "" || $_POST['phone'] == "")
            echo "<div class='alert alert-danger'>Хоосон утга байж болохгүй!</div>";
        else {
            $success = _exec(
                "UPDATE teacher SET fname=?, lname=?, phone=?, email=?, at=?, zereg=? WHERE id = ?",
                'sssssii',
                [$_POST['fname'], $_POST['lname'], $_POST['phone'], $_POST['email'], $_POST['at'], $_POST['zereg'], $_SESSION['user_id']],
                $count
            );
            echo "<div class='alert alert-success'>Амжилттай солигдлоо!</div>";
        }
    }
?>
<?php
}
?>