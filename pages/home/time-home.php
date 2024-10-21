<?php
if (isset($_SESSION['user_id'])) {
$date = date('Y-m-d');
if (isset($_POST['date']))
 { $date = $_POST['date']; }

_selectNoParam(
    $stmt,
    $count,
    "SELECT id, teacher.fname, teacher.lname, at FROM teacher WHERE tuluv = 1",
    $id,
    $fname,
    $lname,
    $at
);

_selectNoParam(
    $cstmt,
    $ccount,
    "SELECT id, hezee, tsag, userid FROM att_work WHERE hezee = '$date'",
    $id,
    $hezee,
    $tsag,
    $userid
);

$cagArr = [];

while (_fetch($cstmt)) {
    $item = new stdClass();
    $item->id = $id;
    $item->hezee = $hezee;
    $item->tsag = $tsag;
    $item->userid = $userid;
    array_push($cagArr, $item);
}

_selectNoParam(
    $offstmt,
    $offcount,
    "SELECT userid FROM att_off WHERE start_off <= '$date' and end_off >= '$date'",
    $offid
);

$offArr = [];

while (_fetch($offstmt)) {
    $item = new stdClass();
    $item->offid = $offid;
    array_push($offArr, $item);
}

?>
    <div id="table">
        <table class="table table-bordered hovercell">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Багш/Ажилтан</th>
                    <th>Хэзээ</th>
                </tr>
            </thead>
            <?php
            $k = 0;
            while (_fetch($stmt)) { $k++; ?>
                <tr>
                    <td style='text-align: center'><?= $k ?></td>
                    <td role="button" onclick="alert(<?=$id?>)"><?= $fname ?> <?= $lname ?><br><small class="badge badge-info"><?=$at?></small></td>
                    <td>
                       <?php
                       foreach ($cagArr as $cel) {
                       if($id == $cel->userid) {
                            echo "<span class='alert alert-success'>$cel->hezee $cel->tsag</span>";
                            } 
                       }
                       foreach ($offArr as $celoff) {
                        if($id == $celoff->offid) {
                            echo "<span class='alert alert-warning'>Ч</span>";
                            } 
                       }
                       ?>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
    </div>
<?php
} else echo "Та дахин нэвтэрч орно уу! Холболт салсан байна"; ?>