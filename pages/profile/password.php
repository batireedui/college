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
        <h3>Нууц үг солих</h3>
    </div>
    <div class="row mb-3">
        <div class="col-md-2">
            <div class="form-outline mb-4">
                <input type="password" id="old" class="form-control"  value="" required="">
                <label class="form-label" for="form2Example1" style="margin-left: 0px;">Нууц үг</label>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-outline mb-4">
                <input type="password" id="new" class="form-control"  value="" required="">
                <label class="form-label" for="form2Example1" style="margin-left: 0px;">Шинэ нууц үг</label>
            </div>
         </div>
        <div class="col-md-2">
            <div class="form-outline mb-4">
                <input type="password" id="newnew" class="form-control"  value="" required="">
                <label class="form-label" for="form2Example1" style="margin-left: 0px;">Шинэ нууц үгээ дахин оруул</label>
            </div>
         </div>
        <div class="col-md-2">
            <button class="btn btn-warning w-100" onclick="check()">СОЛИХ</button>
        </div>
    </div>
    <div id="table">

    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function check() 
    {
        $.ajax({
            url: "/profile/ajax",
                type: "POST",
                data: {
                    mode: 2,
                    old: $('#old').val(),
                    newp: $('#new').val(),
                    newpp: $('#newnew').val()
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
</script
<?php

require ROOT . "/pages/end.php";
?>