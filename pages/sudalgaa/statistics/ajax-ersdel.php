<?php
$sql = "";

$h_jil = $_SESSION['jil'];
$jil = $_POST['jil'];
$table = "sudalgaas";

if ($jil != $h_jil) {
    $table = $table . substr($jil, 0, 4);
}

if ($_SESSION['user_role'] == "najiltan") {
    $sql = " and students.school_id = " . $_SESSION['school_id'];
} elseif ($_SESSION['user_role'] == "teacher") {
    $sql = " and students.school_id = " . $_SESSION['school_id'] . " and angis.teacher_id = " . $_SESSION['user_id'];
}
$sqlu = "SELECT COUNT(DISTINCT students.id) FROM students INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id 
WHERE students.tuluv=0 $sql and 
(students.id IN (SELECT DISTINCT student_id FROM $table WHERE (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) or students.id IN 
(SELECT DISTINCT student_id FROM `$table` WHERE `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) > 11))";

_selectRowNoParam(
    $sqlu,
    $undur
);
$sqld = "SELECT COUNT(DISTINCT students.id) FROM students 
INNER JOIN schools ON students.school_id = schools.id 
INNER JOIN angis ON students.angi_id = angis.id 
WHERE students.tuluv=0 $sql and students.id NOT IN 
(SELECT DISTINCT student_id FROM $table WHERE  (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) and students.id IN 
(SELECT DISTINCT student_id FROM `$table` WHERE `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) < 12 and COUNT(shalguur_id) > 7)";
_selectRowNoParam(
    $sqld,
    $dund
);
$sqlb = "SELECT COUNT(DISTINCT students.id) FROM students INNER JOIN schools ON students.school_id = schools.id 
INNER JOIN angis ON students.angi_id = angis.id 
WHERE students.tuluv=0 $sql and students.id NOT IN 
(SELECT DISTINCT student_id FROM $table WHERE (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) and students.id IN 
(SELECT DISTINCT student_id FROM `$table` WHERE `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) < 8 and COUNT(shalguur_id) > 3)";

_selectRowNoParam(
    $sqlb,
    $baga
);
$sqln = "SELECT COUNT(DISTINCT students.id) FROM students 
INNER JOIN $table ON students.id = $table.student_id 
INNER JOIN schools ON students.school_id = schools.id INNER JOIN angis ON students.angi_id = angis.id 
WHERE students.tuluv=0 $sql and students.id NOT IN 
(SELECT DISTINCT student_id FROM $table WHERE (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) and students.id NOT IN 
(SELECT DISTINCT student_id FROM `$table` WHERE `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) > 3)";

_selectRowNoParam(
    $sqln,
    $ugui
);

$sstoo = [];
$ssname = [];
array_push($sstoo, $undur);
array_push($ssname, "Өндөр эрсдэлтэй");

array_push($sstoo, $dund);
array_push($ssname, "Дунд эрсдэлтэй");

array_push($sstoo, $baga);
array_push($ssname, "Бага эрсдэлтэй");

array_push($sstoo, $ugui);
array_push($ssname, "Эрсдэлтгүй");
$myObj = new stdClass();
$myObj->sstoo = $sstoo;
$myObj->ssname = $ssname;
$data = json_encode($myObj);
echo $data;
