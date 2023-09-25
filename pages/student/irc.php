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

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Анги</th>
                    <?php
                    foreach ($cagArr as $el) {
                        echo "<th style='text-align: center'>$el->name <br> <span style='font-size: 10px'>$el->inter</span></th>";
                    }
                    ?>
                </tr>
            </thead>
            <?php
            $k = 0;
            while (_fetch($stmt)) : $k++ ?>
                <tr>
                    <td style='text-align: center'><?= $k ?></td>
                    <td><?= $ognoo ?>, <?= dayofweek($ognoo); ?></td>
                    <?php
                    foreach ($cagArr as $el) :
                        $echo = "";
                        $check = 0;
                        _selectRowNoParam(
                            "SELECT id, niit, v1 FROM att WHERE ognoo = '$ognoo' and classid = '$class' and cagid='$el->id'",
                            $check,
                            $niit,
                            $v1
                        );
                        if ($check > 0) {
                            $huvi = 0;
                            if ($v1 != 0 && $niit != 0)
                                $huvi = round($v1 / $niit * 100);
                            $echo = "<i class='fa-solid fa-circle-check text-success' data-mdb-toggle='modal' data-mdb-target='#detial' role='button' onclick='detial($check)'></i>";
                        }
                    ?>
                        <td style='text-align: center'>
                            <?= $echo ?>
                        </td>
                    <?php
                    endforeach
                    ?>
                </tr>
            <?php
            endwhile
            ?>
        </table>
<?php
    }
}
