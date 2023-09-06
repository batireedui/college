<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];

    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $at = $_POST['at'];
    $pass = $_POST['phone'];
    $user_role = $_POST['user_role'];
    $tuluv = $_POST['tuluv'];
    if ($mode == 1) {
        $id = $_POST['id'];
        $success = _exec(
            "UPDATE teacher SET fname=?, lname=?, phone=?, email=?, at=?, pass=?, user_role=?, tuluv=? WHERE id = ?",
            'ssssssiii',
            [$fname, $lname, $phone, $email, $at, $pass, $user_role, $tuluv, $id],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 2) {
        $success = _exec(
            "INSERT INTO teacher (fname, lname, phone, email, at, pass, user_role, tuluv) VALUES(?, ?, ?, ?, ?, ?, ?, ?)",
            'ssssssii',
            [$fname, $lname, $phone, $email, $at, $pass, $user_role, $tuluv,],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 3) {
        $id = $_POST['id'];
        $success = _exec(
            "DELETE FROM teacher WHERE id = ?",
            'i',
            [$id],
            $count
        );
        echo "Амжилттай!";
    }
?>
<?php
}
?>