<?php
if (isset($_SESSION['user_id'])) {

    $year = $_POST['year'] ?? $thison;
    $toyear = $_POST['toyear'] ?? $thison;
    $ajil_id = $_POST['ajil_id'] ?? 0;
    
    _selectNoParam(
        $st,
        $co,
        "SELECT btime_user.ajil_id, btime_ajil.ajil, sum(btime_user.credit), count(btime_user.ajil_id), btime_user.year FROM `btime_user` INNER JOIN btime_ajil ON btime_user.ajil_id = btime_ajil.id
            WHERE  btime_user.ajil_id = '$ajil_id' and btime_user.year >= '$year' and btime_user.year <= '$toyear' GROUP BY btime_user.ajil_id, btime_user.year
            ORDER BY btime_user.year",
        $ajil_id,
        $ajil,
        $credit,
        $too,
        $cyear
    );
?>
    <table class="table table-bordered table-hover w-100">
        <thead>
            <tr>
                <th>№</th>
                <th>Ажил үйлчилгээ</th>
                <th>Кредит</th>
                <th>Кредит авсан багшийн тоо (Давхардсан тоо)</th>
                <th>Он</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sum = 0;
            $tsum = 0;
            $dd = 1;
            while (_fetch($st)) { ?>
                <tr role="button">
                    <td><?= $dd ?></td>
                    <td><?= $ajil ?></td>
                    <td><?= $credit ?></td>
                    <td><?= $too ?> багш</td>
                    <td><?= $cyear ?></td>
                </tr>
            <?php $dd++; $sum += $credit; $tsum += $too ;
            } ?>
            <tr class="text-center fw-bold">
                <td colspan="2">НИЙТ</td>
                <td><?=$sum?> Кредит</td>
                <td><?=$tsum?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
<?php
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
