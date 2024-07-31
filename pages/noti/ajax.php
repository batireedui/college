<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];
    if ($mode == 1) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $users = $_POST['users'];
        $success = _exec(
            "INSERT INTO noti (title, body, ognoo, userid) VALUES(?, ?, ?, ?)",
            'sssi',
            [$title, $body, ognoo(), $_SESSION['user_id']],
            $lastid
        );
        foreach($users as $user){
            $success = _exec(
            "INSERT INTO noti_user (noti_id, user_id) VALUES(?, ?)",
            'ii',
            [$lastid, $user],
            $ok
        );
        echo "Амжилттай";
        }
    }
}