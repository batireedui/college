<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

$sql = "";
$tid = "0";
$sdate = date('Y-m-01');
if (isset($_GET['sdate'])) $sdate = $_GET['sdate'];
$edate = date('Y-m-d');
if (isset($_GET['edate'])) $edate = $_GET['edate'];
if (isset($_GET['tid'])) $tid = $_GET['tid'];

if ($_SESSION['user_role'] < 3) {
    _select(
        $tstmt,
        $tcount,
        "SELECT id, fname, lname FROM teacher WHERE id=? and tuluv=? ORDER BY lname",
        "ii",
        [$_SESSION['user_id'], 1],
        $stid,
        $fname,
        $lname
    );

    $sql = "att.tid = '" . $_SESSION['user_id'] . "' and";
} else {
    _select(
        $tstmt,
        $tcount,
        "SELECT id, fname, lname FROM teacher WHERE tuluv=? ORDER BY lname",
        "i",
        [1],
        $stid,
        $fname,
        $lname
    );

    $sql = "att.tid = '" . $tid . "' and";
    if ($tid == 0) $sql = "";
}
_selectNoParam(
    $stmt,
    $count,
    "SELECT att.id, class.name, tlesson.lessonName, cag.name, cag.inter, ognoo, att.lessonid, class.sname, att.tuluv, tlesson.cag, att.tid FROM att 
        INNER JOIN class ON att.classid = class.id 
            INNER JOIN tlesson ON att.lessonid = tlesson.id 
                INNER JOIN cag ON att.cagid = cag.id 
                    WHERE $sql ognoo BETWEEN '$sdate' and '$edate' ORDER BY ognoo DESC , cag.name DESC",
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
    $item->ognoo = $ognoo;
    $item->lessonid = $lessonid;
    $item->sname = $sname;
    $item->atttuluv = $atttuluv;
    $item->lcag = $lcag;
    $item->tid = $atttid;
    array_push($zaasanArr, $item);
}
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
        <h3>ХИЧЭЭЛ ОРОЛТУУД</h3>
    </div>
    <form>
        <div class="row mb-3">
            <div class="col-md">
                <select class="form form-control mb-3" name='tid'>
                    <?php
                    if ($_SESSION['user_role'] > 1) {
                        echo "<option value='0'>Бүгд</option>";
                    }
                    while (_fetch($tstmt)) {
                        echo "<option value='$stid'";
                        if ($tid == $stid) echo " selected";
                        echo ">$fname $lname</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md">
                <input type="date" class="form form-control mb-3" name="sdate" value="<?= $sdate ?>" autocompleted />
            </div>
            <div class="col-md">
                <input type="date" class="form form-control mb-3" name="edate" value="<?= $edate ?>" autocompleted />
            </div>
            <div class="col-md-2">
                <button class="btn btn-warning w-100">ХАРАХ</button>
            </div>
        </div>
        </from>
        <div id="table">
            <table class="table table-bordered table-hover" id="datalist">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>Анги</th>
                        <th>Хичээл</th>
                        <th>Цаг</th>
                        <th></th>
                    </tr>
                </thead>
                <?php $too = 0;
                foreach ($zaasanArr as $el) :
                    $too++ ?>
                    <tr class="table_rows" id="trow-<?= $el->id ?>">
                        <td><?= $too ?></td>
                        <td id="f1-<?= $el->id  ?>" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" onclick="detial(<?= $el->id ?>)"><?= $el->sname ?> <?= $el->class ?></td>
                        <td id="f2-<?= $el->id  ?>" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" onclick="detial(<?= $el->id ?>)"><?= $el->lesson ?> (<?= $el->lcag ?> цаг)</td>
                        <td id="f3-<?= $el->id  ?>" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" onclick="detial(<?= $el->id ?>)"><?= str_replace("-", ".",  $el->ognoo) ?>, <?= dayofweek($el->ognoo); ?>, <?= $el->cag ?> (<?= $el->cag_inter ?>)</td>
                        <td><?php
                            if ($user_id == $el->tid) {
                                echo $el->atttuluv == 1 ?
                                    "<span class='alert alert-success'>Баталгаажсан</span>" :
                                    "<span class='alert alert-danger' role='button'
                                        data-mdb-toggle='modal' data-mdb-target='#deleteModal'
                                        onclick='deleteAtt(" . $el->id . ")'
                                        >Устгах</span>" . $el->atttuluv;
                            } ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </div>
</div>
<div class="modal fade" id="detial" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detialLabel">ИРЦ БҮРТГЭЛ</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteLabel">ИРЦ БҮРТГЭЛ УСТГАХ</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-dbody">

            </div>
            <input type="text" style="display: none;" id="deleteId" />
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                <button type="button" class="btn btn-danger" onclick="attDelete()">Устгах</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    function detial(id) {
        row_click(id)
        $.ajax({
            url: "../att/detial",
            type: "POST",
            data: {
                mode: 2,
                id: id
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#modal-body").html("Алдаа гарлаа !");
            },
            beforeSend: function() {
                $('#modal-body').html("Түр хүлээнэ үү ...");
            },
            success: function(data) {
                $('#modal-body').html(data);
            },
            async: true
        });
    };

    function deleteAtt(id) {
        row_click(id)
        $('#deleteId').val(id);
        $('#modal-dbody').html($('#f1-' + id).text() + ' ангид ' + $('#f3-' + id).text() + ' орсон ' + $('#f2-' + id).text() + ' хичээлийн ирц бүртгэл утсгах уу?');
    }

    function attDelete() {
        $.ajax({
            url: "../att/ajax",
            type: "POST",
            data: {
                mode: 4,
                attid: $('#deleteId').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#modal-dbody").html("Алдаа гарлаа !");
            },
            beforeSend: function() {
                $('#modal-dbody').html("Түр хүлээнэ үү ...");
            },
            success: function(data) {
                location.reload();
            },
            async: true
        });

    }
</script>
<?php
require ROOT . "/pages/footer.php";
require ROOT . "/pages/dataTablefooter.php";
require ROOT . "/pages/end.php";
?>