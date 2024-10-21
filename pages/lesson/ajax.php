<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];
    $lesson_name = $_POST['lesson_name'];
    $lesson_cag = $_POST['lesson_cag'];
    if ($mode == 1) {
        $lesson_id = $_POST['lesson_id'];
        $success = _exec(
            "UPDATE tlesson SET lessonName = ?, cag=? WHERE id = ?",
            'sii',
            [$lesson_name, $lesson_cag, $lesson_id],
            $count
        );
    } elseif ($mode == 2) {
        $success = _exec(
            "INSERT INTO tlesson (tid, lessonName, cag, tuluv) VALUES(?, ?, ?, ?)",
            'isii',
            [$_SESSION['user_id'], $lesson_name, $lesson_cag, '1'],
            $count
        );
    } elseif ($mode == 3) {
        $lesson_id = $_POST['lesson_id'];
        $too = 0;
        _selectRowNoParam(
            "SELECT count(id) FROM att WHERE lessonid = '$lesson_id'",
            $too
        );
        if ($too > 0) {
            echo "Устгах боломжгүй байна. Энэ хичээлийг сонгож ирц бүртгэсэн байна.";
        } else {
            $success = _exec(
                "DELETE FROM tlesson WHERE id = ?",
                'i',
                [$lesson_id],
                $count
            );
        }
    } elseif ($mode == 4) {
        $lesson_id = $_POST['lesson_id'];
        $tuluv = $_POST['tuluv'];
        if ($tuluv == "true") {
            $success = _exec(
                "UPDATE tlesson SET tuluv = ? WHERE id = ?",
                'ii',
                ["1", $lesson_id],
                $count
            );
        } else {
            $success = _exec(
                "UPDATE tlesson SET tuluv = ? WHERE id = ?",
                'ii',
                ["0", $lesson_id],
                $count
            );
        }
    }
    echo "Амжилттай!";
?>
<?php
}
?>