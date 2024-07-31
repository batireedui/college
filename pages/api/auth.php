<?php
function _teacherAuth($tok) {
    _selectRowNoParam(
        "SELECT id FROM teacher WHERE token='$tok'",
        $id
    );
    if(isset($id)) return $id;
    else false;
}