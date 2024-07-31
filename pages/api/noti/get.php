<?php
require ROOT . '/pages/api/header.php';
$userinfo = _teacherAuth($token);
    if(!empty($userinfo)){
        $user_id = $userinfo['id'];
        
        _selectNoParam(
            $stmt,
            $count,
            "SELECT noti_user.id, title, body, ognoo, see FROM `noti` INNER JOIN noti_user ON noti.id = noti_user.noti_id
                            WHERE noti_user.user_id = '$user_id' ORDER BY ognoo DESC",
            $id,
            $title,
            $body,
            $ognoo,
            $see
        );
        
        $zaasanArr = [];
        while (_fetch($stmt)) {
            $item = new stdClass;
            $item->id = $id;
            $item->title = $title;
            $item->body = $body;
            $item->ognoo = $ognoo;
            $item->see = $see;
            
            array_push($zaasanArr, $item);
        }
        echo json_encode($zaasanArr);
}
?>