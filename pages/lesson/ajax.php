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
            [$lesson_name, $lesson_cag, $lesson_id ],
            $count
        );
    } elseif ($mode == 2) {
        $success = _exec(
            "INSERT INTO tlesson (lessonName, cag) VALUES(?, ?)",
            'si',
            [$lesson_name, $lesson_cag],
            $count
        );
    } elseif ($mode == 3) {
        $lesson_id = $_POST['lesson_id'];
        $success = _exec(
            "DELETE FROM tlesson WHERE id = ?",
            'i',
            [$lesson_id],
            $count
        );
    }
    echo "Амжилттай!";
?>
<?php
}
?>