<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
require ROOT . "/pages/header.php";

_selectNoParam(
    $st,
    $co,
    "SELECT btime_ajil.id, btime_ajil.ajil, at.name FROM `btime_ajil` 
    INNER JOIN `at` ON btime_ajil.at_id = at.id ORDER BY btime_ajil.ajil",
    $ajil_id,
    $ajil,
    $at
);
?>

<main id="main" class="main p-3">
    <section class="section">
        <div class="row">
            <div class="col">
                <h3>Анализ</h3>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <select class="form form-control mb-3" id="ajil_id">
                    <?php
                    while (_fetch($st)) { ?>
                        <option value="<?= $ajil_id ?>"><?= $ajil ?></option>
                    <?php $currenton--;
                    } ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form form-control mb-3" id="year">
                    <?php
                    $currenton = $thison;
                    while ($currenton >= 2020) { ?>
                        <option <?php echo $currenton == 2020 ? "selected" : "" ?>><?= $currenton ?></option>
                    <?php $currenton--;
                    } ?>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form form-control mb-3" id="toyear">
                    <?php
                    $currenton = $thison;
                    while ($currenton >= 2020) { ?>
                        <option <?php echo $currenton == $thison ? "selected" : "" ?>><?= $currenton ?></option>
                    <?php $currenton--;
                    } ?>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-danger w-100" onclick="getreport()">ХАРАХ</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100" onclick="printdiv('data')">ХЭВЛЭХ</button>
            </div>
            <div class="col-md-1">
                <button class="btn btn-success w-100" onclick="print()">EXCEL</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12" id="data">

            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require ROOT . "/pages/footer.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    function printdiv(printdivname) {
        var h = document.head;
        var headstr = "<html><body>";
        var footstr = "</body>";
        var newstr = document.getElementById(printdivname).innerHTML;
        var oldstr = document.body.innerHTML;
        document.body.innerHTML = headstr + newstr + footstr;
        window.print();
        document.body.innerHTML = oldstr;
        return false;
    }

    function getreport() {
        $.ajax({
            url: "analyst_ajax",
            type: "POST",
            data: {
                mode: 1,
                year: $('#year').val(),
                toyear: $('#toyear').val(),
                ajil_id: $('#ajil_id').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#data').html("Алдаа гарлаа");
            },
            beforeSend: function() {
                $('#data').html("Түр хүлээнэ үү");
            },
            success: function(data) {
                $('#data').html(data);
            },
            async: true
        });
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>