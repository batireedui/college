<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
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
<div class="d-none">
    <?php include "head.php"; ?>
</div>
<main id="main" class="main p-3">
    <div class="d-flex justify-content-center align-items-center m-3">
        <div class="text-center">
            <div class="text-uppercase"><?= $school_name ?></div>
            <div class="text-uppercase fw-bolder"><?php echo "$thison оны $thismonth сарын танхимын бус цагаар хийсэн ажлын тайлан" ?></div>
        </div>
    </div>
    <div class="row m-3">
        <div class="col-lg-12">
            <?php
            $dd = 1;
            while (_fetch($st)) { ?>
                <div class="d-flex">
                    <div class="m-1"><?= $dd ?>. </div>
                    <div class="m-1"><?= $tailbar ?></div>
                </div>
            <?php $dd++;
            } ?>
        </div>
    </div>
    <div class="d-flex align-items-center justify-content-center m-3">
        <table>
            <tr>
                <td class="text-end">Тайлан бичсэн: <?= $_SESSION['user_at'] ?>:</td>
                <td style="width: 130px;"></td>
                <td class="text-start">
                    <?= substr(trim($user_fname), 0, 2) ?>.<?= $user_lname ?>
                </td>
            </tr>
        </table>
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