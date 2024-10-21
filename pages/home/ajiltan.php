<?php
if (isset($_SESSION['user_id'])) {
_selectNoParam(
    $stmt,
    $count,
    "SELECT id, teacher.fname, teacher.lname, at FROM teacher WHERE id = '".$_SESSION['user_id']."' and tuluv = 1",
    $id,
    $fname,
    $lname,
    $at
);

_selectNoParam(
    $cstmt,
    $ccount,
    "SELECT id, hezee, tsag, userid FROM att_work WHERE userid = '".$_SESSION['user_id']."' ORDER BY hezee DESC LIMIT 300",
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
                       <?php foreach ($cagArr as $cel) {
                       if($id == $cel->userid) {
                            echo "<span class='alert alert-success'>$cel->hezee $cel->tsag</span>";
                        } 
                       }?>
                    </td>
                </tr>
            <?php
                }
            ?>
        </table>
    </div>
<?php
} else echo "Та дахин нэвтэрч орно уу! Холболт салсан байна"; ?>