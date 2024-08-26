<?php
require ROOT . '/pages/api/header.php';
$userinfo = _teacherAuth($token);
    if(!empty($userinfo)){
        $user_id = $userinfo['id'];
        
        $success = _exec(
            "UPDATE noti_user SET see=? WHERE user_id = '$user_id' and see is null",
            's',
            [ognoo()],
            $count
        );
}
?>