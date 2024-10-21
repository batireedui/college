<?php
$val = "";
$h_jil = $this_on;
$jil = $_POST['jil'];

$table = "s_sudalgaas";

if($jil != $h_jil){
    $table = $table . substr($jil, 0, 4);
}

$sql = "";
$vsql = "";


if ($_POST["type"] == "valget") {
    $pid = $_POST["id"];
    $myObj = new stdClass();
    $schools = new stdClass();
    _selectNoParam(
        $sstmt,
        $scount,
        "SELECT (SELECT COUNT(distinct student_id) FROM `$table` 
            INNER JOIN students ON $table.student_id = students.id 
            WHERE shalguur_id = '$pid' $vsql), 
        (SELECT COUNT(distinct student_id) FROM `$table` 
            INNER JOIN students ON $table.student_id = students.id 
            WHERE shalguur_id = '$pid' and value = 1  $vsql)",
        $too,
        $yes
    );
    while (_fetch($sstmt)) {
        //array_push($val, [$too, $yes, $no]);
        $val .= "<div class='btn btn-outline-secondary' style='margin: 10px'>Судалгаа бөглөсөн: $too</div><div class='btn btn-outline-danger' style='margin: 10px' onclick='itemGet($pid, 1)'>Тийм: $yes</div>";
    }
    
    _selectNoParam(
        $sstmts,
        $scounts,
        "SELECT COUNT(distinct student_id), class.id, class.sname FROM `$table` INNER JOIN students ON $table.student_id = students.id INNER JOIN class ON students.class = class.id WHERE `value` = 1 AND shalguur_id = '$pid' $vsql GROUP BY class.id",
        $stoo,
        $sid,
        $sname
    );
    $sstoo = [];
    $ssname= [];
    while (_fetch($sstmts)) {
        //$sstoo[] = array("stoo"=>$stoo,"sid"=>$sid,"sname"=>$sname);
        array_push($sstoo, $stoo);
        array_push($ssname, $sname);
    }
    
    $myObj->val = $val;
    $myObj->sstoo = $sstoo;
    $myObj->ssname = $ssname;
    $data = json_encode($myObj);
    echo $data;
}

if ($_POST["type"] == "itemvalget") {
    $pid = $_POST["id"];
    $getval = $_POST["getval"];
    _selectRowNoParam(
        "SELECT name FROM s_shalguurs WHERE id = '$pid'",
        $name1
    );
    _selectNoParam(
        $sstmt,
        $scount,
        "SELECT shalguur_id, name, count(distinct student_id) FROM `$table` 
            INNER JOIN s_shalguurs ON $table.shalguur_id = s_shalguurs.id 
            WHERE value='1' and 
            student_id IN (SELECT DISTINCT student_id FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE shalguur_id = '$pid' and value='1' $vsql) GROUP BY shalguur_id",
        //"SELECT COUNT(student_id), shalguur_id, shalguurs.name, value FROM `$table` INNER JOIN shalguurs ON $table.shalguur_id = shalguurs.id WHERE student_id IN (SELECT DISTINCT student_id FROM `$table` WHERE shalguur_id = '$pid' and value = '$getval') GROUP BY shalguur_id",
        $shalguur_id,
        $name,
        $too
    );
    $tempName = "";
    while (_fetch($sstmt)) {
        if ($tempName == $shalguur_id) {
                $val .= "<a href='/sudalgaa/statistics/stcompare-list?id=$shalguur_id&ids=$pid&name=$name&jil=$jil'><button class='btn btn-outline-danger' style='margin: 10px'>Тийм: $too</button></a><br>";
        } else {
            /*if ($value == "0") {
                $val .= "<div>Шалгуур: <span style='font-weight: bold'>$name</span></div><button class='btn btn-outline-primary' style='margin: 10px'>Үгүй: $too</button>";
            } else {*/
                $val .= "<tr><td><div>Шалгуур: <span style='font-weight: bold'>$name</span></div></td><td><a href='/sudalgaa/statistics/stcompare-list?id=$shalguur_id&ids=$pid&name=$name&name1=$name1&jil=$jil'><button class='btn btn-outline-danger' style='margin: 10px'>Тийм: $too</button></a></td></tr>";
            //}
        }
        $tempName = $shalguur_id;
    }
    echo "<table class='table'>" . $val ."</table>";
    //echo json_encode($val);
}