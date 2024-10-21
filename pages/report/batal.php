<?php
if (isset($_SESSION['user_id'])) {
    $class = @$_POST['class'];
    $on = @$_POST['on'];
    $sar = @$_POST['sar'];
    $mode = @$_POST['mode'];

    $last = date("Y-m-t", strtotime("$on-$sar-1"));
    $start = date("Y-m-d", strtotime("$on-$sar-1"));

    if ($mode == 0) {
        $batal = 0;

        _selectRowNoParam(
            "SELECT id FROM batal WHERE class='$class' and year='$on' and sar='$sar'",
            $batal
        );

        if ($batal > 0) {
            echo "Өмнө нь баталгаажуулалт хийгдсэн байна.";
        } else {
            $success = _exec(
                "INSERT INTO batal (class, year, sar) VALUES(?, ?, ?)",
                'iii',
                [$class, $on, $sar],
                $count
            );

            $success = _exec(
                "UPDATE att SET tuluv=1 WHERE classid=? and ognoo BETWEEN ? and ?",
                'iss',
                [$class, $start, $last],
                $count
            );
            echo "Амжилттай!";
        }
    } elseif ($mode == 1) {
        $success = _exec(
            "DELETE FROM  batal WHERE class=? and year=? and sar=?",
            'iii',
            [$class, $on, $sar],
            $count
        );
        $success = _exec(
            "UPDATE att SET tuluv=0 WHERE classid=? and ognoo BETWEEN ? and ?",
            'iss',
            [$class, $start, $last],
            $count
        );
        echo "Амжилттай!";
    }
}
