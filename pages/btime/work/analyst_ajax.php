<?php
if (isset($_SESSION['user_id'])) {

    $year = $_POST['year'] ?? $thison;
    $toyear = $_POST['toyear'] ?? $thison;
    $mode = $_POST['mode'] ?? 0;
    if ($mode == "1") {
        _selectNoParam(
            $st,
            $co,
            "SELECT btime_ajil.id, btime_ajil.ajil, at.name FROM `btime_ajil` INNER JOIN `at` ON btime_ajil.at_id = at.id ORDER BY btime_ajil.ajil",
            $ajil_id,
            $ajil,
            $at
        );
?>
        <table class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Ажил үйлчилгээ</th>
                    <th>Он</th>
                    <th>Кредит</th>
                    <th>Кредит авсан багшийн тоо (Давхардсан тоо)</th>
                    <th>Мөнгөн дүн</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum = 0;
                $tsum = 0;
                $money = 0;
                $dd = 1;
                $col = $toyear - $year + 1;
                while (_fetch($st)) { ?>
                    <tr>
                        <?php
                        _selectNoParam(
                            $stc,
                            $coc,
                            "SELECT sum(btime_user.credit), count(btime_user.ajil_id), btime_user.year, sum(btime_user.dun) FROM `btime_user` INNER JOIN btime_ajil ON btime_user.ajil_id = btime_ajil.id
                            WHERE  btime_user.ajil_id = '$ajil_id' and btime_user.year >= '$year' and btime_user.year <= '$toyear' GROUP BY btime_user.ajil_id, btime_user.year
                            ORDER BY btime_user.year",
                            $credit,
                            $too,
                            $cyear,
                            $dun
                        );
                        $coc++;
                        ?>
                        <td rowspan="<?= $coc ?>"><?= $dd ?></td>
                        <td rowspan="<?= $coc ?>"><?= $ajil ?> (<?= $at ?>)</td>
                        <?php
                        $isum = 0;
                        $itsum = 0;
                        $imoney = 0;
                        $rowindex = 0;
                        if ($coc > 1) {
                            while (_fetch($stc)) {
                                if ($rowindex > 0) { ?>
                    <tr> <?php } ?>
                    <td><?= $cyear ?></td>
                    <td><?= $credit ?></td>
                    <td><?= $too ?> багш</td>
                    <td><?= formatMoney($dun) ?></td>
                    </tr>
                <?php $rowindex++;
                                $isum += $credit;
                                $itsum += $too;
                                $imoney += $dun;
                            } ?>
                <tr class="text-center fw-bold" style="color: red;">
                    <td>НИЙТ</td>
                    <td><?= $isum ?></td>
                    <td><?= $itsum ?></td>
                    <td><?= formatMoney($imoney) ?></td>
                </tr>
            <?php    } else { ?>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                </tr>
        <?php }
                        $dd++;
                        $sum += $isum;
                        $tsum += $itsum;
                        $money += $imoney;
                    } ?>
        <tr class="text-center fw-bold">
            <td colspan="3">НИЙТ</td>
            <td><?= $sum ?> Кредит</td>
            <td><?= $tsum ?> (Багш давхардсан тоогоор)</td>
            <td><?= formatMoney($money) ?></td>
        </tr>
            </tbody>
        </table>
    <?php
    } else if ($mode == "2" || $mode == "3") {
        $wsql = "ORDER BY kr DESC";
        if ($mode == "3") $wsql = "ORDER BY too DESC";
        _selectNoParam(
            $stc,
            $coc,
            "SELECT btime_ajil.id, btime_ajil.ajil, sum(btime_user.credit) as kr, count(btime_user.ajil_id) as too, btime_user.year, sum(btime_user.dun) FROM `btime_user` INNER JOIN btime_ajil ON btime_user.ajil_id = btime_ajil.id
            WHERE  btime_user.year >= '$year' and btime_user.year <= '$toyear' GROUP BY btime_user.ajil_id $wsql",
            $ajil_id,
            $ajil,
            $credit,
            $too,
            $cyear,
            $dun
        );
    ?>
        <table class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>№</th>
                    <th>Ажил үйлчилгээ</th>
                    <th>Кредит</th>
                    <th>Кредит авсан багшийн тоо (Давхардсан тоо)</th>
                    <th>Мөнгөн дүн</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum = 0;
                $tsum = 0;
                $money = 0;
                $dd = 1;
                while (_fetch($stc)) { ?>
                    <tr>
                        <td><?= $dd ?></td>
                        <td><?= $ajil ?></td>
                        <td><?= $credit ?></td>
                        <td><?= $too ?> багш</td>
                        <td><?= formatMoney($dun) ?></td>
                    </tr>
                <?php
                    $dd++;
                    $sum += $credit;
                    $tsum += $too;
                    $money += $dun;
                } ?>
                <tr class="text-center fw-bold">
                    <td colspan="2">НИЙТ</td>
                    <td><?= $sum ?> Кредит</td>
                    <td><?= $tsum ?></td>
                    <td><?= formatMoney($money) ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
<?php
    }
} else echo "Холболт салсан байна. Дахин нэвтэрч орно уу!";
