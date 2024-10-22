<?php
if (isset($_SESSION['user_id'])) {

    _selectNoParam(
        $st,
        $co,
        "SELECT at.id, at.name FROM `at_tax` INNER JOIN `at` ON at_tax.at_id = at.id WHERE at_tax.erh = 11",
        $at_id,
        $at_name
    );
    $at_array = array();

    while (_fetch($st)) {
        $item = new stdClass();
        $item->id = $at_id;
        $item->name = $at_name;
        array_push($at_array, $item);
    }

    _selectNoParam(
        $st,
        $co,
        "SELECT btime_user.user_id, SUM(btime_user.credit), btime_ajil.at_id FROM btime_user INNER JOIN btime_ajil ON btime_user.ajil_id = btime_ajil.id WHERE btime_user.year = '$thison' and btime_user.month = '$thismonth' GROUP BY btime_ajil.at_id",
        $user_id,
        $credit,
        $a_id
    );
    $btime_array = array();

    while (_fetch($st)) {
        $item = new stdClass();
        $item->user_id = $user_id;
        $item->credit = $credit;
        $item->at_id = $a_id;
        array_push($btime_array, $item);
    }

    _selectNoParam(
        $st,
        $co,
        "SELECT teacher.id, teacher.fname, teacher.lname, tzereg.name, tzereg.bnorm, tzereg.money FROM `teacher` INNER JOIN tzereg ON teacher.zereg = tzereg.id WHERE teacher.user_role='1' and teacher.tuluv = '1' ORDER BY lname",
        $t_id,
        $fname,
        $lname,
        $tzereg,
        $bnorm,
        $bmoney
    );
?>
    <table class="table table-bordered table-hover w-100">
        <thead>
            <tr>
                <th>№</th>
                <th>Нэрс</th>
                <th>Зэрэг</th>
                <?php
                foreach ($at_array as $el) {
                    echo "<th class='rotate' style='width: 50px'>$el->name</th>";
                }
                ?>
                <th>Нийт</th>
                <th>Норм</th>
                <th>Илүү</th>
                <th>Кредит үнэлгээ</th>
                <th>Дүн</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $dd = 1;
            while (_fetch($st)) { ?>
                <tr>
                    <td><?= $dd ?></td>
                    <td><?= $fname ?> <?= $lname ?></td>
                    <td><?= $tzereg ?></td>
                    <?php
                    $sumkr = 0;
                    foreach ($at_array as $el) {
                        $echo = "<td>0</td>";
                        foreach ($btime_array as $bi => $bt) {
                            if ($t_id == $bt->user_id && $bt->at_id == $el->id) {
                                $echo = "<td>$bt->credit</td>";
                                $sumkr += $bt->credit;
                                unset($btime_array[$bi]);
                                break;
                            }
                        }
                        echo $echo;
                    }
                    ?>
                    <td><?= $sumkr ?></td>
                    <td><?= $bnorm ?></td>
                    <td><?php echo $sumkr - $bnorm; ?></td>
                    <td><?= formatMoney($bmoney) ?></td>
                    <td><?php $dun = ($sumkr - $bnorm) * $bmoney; echo $dun > 0 ? formatMoney($dun) : "-" . formatMoney($dun); ?></td>
                </tr>
            <?php $dd++;
            } ?>
        </tbody>
    </table>
<?php
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
