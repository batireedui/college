<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
$user_id = $_GET['id'] ?? 0;
_selectRowNoParam(
    "SELECT tzereg.name, tzereg.money, tzereg.bnorm, teacher.fname, teacher.lname, teacher.at FROM `tzereg` INNER JOIN teacher ON tzereg.id = teacher.zereg WHERE teacher.id = '$user_id'",
    $zereg,
    $money,
    $bnorm,
    $fname,
    $lname,
    $at
);
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
    <div class="d-flex justify-content-center align-items-center">
        <div style="margin: 0px 30px;">
            <img src="/images/logo.jpg" height="55" />
        </div>
        <div class="text-center">
            <div class="text-uppercase"><?= $school_name ?></div>
            <div class="text-uppercase fw-bolder"><?php echo "$thison оны $thismonth сарын танхимын бус цагаар хийсэн ажлын тайлан" ?></div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="fw-bold"><?= $fname ?> <span class="text-uppercase"><?= $lname ?></span></div>
            <div class=""><?= $at?></div>
        </div>
        <div class="col">
            <div class="text-end">Зэрэг: <span class="text-uppercase fw-bold"><?= $zereg ?></span></div>
            <div class="text-end">Тухайн сарын норм: <span class="text-uppercase fw-bold"><?= $bnorm ?></span></div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
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
                $sumcr = 0;
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
                <?php $dd++; $sumcr += $tcredit;
                }
                ?>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="4" class="fw-bold">НИЙТ: <?= $sumcr ?>, ИЛҮҮ КР: <?php echo $sumcr - $bnorm ?> </th>
                </tr>
            </table>
            <div class="d-flex align-items-center justify-content-center">
                <table>
                    <tr>
                        <td class="text-end">Захирал:</td>
                        <td style="width: 130px;"></td>
                        <td class="text-start">
                            <?php
                            _selectRowNoParam(
                                "SELECT concat(SUBSTRING(fname, 1, 1), '.', lname) as zahiral FROM `teacher` WHERE user_role='4' LIMIT 1",
                                $zahiral
                            );
                            echo $zahiral;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end">Ахлах нягтлан бодогч:</td>
                        <td style="width: 130px;"></td>
                        <td class="text-start">
                            <?php
                            _selectRowNoParam(
                                "SELECT concat(SUBSTRING(fname, 1, 1), '.', lname) as zahiral FROM `teacher` WHERE user_role='12' LIMIT 1",
                                $zahiral
                            );
                            echo $zahiral;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end">Сургалтын албаны менежер:</td>
                        <td style="width: 130px;"></td>
                        <td class="text-start">
                            <?php
                            _selectRowNoParam(
                                "SELECT concat(SUBSTRING(fname, 1, 1), '.', lname) as zahiral FROM `teacher` WHERE user_role='3' LIMIT 1",
                                $zahiral
                            );
                            echo $zahiral;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-end"><?= $_SESSION['user_at'] ?>:</td>
                        <td style="width: 130px;"></td>
                        <td class="text-start">
                            <?= substr(trim($user_fname), 0, 2) ?>.<?= $user_lname ?>
                        </td>
                    </tr>

                    <tr>
                        <td class="text-end"><?= $at ?>:</td>
                        <td style="width: 130px;"></td>
                        <td class="text-start">
                            <?= substr(trim($fname), 0, 2) ?>.<?= $lname ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</main><!-- End #main -->

<?php
require ROOT . "/pages/footer.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>

</script>
<?php
require ROOT . "/pages/end.php";
?>