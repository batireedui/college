<?php
require ROOT . '/pages/api/header.php';
$userinfo = _teacherAuth($token);
    if(!empty($userinfo)){
        $user_id = $userinfo['id'];
        
        $ognoo= $obj['date'];
        
        _selectNoParam(
            $stmt,
            $count,
            "SELECT att.id, class.name, tlesson.lessonName, cag.name, cag.inter, ognoo, att.lessonid, class.sname, att.tuluv, tlesson.cag, att.tid FROM att 
                INNER JOIN class ON att.classid = class.id 
                    INNER JOIN tlesson ON att.lessonid = tlesson.id 
                        INNER JOIN cag ON att.cagid = cag.id 
                            WHERE att.tid = '$user_id' AND ognoo ='$ognoo' ORDER BY ognoo ASC , cag.name ASC",
            $id,
            $class,
            $lesson,
            $cag,
            $cag_inter,
            $ognoo,
            $lessonid,
            $sname,
            $atttuluv,
            $lcag,
            $atttid
        );
        
        $zaasanArr = [];
        while (_fetch($stmt)) {
            $item = new stdClass;
            $item->id = $id;
            $item->class = $class;
            $item->lesson = $lesson;
            $item->cag = $cag;
            $item->cag_inter = $cag_inter;
            $item->ognoo = str_replace("-", ".",  $ognoo);
            $item->udur = dayofweek($ognoo);
            $item->sname = $sname;
            $item->atttuluv = $atttuluv;
            $item->lcag = $lcag;
            $item->tid = $atttid;
            array_push($zaasanArr, $item);
        }
        echo json_encode($zaasanArr);
}
?>