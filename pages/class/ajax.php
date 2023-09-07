<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];
    $teacher_id = @$_POST['teacher_id'];
    $angi_name = @$_POST['angi_name'];
    $hugacaa = @$_POST['hugacaa'];
    if ($mode == 1) {
        $angi_id = $_POST['angi_id'];
        $success = _exec(
            "UPDATE class SET name=?, teacherid = ?, hugacaa=? WHERE id = ?",
            'sisi',
            [$angi_name, $teacher_id, $hugacaa, $angi_id],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 2) {
        $success = _exec(
            "INSERT INTO class (name, hugacaa, tuluv, teacherid) VALUES(?, ?, ?, ?)",
            'ssii',
            [$angi_name, $hugacaa, "1", $teacher_id],
            $count
        );
        echo "Амжилттай!";
    } elseif ($mode == 3) {
        $angi_id = $_POST['angi_id'];
        _selectRowNoParam(
            "SELECT COUNT(id) FROM `students` WHERE class = $angi_id",
            $too
        );
        if ($too > 0) {
            echo "Энэ ангид сурагч бүртгэлтэй тул устгах боломжгүй байна!";
        } else {
            $success = _exec(
                "DELETE FROM class WHERE id = ?",
                'i',
                [$angi_id],
                $count
            );
            echo "Амжилттай!";
        }
    }
?>
<?php
}
?>