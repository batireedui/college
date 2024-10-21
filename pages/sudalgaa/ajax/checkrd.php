<?php
if (isset($_SESSION['user_id'])) {
    $val = "no";
    if ($_POST["type"] == "checkrd") {
        $pid = $_POST["rd"];
        _selectRowNoParam(
            "SELECT id, rd, fname, lname, gender, school_id, tuluv FROM `students` WHERE rd='$pid'",
            $id,
            $rd,
            $fname,
            $lname,
            $gender,
            $school_id,
            $tuluv
        );
        $school_name = "Өөр сургуульд бүртгэлтэй байна.";
        if ($school_id > 0) {
            _selectRowNoParam(
                "SELECT school_name FROM `schools` WHERE id='$school_id'",
                $school_name
            );
        }
        $stu = new stdClass;
        if (!empty($fname)) {
            $stu->id = $id;
            $stu->rd = $rd;
            $stu->fname = $fname;
            $stu->lname = $lname;
            $stu->gender = $gender;
            $stu->school_id = $school_id;
            $stu->tuluv = $tuluv;
            $stu->school_name = $school_name;
            $val = json_encode($stu);
        }
        echo $val;
    }
    
    if ($_POST["type"] == "checkrdBagsh") {
        $pid = $_POST["rd"];
        _selectRowNoParam(
            "SELECT id, rd, fname, lname, gender, school_id, phone, email, mergejil, jil, tuluv FROM `teachers` WHERE rd='$pid'",
            $id,
            $rd,
            $fname,
            $lname,
            $gender,
            $school_id,
            $phone, $email, $mergejil, $jil,
            $tuluv
        );
        $school_name = "Өөр сургуульд бүртгэлтэй байна.";
        if ($school_id > 0) {
            _selectRowNoParam(
                "SELECT school_name FROM `schools` WHERE id='$school_id'",
                $school_name
            );
        }
        $stu = new stdClass;
        if (!empty($fname)) {
            $stu->id = $id;
            $stu->rd = $rd;
            $stu->fname = $fname;
            $stu->lname = $lname;
            $stu->gender = $gender;
            $stu->school_id = $school_id;
            $stu->tuluv = $tuluv;
            $stu->phone = $phone;
            $stu->email = $email;
            $stu->mergejil = $mergejil;
            $stu->jil = $jil;
            $stu->school_name = $school_name;
            $val = json_encode($stu);
        }
        echo $val;
    }
}
