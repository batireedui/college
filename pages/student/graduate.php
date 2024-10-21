<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$sql = "";
if ($user_role < 2) {
    $sql = "class.teacherid = '$user_id' and ";
}
_select(
    $stmt,
    $count,
    "SELECT students.id, students.code, students.fname, students.lname, students.gender, students.phone, students.class, students.pass, students.tuluv, class.name , class.sname, students.last_on
        FROM students INNER JOIN class ON students.class = class.id WHERE $sql students.tuluv=?",
    "i",
    [2],
    $id,
    $code,
    $fname,
    $lname,
    $gender,
    $phone,
    $class,
    $pass,
    $tuluv,
    $cname,
    $sname,
    $last_on
);

_select(
    $tstmt,
    $tcount,
    "SELECT id, name, sname FROM class WHERE $sql tuluv=?",
    "i",
    ['2'],
    $cid,
    $cname,
    $sname
);

$classList = array();

while (_fetch($tstmt)) {
    $item = new stdClass();
    $item->id = $cid;
    $item->name = $cname;
    $item->sname = $sname;

    array_push($classList, $item);
}

$columnNumber = 7;
?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h3>Төгсөгчдийн бүртгэл <?php ?></h3>
    </div>

    <div id="table">
        <table class="table" id="datalist">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Эцэг/эхийн нэр</th>
                    <th>Нэр</th>
                    <th>Утас</th>
                    <th>Хүйс</th>
                    <th>РД</th>
                    <th>Асран хамгаалагч</th>
                    <th>Анги</th>
                    <th>Төгссөн</th>
                </tr>
            </thead>
            <?php if ($count > 0) : ?>
                <?php $too = 0;
                while (_fetch($stmt)) :
                    $too++;
                    _selectNoParam(
                        $pstmt,
                        $pcount,
                        "SELECT tax_pareant.id, fname, lname, phone FROM parent INNER JOIN tax_pareant ON parent.id = tax_pareant.parent_id  WHERE student_id = $id",
                        $pid,
                        $pfname,
                        $plname,
                        $pphone
                    );
                    ?>
                    <tr>
                        <td><?= $too ?></td>
                        <td id="f1-<?= $id ?>"><?= $fname ?></td>
                        <td id="f2-<?= $id ?>"><?= $lname ?></td>
                        <td id="f3-<?= $id ?>"><?= $phone ?></td>
                        <td id="f4-<?= $id ?>"><?= $gender ?></td>
                        <td id="f5-<?= $id ?>"><?= $code ?></td>
                        <td id="f7-<?= $id ?>"><span onclick="getParent(<?= $id ?>)" class="badge badge-success" type="button"><?php
                            if($pcount > 0){
                                while (_fetch($pstmt)){
                                    echo substr($pfname, 0, 2) . ".$plname ($pphone)";
                                }
                            } else echo "Бүртгэгдээгүй";
                        ?></span></span></td>
                        <td id="f6-<?= $id ?>" style="font-size: 12px;"><?= $sname ?> <?= $cname ?></td>
                        <td>
                            <?=$last_on?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </table>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>

</script>
<?php
require ROOT . "/pages/dataTablefooter.php";
require ROOT . "/pages/end.php";
?>