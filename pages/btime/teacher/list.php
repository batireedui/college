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
    "SELECT btime_ajil.id, btime_ajil.ajil, btime_ajil.tailbar, btime_ajil.credit, btime_ajil.at_id, at.name FROM `btime_ajil` INNER JOIN `at` ON btime_ajil.at_id = at.id",
    $id,
    $ajil,
    $tailbar,
    $credit,
    $at_id,
    $at_name
);

_selectRowNoParam(
    "SELECT name, money, bnorm FROM `tzereg` INNER JOIN teacher ON tzereg.id = teacher.zereg WHERE teacher.id = '$user_id'",
    $zereg,
    $money,
    $bnorm
)
?>

<main id="main" class="main p-3">

    <div class="pagetitle">
        <h3>"Б цаг" тайлан бичих</h3>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Эхлэл</a></li>
                <li class="breadcrumb-item active">Б цаг / Нэмэх</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <?php include "head.php"; ?>
        <div class="row">
            <div class="col-md-2">
                <select class="form form-control mb-3" id="son">
                    <?php
                    $con = $thison;
                    while ($con >= $starton) { ?>
                        <option><?= $con ?></option>
                    <?php $con--;
                    } ?>
                </select>
            </div>
            <div class="col-md-1">
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
            <div class="col-md-1">
                <button class="btn btn-danger">ХАРАХ</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="row mb-3">
                            <table class="table table-bordered hover">
                                <tr>
                                    <th>№</th>
                                    <th></th>
                                    <th>Ажил үйлчилгээ</th>
                                    <th>Гүйцэтгэлийн шалгуур</th>
                                    <th>Кредит</th>
                                    <th>Тооцох</th>
                                </tr>
                                <?php
                                $dd = 1;
                                while (_fetch($st)) { ?>
                                    <tr>
                                        <td><?= $dd ?></td>
                                        <td><a href="addbtime?id=<?= $id ?>"><span class="btn btn-outline-danger">Сонгох</span></a></td>
                                        <td><?= $ajil ?></td>
                                        <td><?= $tailbar ?></td>
                                        <td><?= $credit ?></td>
                                        <td><?= $at_name ?></td>
                                    </tr>
                                <?php $dd++;
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