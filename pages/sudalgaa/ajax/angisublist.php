<?php
if (isset($_SESSION['user_id'])) {
    $val = "<option value='0'>Сонгоно уу</option>";
    if ($_POST["type"] == "teacherlist") {
        $pid = $_POST["id"];
        _selectNoParam(
            $sstmt,
            $scount,
            "SELECT id, fname, lname FROM `teachers` WHERE tuluv='0' and school_id='$pid'",
            $t_id,
            $t_fname,
            $t_lname
        );
        while (_fetch($sstmt)) {
            $val .= "<option value='$t_id'>$t_fname $t_lname</option>";
        }
        echo $val;
    } else if ($_POST["type"] == "angilist") {
        $sql = "";
        if ($_SESSION['user_role'] == "teacher") $sql = " and teacher_id = " . $_SESSION['user_id'];

        $pid = $_POST["id"];
        _selectNoParam(
            $sstmt,
            $scount,
            "SELECT id, CONCAT(angi, buleg) FROM `angis` WHERE tuluv='0' and school_id='$pid' $sql ORDER BY angi, buleg",
            $t_id,
            $name
        );
        while (_fetch($sstmt)) {
            $val .= "<option value='$t_id'>$name</option>";
        }
        echo $val;
    } else if ($_POST["type"] == "bulegList") {
        $pid = $_POST["id"];
        _selectNoParam(
            $sstmt,
            $scount,
            "SELECT id, name FROM `shalguurs` WHERE buleg_id='$pid'",
            $t_id,
            $name
        );
        while (_fetch($sstmt)) {
            $val .= "<option value='$t_id'>$name</option>";
        }
        echo $val;
    } else {
        echo $val;
    }
}
