<?php
if (isset($_SESSION['user_id'])) {
    $angi_id = $_POST['angi_id'];
    $tuluv = $_POST['tuluv'];
    $user_id = $_SESSION['user_id'];
    if ($tuluv == "true") {
        $tc_id = 0;
        _selectRowNoParam(
            "SELECT id FROM tclass WHERE tid='$user_id' and classid = '$angi_id'",
            $tc_id
        );
        if ($tc_id == 0) {
            $success = _exec(
                "INSERT INTO tclass (tid, classid) VALUES(?, ?)",
                'ii',
                [$user_id, $angi_id],
                $count
            );
        }
    } else {
        $success = _exec(
            "DELETE FROM tclass WHERE tid=? and classid=?",
            'ii',
            [$user_id, $angi_id],
            $count
        );
    }
    echo "Амжилттай!";
?>
<?php
}
?>