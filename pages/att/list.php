<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$sql = "";
if ($user_role < 3) {
    $sql = "class.teacherid = '$user_id' and ";
}

_select(
    $tstmt,
    $tcount,
    "SELECT class.name, tclass.classid, sname FROM tclass INNER JOIN class ON tclass.classid = class.id WHERE tuluv=1 and tclass.tid = ?",
    "i",
    [$user_id],
    $class_name,
    $class_id,
    $sname
);

_selectNoParam(
    $cstmt,
    $ccount,
    "SELECT id, name, inter FROM cag WHERE tuluv = 1",
    $cag_id,
    $cag_name,
    $cag_inter
);

$classList = array();

while (_fetch($tstmt)) {
    $item = new stdClass();
    $item->class_name = $class_name;
    $item->sname = $sname;
    $item->class_id = $class_id;

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
        <h3>Ирц бүртгэл <?php ?></h3>
    </div>
    <div class="row mb-3">
        <div class="col-md-2">
            <input type="date" class="form form-control mb-3" id="date" value="<?= date('Y-m-d') ?>" autocompleted />
        </div>
        <div class="col-md">
            <select class="form form-control mb-3" id="class">
                <?php foreach ($classList as $el) : ?>
                    <option value="<?= $el->class_id ?>"><?= $el->sname ?> <?= $el->class_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form form-control mb-3" id="cag">
                <?php while (_fetch($cstmt)) : ?>
                    <option value="<?= $cag_id ?>">(<?= $cag_inter ?> цаг) <?= $cag_name ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning w-100" onclick="check()">ШАЛГАХ</button>
        </div>
    </div>
    <div class="action">

    </div>
    <div id="table">

    </div>
    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel">Суралцагч устгах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="deletebody">

                    </div>
                    <input type="text" value="0" id="delete_s_id" readonly style="display: none;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                    <button type="button" class="btn btn-danger" onclick="deleteStudent()">Устгах</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function check() {
        $('div.action').each(function() {
            $(this).html("");
        });
        if ($('#class').val() === null) {
            alert("Анги сонгогдоогүй байна!");
        } else {
            $("#table").html("");
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 1,
                    date: $('#date').val(),
                    class: $('#class').val(),
                    cag: $('#cag').val()
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#table").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $("#table").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $("#table").html(data);
                },
                async: true
            });
        }
    }
</script>
<?php

require ROOT . "/pages/end.php";
?>