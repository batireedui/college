<?php
if (isset($_SESSION['user_id'])) {

    $thison = $_POST['year'] ?? $thison;
    $thismonth = $_POST['month'] ?? $thismonth;

    _selectNoParam(
        $st,
        $co,
        "SELECT at.id, at.name FROM `at_tax` INNER JOIN `at` ON at_tax.at_id = at.id WHERE at_tax.erh = 11", //11 гэсэн нь Б цаг тооцох эрх юм
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
        "SELECT btime_user.user_id, SUM(btime_user.credit), btime_ajil.at_id FROM btime_user INNER JOIN 
            btime_ajil ON btime_user.ajil_id = btime_ajil.id 
            WHERE btime_user.year = '$thison' and btime_user.month = '$thismonth' GROUP BY btime_user.user_id, btime_ajil.at_id",
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
        "SELECT teacher.id, teacher.fname, teacher.lname, tzereg.name, tzereg.bnorm, tzereg.money FROM `teacher` INNER JOIN 
        tzereg ON teacher.zereg = tzereg.id WHERE teacher.user_role='1' and teacher.tuluv = '1' ORDER BY lname",
        $t_id,
        $fname,
        $lname,
        $tzereg,
        $bnorm,
        $bmoney
    );
?>
    <div class="d-flex align-items-center justify-content-end">
        <table>
            <tr>
                <td></td>
                <td class="text-center">БАТЛАВ</td>
                <td></td>
            </tr>
            <tr>
                <td class="text-end">ЗАХИРАЛ</td>
                <td style="width: 130px;"></td>
                <td class="text-start text-uppercase">
                    <?php
                    _selectRowNoParam(
                        "SELECT concat(SUBSTRING(fname, 1, 1), '.', lname) as zahiral FROM `teacher` WHERE user_role='4' LIMIT 1",
                        $samanager
                    );
                    echo $samanager;
                    ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-center"> .... оны .... сарын .... өдөр</td>
            </tr>
        </table>
    </div>
    <div class="text-center fw-bold text-uppercase m-3">
        <?= $school_name ?>ийн <?= $thison ?> оны <?= $thismonth ?>-р сарын танхимын бус цагийн тооцоо
    </div>
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
                    <td><?= $fname ?> <span class="text-uppercase"><?= $lname ?></span></td>
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
                    <td><?php echo round($sumkr - $bnorm, 2); ?></td>
                    <td><?= formatMoney($bmoney) ?></td>
                    <td><?php $dun = round(($sumkr - $bnorm) * $bmoney, 2);
                        echo $dun > 0 ? formatMoney($dun) : "<span style='color: red'>-" . formatMoney($dun) . "</span>" ?></td>
                </tr>
            <?php $dd++;
            } ?>
        </tbody>
    </table>
    <div class="d-flex align-items-center justify-content-center">
        <table>
            <tr>
                <td class="text-end">Сургалтын албаны менежер:</td>
                <td style="width: 130px;"></td>
                <td class="text-start">
                    <?php
                    _selectRowNoParam(
                        "SELECT concat(SUBSTRING(fname, 1, 1), '.', lname) as zahiral FROM `teacher` WHERE user_role='3' LIMIT 1",
                        $samanager
                    );
                    echo $samanager;
                    ?>
                </td>
            </tr>
            <tr>
                <td class="text-end" style="vertical-align: top;">Арга зүйч-Багш:</td>
                <td style="width: 130px;"></td>
                <td class="text-start">
                    <?php
                    _selectNoParam(
                        $st,
                        $co,
                        "SELECT concat(SUBSTRING(fname, 1, 1), '.', lname) as zahiral FROM `teacher` WHERE user_role='2'",
                        $argaziuch
                    );
                    while (_fetch($st)) {
                        echo "$argaziuch<br>";
                    }
                    ?>
                </td>
            </tr>
        </table>
    </div>
<?php
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
