<?php
require ROOT . '/pages/api/header.php';
$userinfo = _teacherAuth($token);
    if(!empty($userinfo)){
        $user_id = $userinfo['id'];
        
        $year= $obj['year'];
        $sar= $obj['month'];
        $f_date = "$year-$sar-01";
        
        $l_date = date("Y-m-t", strtotime($f_date));
        
         _selectNoParam(
                $cstmt,
                $ccount,
                "SELECT ognoo FROM att WHERE tid = '".$user_id."' AND ognoo >= '".$f_date."' AND ognoo <= '".$l_date."' GROUP BY ognoo",
                $ognoo
        );
        $udur = "{";
        while (_fetch($cstmt)) 
        {
            $udur .= '"'. $ognoo . '"';
            $udur .= ': { "customStyles": { "text": { "fontWeight": "bold", "color": "#23438f" }} }, ';
        }
        if(strlen($udur) > 5)
            $udur = substr( $udur, 0, -2 );
        $udur .= "}";
        echo json_encode($udur);
}
?>