<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'] ?? 0;
    if ($mode == "gettime") {
        $yearf = $_POST['year'] ?? $thison;
        $monthf = $_POST['month'] ?? $thismonth;
        $user_id = $_POST['id'] ?? 0;
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
        <div id="sumcredit"></div>
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
                            <div class="editcell" onblur="bodBtime(this, <?= $id ?>, <?= $user_id ?>)" style="min-width: 40px;" contenteditable=""><?= $tcredit ?></div>
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
        </table>
        <script>
            $('#sumcredit').html(<?= $sumcredit ?>);
        </script>
<?php }
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
