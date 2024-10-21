<?php
if (isset($_SESSION['user_id'])) {
    $date = date('Y-m-d');
    if (isset($_POST['date'])) {
        $date = $_POST['date'];
    }

    _selectNoParam(
        $cstmt,
        $ccount,
        "SELECT id, name, inter FROM cag WHERE tuluv=1",
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

    _selectNoParam(
        $stmt,
        $count,
        "SELECT id, name, sname FROM class WHERE tuluv = 1 ORDER BY sname",
        $cid,
        $cname,
        $sname
    );

    $classArr = [];

    while (_fetch($stmt)) {
        $item = new stdClass();
        $item->cid = $cid;
        $item->cname = $cname;
        $item->sname = $sname;
        array_push($classArr, $item);
    }

    _selectNoParam(
        $attstmt,
        $attcount,
        "SELECT id, niit, v1, classid, cagid FROM att WHERE this_on = '$this_on' and ognoo = '$date'",
        $check,
        $niit,
        $v1,
        $classid,
        $cagid
    );
    $attArr = [];

    while (_fetch($attstmt)) {
        $item = new stdClass();
        $item->check = $check;
        $item->niit = $niit;
        $item->v1 = $v1;
        $item->classid = $classid;
        $item->cagid = $cagid;
        array_push($attArr, $item);
    }
?>
    <div id="table">
        <table class="table table-bordered hovercell">
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
            foreach ($classArr as $cel) : $k++ ?>
                <tr>
                    <td style='text-align: center'><?= $k ?></td>
                    <td><?= $cel->sname ?> <?= $cel->cname ?></td>
                    <?php
                    foreach ($cagArr as $el) :
                        $echo = "<td></td>";
                        $check = 0;
                        $niit = 0;
                        $v1 = 0;
                        foreach ($attArr as $attel) {
                            if ($cel->cid == $attel->classid && $el->id == $attel->cagid) {
                                $check = $attel->check;
                                $niit = $attel->niit;
                                $v1 = $attel->v1;
                                break;
                            }
                        }

                        if ($check > 0) {
                            $huvi = 0;
                            if ($v1 != 0 && $niit != 0)
                                $huvi = round($v1 / $niit * 100);
                            $echo = "<td style='text-align: center' data-mdb-toggle='modal' data-mdb-target='#detial' role='button' onclick='detial($check)'><i class='fa-solid fa-circle-check text-success'></i><small> $huvi%</small></td>";
                        }
                    ?>
                        <?= $echo ?>
                    <?php
                    endforeach
                    ?>
                </tr>
            <?php
            endforeach
            ?>
        </table>
    </div>
<?php
} else echo "Та дахин нэвтэрч орно уу! Холболт салсан байна"; ?>