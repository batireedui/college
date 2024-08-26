<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];
    if ($mode == 4) {

        _selectNoParam(
            $cstmt,
            $ccount,
            "SELECT id, name, inter FROM cag",
            $id,
            $name,
            $inter
        );

        $cagArr = [];

        while (_fetch($cstmt)) {
            $item = new stdClass();
            $item->id = $id;
            $item->name = $name;
            $item->inter = $inter;
            array_push($cagArr, $item);
        }

        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];
        $class = $_POST['class'];

        _selectNoParam(
            $stmt,
            $count,
            "SELECT ognoo FROM att WHERE classid = '$class' and ognoo between '$sdate' and '$edate' GROUP BY ognoo ORDER BY ognoo, cagid",
            $ognoo
        );
?>
        <div class="row">
            <div class="col m-3 alert alert-success">Нийт хичээллэсэн өдөр: <?=$count?></div>
            <div class="col m-3 alert alert-primary" id="sumcag">Нийт хичээллэсэн өдөр: <?=$count?></div>
        </div>
        <table class="table table-bordered hovercell">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Огноо</th>
                    <?php
                    foreach ($cagArr as $el) {
                        echo "<th style='text-align: center'>$el->name <br> <span style='font-size: 10px'>$el->inter</span></th>";
                    }
                    ?>
                </tr>
            </thead>
            <?php
            $k = 0;
            $sumcag = 0;
            while (_fetch($stmt)) : $k++ ?>
                <tr>
                    <td style='text-align: center'><?= $k ?></td>
                    <td><?= $ognoo ?>, <?= dayofweek($ognoo); ?></td>
                    <?php
                    foreach ($cagArr as $el) :
                        $echo = "<td></td>";
                        $check = 0;
                        _selectRowNoParam(
                            "SELECT id, niit, v1 FROM att WHERE ognoo = '$ognoo' and classid = '$class' and cagid='$el->id'",
                            $check,
                            $niit,
                            $v1
                        );
                        if ($check > 0) {
                            $sumcag++;
                            $huvi = 0;
                            if ($v1 != 0 && $niit != 0)
                                $huvi = round($v1 / $niit * 100);
                            $echo = "<td style='text-align: center'  data-mdb-toggle='modal' data-mdb-target='#detial' role='button' onclick='detial($check)'><i class='fa-solid fa-circle-check text-success'></i> $huvi%</td>";
                        }
                    ?>
                    <?= $echo ?>
                    <?php
                    endforeach
                    ?>
                </tr>
            <?php
            endwhile
            ?>
        </table>
        <script>
            document.getElementById("sumcag").innerText="Нийт хичээллэсэн цаг: " + <?=$sumcag*2?>;
        </script>
<?php
    }
}
