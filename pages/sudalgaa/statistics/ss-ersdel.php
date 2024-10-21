<?php 
require ROOT . "/pages/ssp.class.php";
// DB table to use
$gtype = "1";
$h_jil = $this_on;

$jil = $_GET['jil'];
$table = "sudalgaas";

if($jil != $h_jil){
    $table = $table . substr($jil, 0, 4);
}

$sqlwhere = " and (students.id IN (SELECT student_id FROM $table WHERE (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) or students.id IN (SELECT student_id FROM `$table` WHERE `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) > 11))";
$sql = "SELECT DISTINCT students.id as student_id, fname, lname, students.phone, gender, schools.school_name, schools.id as school_id, angis.angi, angis.buleg, angis.id as angi_id, rd 
        FROM students INNER JOIN schools ON students.school_id = schools.id 
        INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 ";
if(isset($_GET['gtype'])){
    $gtype = $_GET['gtype'];
}

if($gtype == "2")
{
    $sqlwhere = " and students.id NOT IN (SELECT student_id FROM $table WHERE (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) and students.id IN (SELECT student_id FROM `$table` WHERE  `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) < 12 and COUNT(shalguur_id) > 7)"; 
}
elseif($gtype == "3")
{
    $sqlwhere = " and students.id NOT IN (SELECT student_id FROM $table WHERE (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) and students.id IN (SELECT student_id FROM `$table` WHERE  `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) < 8 and COUNT(shalguur_id) > 3)"; 
}
elseif($gtype == "4")
{
    $sqlwhere = " and students.id NOT IN (SELECT DISTINCT student_id FROM $table WHERE (shalguur_id IN (23, 72, 42, 36) and `value` = 1)) and students.id NOT IN (SELECT DISTINCT student_id FROM `$table` WHERE  `value` = 1 GROUP BY student_id HAVING COUNT(shalguur_id) > 3)"; 
    
    $sql =  "SELECT DISTINCT students.id as student_id, fname, lname, students.phone, gender, schools.school_name, schools.id as school_id, angis.angi, angis.buleg, angis.id as angi_id, rd 
                    FROM students INNER JOIN $table ON students.id = $table.student_id 
                    INNER JOIN schools ON students.school_id = schools.id 
                    INNER JOIN angis ON students.angi_id = angis.id WHERE students.tuluv=0 ";
}

$sqlw = "";
if ($_SESSION['user_role'] == "najiltan") {
    $sqlw = " and students.school_id = ".$_SESSION['school_id'];
}

elseif ($_SESSION['user_role'] == "teacher") {
    $sqlw = " and students.school_id = ".$_SESSION['school_id']." and angis.teacher_id = ".$_SESSION['user_id'];
}

$sql =  " $sql $sqlw $sqlwhere";    

$table = <<<EOT
( $sql ) temp
EOT;
 
// Table's primary key
$primaryKey = 'student_id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array(
        'db' => 'student_id',
        'dt' => 'DT_RowId',
        'formatter' => function( $d, $row ) {
            // Technically a DOM id cannot start with an integer, so we prefix
            // a string. This can also be useful if you have multiple tables
            // to ensure that the id is unique with a different prefix
            return 'row_'.$d;
        }
    ),
    array( 'db' => 'rd', 'dt' => 'rd'),
    array( 'db' => 'student_id', 'dt' => 'student_id'),
    array( 'db' => 'fname',  'dt' => 'fname' ),
    array( 'db' => 'lname',   'dt' => 'lname' ),
    array( 'db' => 'phone',     'dt' => 'phone' ),
    array( 'db' => 'gender',     'dt' => 'gender'),
    array( 'db' => 'school_name',     'dt' => 'school_name' ),
    array( 'db' => 'school_id',     'dt' => 'school_id' ),
    array( 'db' => 'angi',     'dt' => 'angi' ),
    array( 'db' => 'buleg',     'dt' => 'buleg' ),
    array( 'db' => 'angi_id',     'dt' => 'angi_id' )
);
 
// SQL server connection information
$sql_details = array(
    'user' => DB_USER,
    'pass' => DB_PASSWORD,
    'db'   => DB_NAME,
    'host' => DB_HOST
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

echo json_encode(
	SSP::simple(  $_GET, $sql_details, $table, $primaryKey, $columns)
);