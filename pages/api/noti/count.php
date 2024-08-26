<?php
require ROOT . '/pages/api/header.php';
$userinfo = _teacherAuth($token);
    if(!empty($userinfo)){
        $user_id = $userinfo['id'];
        $too = 0;
        _selectRowNoParam(
            "SELECT count(id) FROM noti_user 
                            WHERE noti_user.user_id = '$user_id' and see is null",
            $too
        );
        
        echo $too;
}
?>