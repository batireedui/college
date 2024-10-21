<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
require ROOT . "/pages/header.php";

$yearf = $_GET['year'] ?? $thison;
$monthf = $_GET['month'] ?? $thismonth;
_selectNoParam(
    $st,
    $co,
    "SELECT btime_user.id, btime_ajil.ajil, btime_user.tailbar, btime_ajil.credit, btime_ajil.at_id, at.name, btime_user.credit, btime_user.year, btime_user.month, btime_user.dun FROM `btime_ajil`
        INNER JOIN `at` ON btime_ajil.at_id = at.id
            INNER JOIN btime_user ON btime_ajil.id = btime_user.ajil_id WHERE btime_user.year = '$yearf' and btime_user.month='$monthf' and btime_user.user_id='$user_id'",
    $id,
    $ajil,
    $tailbar,
    $credit,
    $at_id,
    $at_name,
    $tcredit,
    $year,
    $month,
    $dun
);
$sumdun = 0;
$sumcredit = 0;
?>

<main id="main" class="main p-3">
    <section class="section">
        <?php include "head.php"; ?>
        <form method="get">
            <div class="row">
                <div class="col">
                    <h3>"Б цаг" тайлангийн түүх</h3>
                </div>
                <div class="col-md-2">
                    <select class="form form-control mb-3" name="year">
                        <?php
                        $currenton = $thison;
                        while ($currenton >= $starton) { ?>
                            <option <?php echo $currenton == $yearf ? "selected" : "" ?>><?= $currenton ?></option>
                        <?php $currenton--;
                        } ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <select class="form form-control mb-3" name="month">
                        <?php
                        $sar = 1;
                        while ($sar <= 12) { ?>
                            <option <?php echo $sar == $monthf ? "selected" : "" ?>><?= $sar ?></option>
                        <?php $sar++;
                        } ?>
                    </select>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-danger">ХАРАХ</button>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="row m-3">
                            <table class="table table-bordered table-hover w-100">
                                <tr>
                                    <th>№</th>
                                    <th>Ажил үйлчилгээ</th>
                                    <th>Хийгдсэн байдал</th>
                                    <th>Тооцох КР</th>
                                    <th>КР</th>
                                    <th>Он</th>
                                    <th>Сар</th>
                                    <th>А/т</th>
                                </tr>
                                <?php
                                $dd = 1;
                                while (_fetch($st)) { ?>
                                    <tr>
                                        <td><?= $dd ?></td>
                                        <td><?= $ajil ?></td>
                                        <td><?= $tailbar ?></td>
                                        <td><?= $credit ?></td>
                                        <td><?= $tcredit ?></td>
                                        <td><?= $year ?></td>
                                        <td><?= $month ?></td>
                                        <td><?= $at_name ?></td>
                                    </tr>
                                <?php $dd++;
                                    $sumdun += $dun;
                                    $sumcredit += $tcredit;
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require ROOT . "/pages/footer.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    $('#sumKr').html('<?= $sumcredit ?>');
    $('#sumTug').html('<?= $sumdun ?>');

    function del(id, title, image) {
        var r = confirm(title + " мэдээг устгахдаа итгэлтэй байна уу!")
        if (r) {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 5,
                    id: id,
                    image: image
                },
                error: function(xhr, textStatus, errorThrown) {
                    //console.log("Алдаа гарлаа");
                },
                beforeSend: function() {
                    //console.log("Түр хүлээнэ үү");
                },
                success: function(data) {
                    window.location.reload();
                },
                async: true
            });
        }
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>