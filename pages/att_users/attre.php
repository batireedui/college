<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$date = date('Y-m-d');
$monthNumber = date('m');

_selectNoParam(
    $ostmt,
    $ocount,
    "SELECT id, name FROM `office` WHERE tuluv = 1",
    $oid,
    $oname
);
?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<div>
    <div class="alert alert-info m-3">
        <?= $this_on ?> ХИЧЭЭЛИЙН ЖИЛ
    </div>
    <div class="row mb-3 p-3">
        <div class="col-md">
            <h3>ЦАГ БҮРТГЭЛИЙН ТАЙЛАН</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md">
            <label>Төрөл</label>
            <select class="form form-control mb-3" id="turul">
                <option value="1">Сарын тайлан ажилтнаар</option>
                <option value="2">Цагийн мэдээ ажилтнаар</option>
                <option value="4">Хоцролтын тайлан</option>
            </select>
        </div>
        <div class="col-md">
            <label>Алба</label>
            <select class="form form-control mb-3" id="alba" onchange="tenhim()">
                <option value="0">Бүгд</option>
                <?php
                while (_fetch($ostmt)) { ?>
                    <option value="<?= $oid ?>"><?= $oname ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-md">
            <label>Тэнхим/Хэлтэс</label>
            <select class="form form-control mb-3" id="tenhim">
                <option value="0">Бүгд</option>
                <option value="2">Тайлан ажилтнаар</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Он</label>
            <select class="form form-control mb-3" id="lon">
                <?php
                $currenton = $thison;
                while ($currenton >= $starton) { ?>
                    <option><?= $currenton ?></option>
                <?php $currenton--;
                } ?>
            </select>
        </div>
        <div class="col-md-1">
            <label>Сар</label>
            <select class="form form-control mb-3" id="lsar">
                <?php
                $month = 1;
                while ($month < 13) {
                    if ($month == $monthNumber) echo "<option selected>$month</option>";
                    else echo "<option>$month</option>";
                    $month++;
                } ?>
            </select>
        </div>
        <div class="col-md-2">
            <label></label>
            <button class="btn btn-warning w-100" onclick="check()" id="showBtn">Харах</button>
        </div>
    </div>
    <div id="main">

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
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function get_student() {
        $("#show").attr("disabled", true);
        let url = "/home/student-home";
        if ($('#turul').val() == 1) {
            url = "/home/time-home";
        }
        $.ajax({
            url: url,
            type: "POST",
            data: {
                date: $('#date_get').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#main").html("<div style='text-align: center;'>Алдаа гарлаа !</div>");
                $("#show").removeAttr("disabled");
            },
            beforeSend: function() {
                $('#main').html("<div class='loadText'><div class='loader'></div>Түр хүлээнэ үү ...</div>");
            },
            success: function(data) {
                $('#main').html(data);
                $("#show").removeAttr("disabled");
            },
            async: true
        });
    }

    function tenhim() {
        $.ajax({
            url: "ajax",
            type: "POST",
            data: {
                mode: 3,
                office_id: $("#alba").val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#tenhim').html("<option>Алдаа</option>");
                document.getElementById("showBtn").disabled = false;
            },
            beforeSend: function() {
                $('#tenhim').html("<option>Түр хүлээнэ үү</option>");
                document.getElementById("showBtn").disabled = true;
            },
            success: function(data) {
                document.getElementById("showBtn").disabled = false;
                $('#tenhim').html(data);
            },
            async: true
        });
    }

    function check() {
        $.ajax({
            url: "ajax",
            type: "POST",
            data: {
                mode: $("#turul").val(),
                lon: $("#lon").val(),
                lsar: $("#lsar").val(),
                office_id: $("#alba").val(),
                department_id: $("#tenhim").val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#main").html("<div style='text-align: center;'>Алдаа гарлаа !</div>");
            },
            beforeSend: function() {
                $('#main').html("<div style='text-align: center;'>Түр хүлээнэ үү ...</div>");
            },
            success: function(data) {
                $('#main').html(data);
            },
            async: true
        });
    }
</script>
<?php require ROOT . "/pages/footer.php";
require ROOT . "/pages/dataTablefooter.php"; ?>
<script>
    tenhim();
</script>
<?php require ROOT . "/pages/end.php"; ?>