<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

$sdate = date('Y-m-01');
$edate = date('Y-m-d');

if ($_SESSION['user_role'] < 2) {
    _select(
        $tstmt,
        $tcount,
        "SELECT id, fname, lname FROM teacher WHERE id=? and tuluv=? and user_role=? ORDER BY lname",
        "iii",
        [$_SESSION['user_id'], 1, 1],
        $stid,
        $fname,
        $lname
    );
} else {
    _select(
        $tstmt,
        $tcount,
        "SELECT id, fname, lname FROM teacher WHERE tuluv=? and user_role=? ORDER BY lname",
        "ii",
        [1, 1],
        $stid,
        $fname,
        $lname
    );
}

?>

<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h3>ЖУРНАЛ</h3>
    </div>
    <div class="row mb-3">
        <div class="col-md">
            <select class="form form-control mb-3" id='tid' onchange="changeTeacher()">
                <?php
                while (_fetch($tstmt)) {
                    echo "<option value='$stid'>$fname $lname</option>";
                }
                ?>
            </select>
        </div>
        <div class="col-md">
            <select class="form form-control mb-3" id='classList' onchange="changeClass()">
                <?php

                ?>
            </select>
        </div>
        <div class="col-md">
            <select class="form form-control mb-3" id='lessonList'>

            </select>
        </div>
        <div class="col-md-2">
            <input type="date" class="form form-control mb-3" name="sdate" value="<?= $sdate ?>" autocompleted />
        </div>
        <div class="col-md-2">
            <input type="date" class="form form-control mb-3" name="ldate" value="<?= $edate ?>" autocompleted />
        </div>
        <div class="col-md-1">
            <button class="btn btn-warning w-100" onclick="jurnal()" id="showBtn">ХАРАХ</button>
        </div>
    </div>
    <div style="text-align: end" class="mb-3">
        <a href="#" onclick="exportToExcel('table')" role="button" class="btn btn-success" style="">Excel</a>
        <a href="#" onclick="print()" role="button" class="btn btn-primary" style="">Хэвлэх</a>
    </div>
    <div id="table">

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<?php require ROOT . "/pages/footer.php"; ?>
<script>
    function exportToExcel(tableId, name = "ИРЦ БҮРТГЭЛИЙН ПРОГРАМ") {
        let tableData = document.getElementById(tableId).outerHTML;
        tableData = tableData.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
        tableData = tableData.replace(/<input[^>]*>|<\/input>/gi, ""); //remove input params

        let a = document.createElement('a');
        a.href = `data:application/vnd.ms-excel, ${encodeURIComponent(tableData)}`
        a.download = $('#classList option:selected').text() + ', ЖУРНАЛ' + '.xls'
        a.click()
    }

    function print() {
        $('#table').printElement({});
    }

    var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
    triggerTabList.forEach(function(triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', function(event) {
            event.preventDefault()
            tabTrigger.show()
        })
    })

    function changeTeacher() {
        $.ajax({
            url: "j-lesson",
            type: "POST",
            data: {
                mode: 1,
                tid: $('#tid').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#classList').html("<option>Алдаа</option>");
                document.getElementById("showBtn").disabled = false;
            },
            beforeSend: function() {
                $('#classList').html("<option>Түр хүлээнэ үү</option>");
                document.getElementById("showBtn").disabled = true;
            },
            success: function(data) {
                $('#classList').html(data);
                console.log(data);
                changeClass();
            },
            async: true
        });
    };

    changeTeacher();

    function changeClass() {
        $.ajax({
            url: "j-lesson",
            type: "POST",
            data: {
                mode: 2,
                tid: $('#tid').val(),
                class: $('#classList').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#lessonList').html("<option>Алдаа</option>");
                document.getElementById("showBtn").disabled = false;
            },
            beforeSend: function() {
                $('#lessonList').html("<option>Түр хүлээнэ үү</option>");
                document.getElementById("showBtn").disabled = true;
            },
            success: function(data) {
                $('#lessonList').html(data);
                document.getElementById("showBtn").disabled = false;
            },
            async: true
        });
    };

    function jurnal() {
        $.ajax({
            url: "j-lesson",
            type: "POST",
            data: {
                mode: 3,
                tid: $('#tid').val(),
                class: $('#classList').val(),
                lesson: $('#lessonList').val(),
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#table').html("Алдаа");
            },
            beforeSend: function() {
                $('#table').html("Түр хүлээнэ үү");
            },
            success: function(data) {
                $('#table').html(data);
            },
            async: true
        });
    };
</script>
<?php
require ROOT . "/pages/end.php";
?>