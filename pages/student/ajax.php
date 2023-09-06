<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];

    $code = $_POST['rd'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $class = $_POST['class'];
    $tuluv = $_POST['tuluv'];

    if ($mode == 1) {
        $id = $_POST['id'];
        $success = _exec(
            "UPDATE students SET code=?, fname=?, lname=?, gender=?, phone=?, class=?, tuluv=?, pass=? WHERE id = ?",
            'ssssssisi',
            [$code, $fname, $lname, $gender, $phone, $class, $tuluv, $phone, $id],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 2) {
        $success = _exec(
            "INSERT INTO students (code,fname,lname,gender,phone,class,tuluv,pass) VALUES(?, ?, ?, ?, ?, ?, ?, ?)",
            'ssssssis',
            [$code, $fname, $lname, $gender, $phone, $class, $tuluv, $phone],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 3) {
        $id = $_POST['id'];
        $success = _exec(
            "DELETE FROM students WHERE id = ?",
            'i',
            [$id],
            $count
        );
    }
?>
<?php
}
?>