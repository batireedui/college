<?php
_selectNoParam(
    $st,
    $co,
    "SELECT id, concat(fname, ' ', UPPER(lname)) as name, at FROM `teacher` WHERE tuluv = 1",
    $id, $lname, $at);
    $users = array();
    
    while(_fetch($st)){
        $user = new stdClass();
        $user->title = $lname;
        $user->alt = $at;
        $user->id = $id;
        $user->date = $at;
        $user->fpath = "/images/users/$id.jpg";
        array_push($users, $user);
    }
    echo json_encode($users);