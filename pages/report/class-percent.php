<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

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
        <h3>Ангийн ирцийн гүйцэтгэл <?php ?></h3>
    </div>
    <div class="row">
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
    <div class="modal fade" id="detialmain" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detialLabel">ИРЦ БҮРТГЭЛ</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body-main">
    
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
        	a.download = 'Ангийн ирцийн гүйцэтгэл' + ', ' + $('#sdate').val() + '-' + $('#ldate').val() + '.xls'
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
                url: "class-percent-ss",
                type: "POST",
                data: {
                    sdate: $('#sdate').val(),
                    ldate: $('#ldate').val()
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
                url: "irc-class",
                type: "POST",
                data: {
                    mode: 4,
                    sdate: $('#sdate').val(),
                    edate: $('#ldate').val(),
                    class: id
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#modal-body-main").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $("#modal-body-main").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $("#modal-body-main").html(data);
                },
                async: true
            });
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>