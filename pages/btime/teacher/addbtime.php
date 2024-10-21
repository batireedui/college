<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
require ROOT . "/pages/header.php";

$id = $_GET['id'] ?? 0;

_selectRowNoParam(
    "SELECT btime_ajil.id, btime_ajil.ajil, btime_ajil.tailbar, btime_ajil.credit, btime_ajil.at_id, at.name FROM `btime_ajil` INNER JOIN `at` ON btime_ajil.at_id = at.id WHERE btime_ajil.id='$id'",
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
    <section class="section">
        <?php include "head.php"; ?>
        <div class="pagetitle">
            <h3>"Б цаг" тайлан бичих</h3>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <style>
                            th {
                                color: #eb4034;
                                padding-top: 20px;
                            }

                            table {
                                font-size: large;
                            }
                        </style>
                        <div class="row mb-3">
                            <form action="ajax" method="post">
                                <table class="w-100 hover">
                                    <tr>
                                        <th colspan="2">Ажил үйлчилгээ</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?= $ajil ?></td>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Гүйцэтгэлийн шалгуур</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?= $tailbar ?></td>
                                    </tr>
                                    <tr>
                                        <th>Тооцох</th>
                                        <th>Кредит</th>
                                    </tr>
                                    <tr>
                                        <td><?= $at_name ?></td>
                                        <td><?= $credit ?></td>
                                    </tr>
                                    <tr>
                                        <th>Тайлан</th>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><textarea class="form form-control" name="tailbar"></textarea></td>
                                        <input type="text" name="id" class="d-none" value="<?= $id ?>" />
                                    </tr>
                                    <tr>
                                        <th>

                                        </th>
                                        <th style="text-align: right;">
                                            <button class="btn btn-primary" name="teacherAdd_btime">ХАДГАЛАХ</button>
                                        </th>
                                    </tr>
                                </table>
                            </form>
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