<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

_select(
    $tstmt,
    $tcount,
    "SELECT class.name, id, sname FROM class WHERE tuluv=? ORDER BY sname",
    "i",
    [1],
    $class_name,
    $class_id,
    $sname
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
        <h3>Ангийн ирц бүртгэл <?php ?></h3>
    </div>
    <div class="row">
        <div class="col-md">
            <select class="form form-control mb-3" id="class_id">
                <?php
                while (_fetch($tstmt)) {
                    echo "<option value='$class_id'>$sname, $class_name</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" class="form form-control mb-3" id="sdate" value="<?= date('Y-m-01') ?>" autocompleted />
        </div>
        <div class="col-md-2">
            <input type="date" class="form form-control mb-3" id="ldate" value="<?= date('Y-m-d') ?>" autocompleted />
        </div>
        <div class="col-md-2">
            <button class="btn btn-warning w-100" onclick="check()">ХАРАХ</button>
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
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function exportToExcel(tableId, name="ИРЦ БҮРТГЭЛИЙН ПРОГРАМ"){
        	let tableData = document.getElementById(tableId).outerHTML;
        	tableData = tableData.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
            tableData = tableData.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params
        
        	let a = document.createElement('a');
        	a.href = `data:application/vnd.ms-excel, ${encodeURIComponent(tableData)}`
        	a.download = $('#class_id option:selected').text() + ', ' + $('#sdate').val() + '-' + $('#ldate').val() + '.xls'
        	a.click()
    }
    function print(){
        $('#table').printElement({
        });
    }
    function check() {
        $('div.action').each(function() {
            $(this).html("");
        });
        if ($('#class_id').val() === null) {
            alert("Анги сонгогдоогүй байна!");
        } else {
            $("#table").html("");
            $.ajax({
                url: "irc-class",
                type: "POST",
                data: {
                    mode: 4,
                    sdate: $('#sdate').val(),
                    edate: $('#ldate').val(),
                    class: $('#class_id').val()
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
    }
</script>
<?php

require ROOT . "/pages/end.php";
?>