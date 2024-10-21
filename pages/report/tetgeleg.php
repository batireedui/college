<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$sql = "";
if ($user_role < 2) {
    $sql = " and class.teacherid = '$user_id'";
}

_selectNoParam(
    $cstmt,
    $ccount,
    "SELECT id, sname, name FROM class WHERE tuluv=1 $sql ORDER BY sname",
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
    <div class="row">
        <div class="col-md">
            <label>Анги</label>
            <select class="form form-control mb-3" id="class">
                <?php while (_fetch($cstmt)) : ?>
                    <option value="<?= $class_id ?>"><?= $sname ?> (<?= $class_name ?>)</option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <label>Он</label>
            <select class="form form-control mb-3" id="on">
                <?php
                $con = $thison;
                while($con >= $starton){?>
                    <option><?=$con?></option>
                <?php $con--; } ?>
            </select>
        </div>
        <div class="col-md-1">
            <label>Сар</label>
            <select class="form form-control mb-3" id="sar">
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
    <div style="text-align: end" class="mb-3">
        <a href="#" onclick="exportToExcel('table')" role="button" class="btn btn-success" style="">Excel</a>
        <a href="#" onclick="print()" role="button" class="btn btn-primary" style="">Хэвлэх</a>
    </div>
    <div class="action">

    </div>
    <div id="table">

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
        <div class="modal fade" id="batal" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detialLabel">БАТАЛГААЖУУЛАЛТ</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body-batal">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                        <button type="button" class="btn btn-danger" onclick="batal()" style="">БАТАЛГААЖУУЛ</button>
                    </div>
                </div>
            </div>
        </div>
                <div class="modal fade" id="cancel" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detialLabel">БАТАЛГААЖУУЛАЛТ ЦУЦЛАХ</h5>
                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modal-body-cancel">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                        <button type="button" class="btn btn-danger" onclick="cancel()" style="">ЦУЦЛАХ</button>
                    </div>
                </div>
            </div>
        </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function exportToExcel(tableId, name="ИРЦ БҮРТГЭЛИЙН ПРОГРАМ"){
        	let tableData = document.getElementById(tableId).outerHTML;
        	tableData = tableData.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
            tableData = tableData.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params
        
        	let a = document.createElement('a');
        	a.href = `data:application/vnd.ms-excel, ${encodeURIComponent(tableData)}`
        	a.download = $('#class option:selected').text() + ', ' + $('#on').val() + '-' + $('#sar').val() + '.xls'
        	a.click()
    }
    function print(){
        $('#table').printElement({
        });
    }
    function detial(id) {
                row_click(id)
                $.ajax({
                    url: "../att/student",
                    type: "POST",
                    data: {
                        mode: 1,
                        id: id,
                        son: $('#on').val(),
                        ssar: $('#sar').val(),
                        lon: $('#on').val(),
                        lsar: $('#sar').val()
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
    }
    function check() {
        $('div.action').each(function() {
            $(this).html("");
        });
        if ($('#class').val() === null) {
            alert("Анги сонгогдоогүй байна!");
        } else {
            $("#table").html("");
            $.ajax({
                url: "tetgeleg-ss",
                type: "POST",
                data: {
                    class: $('#class').val(),
                    on: $('#on').val(),
                    sar: $('#sar').val(),
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
    function batalClick() {
        let val = $('#class_name').html() + " ангийн ирцийг баталгаажуулахдаа итгэлтэй байна уу! Баталгаажуулсан тохиолдолд тус ангид тухайн сард багш нар ирц оруулах, засварлах боломжгүй болно.";
        $("#modal-body-batal").html(val);
    }
    function batal() {
        if ($('#class').val() === null) {
            alert("Анги сонгогдоогүй байна!");
        } else {
            $.ajax({
                mode: 0,
                url: "batal",
                type: "POST",
                data: {
                    class: $('#class').val(),
                    on: $('#on').val(),
                    sar: $('#sar').val(),
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#modal-body-batal").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $("#modal-body-batal").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $("#modal-body-batal").html(data);
                },
                async: true
            });
        }
    }
    function cancelClick() {
        let val = $('#class_name').html() + " ангийн ирцийн баталгаажуулалт цуцлахдаа итгэлтэй байна уу! Цуцалсан тохиолдолд тус ангид тухайн сард багш нар ирц оруулах, засварлах боломжтой болно.";
        $("#modal-body-cancel").html(val);
    }
    function cancel() {
        if ($('#class').val() === null) {
            alert("Анги сонгогдоогүй байна!");
        } else {
            $.ajax({
                url: "batal",
                type: "POST",
                data: {
                    mode: 1,
                    class: $('#class').val(),
                    on: $('#on').val(),
                    sar: $('#sar').val(),
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#modal-body-cancel").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $("#modal-body-cancel").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $("#modal-body-cancel").html(data);
                },
                async: true
            });
        }
    }
</script>
<?php

require ROOT . "/pages/end.php";
?>