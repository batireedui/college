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
    "SELECT btime_user.id, btime_ajil.ajil, btime_user.tailbar, btime_ajil.credit, btime_ajil.at_id, at.name, btime_user.credit, btime_user.year, btime_user.month FROM `btime_ajil`
        INNER JOIN `at` ON btime_ajil.at_id = at.id
            INNER JOIN btime_user ON btime_ajil.id = btime_user.ajil_id WHERE btime_user.year = '$thison' and btime_user.month='$thismonth' and btime_user.user_id = '$user_id'",
    $id,
    $ajil,
    $tailbar,
    $credit,
    $at_id,
    $at_name,
    $tcredit,
    $year,
    $month
);

?>

<main id="main" class="main p-3">
    <section class="section">
        <?php include "head.php"; ?>
        <div class="pagetitle">
            <h3>"Б цаг" тайлан</h3>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <div class="m-3" style="text-align: right;">
                            <a class="btn btn-primary" href="/btime/teacher/add">"Б" цаг тооцуулах ажил үйлчилгээ</a>
                            <a class="btn btn-warning" href="/btime/teacher/current_print" target="_blank">Хэвлэх</a>
                        </div>
                        <div class="row m-3">
                            <table class="table table-bordered table-hover w-100">
                                <tr>
                                    <th>№</th>
                                    <th></th>
                                    <th></th>
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
                                        <td>
                                            <a href="edittime?id=<?= $id ?>"><span class="btn btn-outline-primary"><i class="fas fa-edit"></i></span></a>
                                        </td>
                                        <td>
                                            <?php if ($tcredit > 0) {
                                                echo '<span class="btn btn-outline-danger" role="button" onclick="alert(\'Кредит тооцсон тул устгах боломжгүй!\')"><i class="fas fa-trash"></i></span>';
                                            } else { ?>
                                                <a href="ajax?deleteid=<?= $id ?>" onclick="return confirm('Устгахдаа итгэлтэй байна уу?')"><span class="btn btn-outline-danger"><i class="fas fa-trash"></i></span></a>
                                            <?php   } ?>

                                        </td>
                                        <td><?= $ajil ?></td>
                                        <td><?= $tailbar ?></td>
                                        <td><?= $credit ?></td>
                                        <td><?= $tcredit ?></td>
                                        <td><?= $year ?></td>
                                        <td><?= $month ?></td>
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