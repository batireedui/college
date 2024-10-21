<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }

    .teachers {
        height: calc(100vh - 185px);
        overflow-y: auto;
    }
</style>
<div class="row">
    <div class="col-md-3 border border-success rounded p-3">
        <div class="row">
            <div class="col-md-7">
                <label>Он</label>
                <select class="form form-control mb-3" id="year" onchange="getteachers()">
                    <?php
                    $currenton = $thison;

                    while ($currenton >= $starton) { ?>
                        <option <?php echo $currenton == $thison ? "selected" : "" ?>><?= $currenton ?></option>
                    <?php $currenton--;
                    } ?>
                </select>
            </div>
            <div class="col-md-5">
                <label>Сар</label>
                <select class="form form-control mb-3" id="month" onchange="getteachers()">
                    <?php
                    $sar = 1;
                    while ($sar <= 12) { ?>
                        <option <?php echo $sar == $thismonth ? "selected" : "" ?>><?= $sar ?></option>
                    <?php $sar++;
                    } ?>
                </select>
            </div>
        </div>
        <div id="teachers" class="row teachers">

        </div>
    </div>
    <div class="col-md-9 border border-success rounded p-3">
        <div id="table">

        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function bodBtime(element, id, user_id) {
        var value = element.innerText;
        value = value.replaceAll(",", ".");
        value = value.replaceAll(" ", "");
        if (value == "") value = 0;
        console.log(id + value);
        $.ajax({
            url: 'ajax',
            type: 'post',
            data: {
                mode: "bodBtime",
                btimeid: id,
                credit: value
            },
            success: function(data) {
                get(user_id);
            }
        })
    }

    function getteachers() {
        $.ajax({
            url: "btimeteachers",
            type: "POST",
            data: {
                mode: "getteachers",
                year: $('#year').val(),
                month: $('#month').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#teachers').html("Алдаа гарлаа!");
            },
            beforeSend: function() {
                $('#teachers').html("Түр хүлээнэ үү!");
            },
            success: function(data) {
                $('#teachers').html(data);
                $('#table').html('');
            },
            async: true
        });
    }
    getteachers();

    function get(id) {
        row_click(id);
        $.ajax({
            url: "btimebod",
            type: "POST",
            data: {
                mode: "gettime",
                id: id,
                year: $('#year').val(),
                month: $('#month').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#table').html("Алдаа гарлаа!");
            },
            beforeSend: function() {
                $('#table').html("Түр хүлээнэ үү!");
            },
            success: function(data) {
                $('#table').html(data);
                $('#' + id + '-cr').html($('#sumcredit').html());
            },
            async: true
        });
    }


    function change(id, tuluv, vmode) {
        console.log(tuluv.checked);

        $.ajax({
            url: "ajax",
            type: "POST",
            data: {
                mode: vmode,
                id: id,
                tuluv: tuluv.checked
            },
            error: function(xhr, textStatus, errorThrown) {},
            beforeSend: function() {},
            success: function(data) {
                $('#toastbody').html(data);
                tshow();
            },
            async: true
        });
    }

    function editBtn(id, at_id) {
        $('#editajil').val($('#' + id + '-ajil').html());
        $('#editnotol').val($('#' + id + '-tailbar').html());
        $('#editcr').val($('#' + id + '-credit').html());
        $('#editat').val(at_id);
        $('#editid').val(id);
    }

    function tshow() {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
    }

    function deleteBtn(id) {
        let result = confirm("Та устгахдаа итгэлтэй байна уу?");
        if (result === true) {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: "btimeajilDelete",
                    id: id
                },
                error: function(xhr, textStatus, errorThrown) {},
                beforeSend: function() {},
                success: function(data) {
                    if (data == "Амжилттай") {
                        window.location.reload();
                    } else {
                        $('#toastbody').html(data);
                        tshow();
                    }
                },
                async: true
            });
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<?php
require ROOT . "/pages/end.php";
?>