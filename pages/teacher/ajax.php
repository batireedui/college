<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];

    $fname = @$_POST['fname'];
    $lname = @$_POST['lname'];
    $phone = @$_POST['phone'];
    $email = @$_POST['email'];
    $at = @$_POST['at'];
    $pass = @$_POST['phone'];
    $user_role = @$_POST['user_role'];
    $tuluv = @$_POST['tuluv'];

    if ($mode == 1) {
        $id = $_POST['id'];
        $office = @$_POST['office'];
        $department = @$_POST['department'];

        $success = _exec(
            "UPDATE teacher SET fname=?, lname=?, phone=?, email=?, at=?, user_role=?, tuluv=?, office_id=?, department_id=? WHERE id = ?",
            'sssssiiiii',
            [$fname, $lname, $phone, $email, $at, $user_role, $tuluv, $office, $department, $id],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 2) {
        $office = @$_POST['aoffice'];
        $department = @$_POST['adepartment'];

        $success = _exec(
            "INSERT INTO teacher (fname, lname, phone, email, at, pass, user_role, tuluv, office_id, department_id) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'ssssssiiii',
            [$fname, $lname, $phone, $email, $at, password_hash($pass, PASSWORD_BCRYPT, ["cost" => 8]), $user_role, $tuluv, $office, $department],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 3) {
        $id = $_POST['id'];
        _selectRowNoParam(
            "SELECT COUNT(id) FROM `class` WHERE teacherid = $id",
            $too
        );

        if ($too > 0) {
            echo "Багш даасан ангийн бүргэлтэй тул устгах боломжгүй!";
        } else {
            _selectRowNoParam(
                "SELECT COUNT(id) FROM `att` WHERE tid = $id",
                $atoo
            );

            if ($atoo > 0) {
                echo "Багш ирц бүртгэсэн тул устгах боломжгүй!";
            } else {
                _selectRowNoParam(
                    "SELECT COUNT(id) FROM `att_work` WHERE userid = $id",
                    $awtoo
                );
                if ($awtoo > 0) {
                    echo "Багш ажлын цагийн бүртгэл хийлгэсэн тул устгах боломжгүй!!";
                } else {
                    $success = _exec(
                        "DELETE FROM teacher WHERE id = ?",
                        'i',
                        [$id],
                        $count
                    );
                    echo "Амжилттай!";
                }
            }
        }
    }
?>
<?php
}
?>