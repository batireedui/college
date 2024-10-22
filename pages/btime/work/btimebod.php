<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'] ?? 0;
    if ($mode == "gettime") {
        $yearf = $_POST['year'] ?? $thison;
        $monthf = $_POST['month'] ?? $thismonth;
        $user_id = $_POST['id'] ?? 0;
        _selectRowNoParam(
            "SELECT fname, lname, name, money, bnorm FROM `tzereg` INNER JOIN teacher ON tzereg.id = teacher.zereg WHERE teacher.id = '$user_id'",
            $fname,
            $lname,
            $zereg,
            $money,
            $bnorm
        );

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
        $sumcredit = 0; ?>
        <div>
            <div class="row">
                <div class="col m-3">
                    <?= $fname ?> <?= $lname ?> (<?= $zereg ?>)
                </div>
                <div class="col m-3 text-end">
                    <a class="btn btn-warning" href="/btime/work/teacher_print?id=<?= $user_id ?>" target="_blank">Хэвлэх</a>
                </div>
            </div>
        </div>
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
                    <td>
                        <?php if ($yearf == $thison && $monthf == $thismonth) { ?>
                            <div class="editcell" onblur="bodBtime(this, <?= $id ?>, <?= $user_id ?>, <?= $money ?>)" style="min-width: 40px;" contenteditable=""><?= $tcredit ?></div>
                        <?php } else echo $tcredit; ?>
                    </td>
                    <td><?= $year ?></td>
                    <td><?= $month ?></td>
                    <td><?= $at_name ?></td>
                </tr>
            <?php $dd++;
                $sumdun += $dun;
                $sumcredit += $tcredit;
            }
            ?>
            <tr>
                <td colspan="4" class="text-end fw-bold">
                    НИЙТ:
                </td>
                <td id="sumcredit" class="fw-bold">

                </td>
                <td colspan="3">

                </td>
            </tr>
        </table>
        <script>
            $('#sumcredit').html(<?= $sumcredit ?>);
        </script>
<?php }
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
