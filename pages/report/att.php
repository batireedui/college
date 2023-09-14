<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$sql = "";
if ($user_role < 3) {
    $sql = " and class.teacherid = '$user_id'";
}

_selectNoParam(
    $cstmt,
    $ccount,
    "SELECT id, sname, name FROM class WHERE tuluv=1",
    $class_id,
    $sname,
    $class_name
);

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
        <h3>Ирцийн тайлан <?php ?></h3>
    </div>
    <div class="row mb-3">
        <div class="col-md">
            <label>Анги</label>
            <select class="form form-control mb-3" id="class">
                <?php while (_fetch($cstmt)) : ?>
                    <option value="<?= $class_id ?>"><?= $sname ?> (<?= $class_name ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>Эхлэх он</label>
            <select class="form form-control mb-3" id="son">
                <option>2023</option>
            </select>
        </div>
        <div class="col-md-1">
            <label>Сар</label>
            <select class="form form-control mb-3" id="ssar">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Сүүлийн он</label>
            <select class="form form-control mb-3" id="lon">
                <option>2023</option>
            </select>
        </div>
        <div class="col-md-1">
            <label>Сар</label>
            <select class="form form-control mb-3" id="lsar">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
            </select>
        </div>
        <div class="col-md-2">
            <label></label>
            <button class="btn btn-warning w-100" onclick="check()">Харах</button>
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
                    class: $('#class').val(),
                    son: $('#son').val(),
                    ssar: $('#ssar').val(),
                    lon: $('#lon').val(),
                    lsar: $('#lsar').val()
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