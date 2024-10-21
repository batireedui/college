<?php
if (isset($_SESSION['user_id'])) {
    $val = "no";
    if ($_POST["type"] == "edits") {
        $pid = $_POST["id"];
        $val = $pid;
        _selectRowNoParam(
            "SELECT hayg, ohayg, hentei, dsects, club FROM `students` WHERE id='$pid'",
            $hayg,
            $ohayg,
            $hentei,
            $dsects,
            $club
        );
        $stu = new stdClass;
        if (!empty($club)) {
            $stu->hayg = $hayg;
            $stu->ohayg = $ohayg;
            $stu->hentei = $hentei;
            $stu->dsects = $dsects;
            $stu->club = $club;
            $val = json_encode($stu);
        }
    }
    echo $val;
}
