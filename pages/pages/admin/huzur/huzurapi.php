<?php
if(isset($_POST['getTeach'])){
$id = $_POST['id'];
_selectNoParam(
    $cstmt,
    $ccount,
    "SELECT huzurteacher.id, huzurteacher.name FROM `huzurteachset` INNER JOIN huzurteacher ON huzurteachset.teachid = huzurteacher.id WHERE huzurteachset.huzurid = $id",
    $tid,
    $tname
);
$val = "";
while (_fetch($cstmt)) {
        $val .= "<option value='$tid'>$tname</option>";
    }
echo $val;
}

else if (isset($_POST['cagadd'])) {
    $turul = post('turul', 10);
    $ognoo = post('ognoo', 50);
    $cag = post('cag', 2);
    $min = post('min', 2);
    $link = post('link', 200);
    $teacher = post('teacher', 10);
    $ognoo = $ognoo." ".$cag . ":" . $min . ":00";
    $cognoo = date("Y-m-d H:i:s", strtotime($ognoo));
    _selectNoParam(
        $cstmt,
        $ccount,
        "SELECT id FROM `huzurcag` WHERE teachid = '$teacher' and hezee = '$cognoo'",
        $cid
    );
    if($ccount > 0){}
    else{
        try {
            $success = _exec(
                "insert into huzurcag(huzurtypeid, hezee, teachid, link, dtuluv, user_type) VALUES(?, ?, ?, ?, ?, ?)",
                'isisis',
                [$turul, $ognoo, $teacher, $link, '0', 'admin'],
                $count
            );
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
             echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
    }
    redirect('/admin/huzur/huzur');
}
?>