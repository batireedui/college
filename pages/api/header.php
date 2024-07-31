<?php
$json = file_get_contents('php://input');
$obj = json_decode($json, true);
$token = "";
$token = @$obj["token"];

function _teacherAuth($tok) {
    _selectRowNoParam(
        "SELECT id, fname, lname, phone, user_role FROM teacher WHERE token='$tok'",
        $id, $fname, $lname, $phone, $user_role
    );
    if(isset($id)) {
        $_SESSION['user_id'] = $id;
        return array("id" => $id, "fname" => $fname, "lname" => $lname, "phone" => $phone, "user_role" => $user_role);
    }
    else return array();
}

function _parentAuth($tok) {
    _selectRowNoParam(
        "SELECT id FROM parent WHERE token='$tok'",
        $id
    );
    if(isset($id)) return $id;
    else return false;
}