<?php
if (isset($_SESSION['user_id'])) {
    $class = @$_POST['class'];
    $son = @$_POST['son'];
    $ssar = @$_POST['ssar'];
    $lon = @$_POST['lon'];
    $lsar = @$_POST['lsar'];

    $last = date("Y-m-t", strtotime("$lon-$lsar-1"));
    $start = date("Y-m-d", strtotime("$son-$ssar-1"));

    $sql = "";
    if ($_SESSION['user_role'] < 3) {
        $sql = " att.classid = '$class' and ";
    }

    _selectNoParam(
        $lstmt,
        $lcount,
        "SELECT COUNT(id), YEAR(ognoo), MONTH(ognoo) FROM `att` WHERE $sql ognoo BETWEEN '$start' and '$last' GROUP BY MONTH(ognoo), YEAR(ognoo)",
        $cag,
        $YEAR,
        $MONTH
    );

    _selectNoParam(
        $sstmt,
        $scount,
        "SELECT id, fname, lname FROM `students` WHERE class = '$class' ORDER BY lname",
        $sid,
        $fname,
        $lname
    );

    $sarList = array();

    while (_fetch($lstmt)) {
        $item = new stdClass();
        $item->cag = $cag;
        $item->YEAR = $YEAR;
        $item->MONTH = $MONTH;

        array_push($sarList, $item);
    }



    $dd = 0;
?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2"></th>
                <th rowspan="2">Нэрс</th>
                <?php foreach ($sarList as $el) : ?>
                    <th style="text-align: center;" colspan="5"><?= $el->YEAR ?>.<?= $el->MONTH ?></th>
                <?php endforeach ?>
                <th style="text-align: center;" colspan="5">ДҮН</th>
            </tr>
            <tr>
                <?php foreach ($sarList as $el) : ?>
                    <th style="text-align: center;">Өвч</th>
                    <th style="text-align: center;">Чөл</th>
                    <th style="text-align: center;">Тас</th>
                    <th style="text-align: center;">Нийт</th>
                    <th style="text-align: center;">Хувь</th>
                <?php endforeach ?>
                <th style="text-align: center;">Өвч</th>
                <th style="text-align: center;">Чөл</th>
                <th style="text-align: center;">Тас</th>
                <th style="text-align: center;">Нийт</th>
                <th style="text-align: center;">Хувь</th>
            </tr>
        </thead>
        <tbody>
            <?php while (_fetch($sstmt)) {
                $dd++;
                $sv1 = 0;
                $sv2 = 0;
                $sv3 = 0;
                $sv4 = 0;
                $dniit = 0;
                $dhuvi = 0;
                $dshuvi = 0;
            ?>
                <tr class="table_rows" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" id="trow-<?= $sid ?>" onclick="detial(<?= $sid ?>)">
                    <td><?= $dd ?></td>
                    <td><?= $fname ?> <?= $lname ?></td>
                    <?php foreach ($sarList as $el) :
                        $fognoo = date("Y-m-d", strtotime("$el->YEAR-$el->MONTH-1"));
                        $lognoo = date("Y-m-t", strtotime("$el->YEAR-$el->MONTH-1"));
                        _selectNoParam(
                            $lstmt,
                            $lcount,
                            "SELECT id, irc FROM `att` WHERE $sql ognoo BETWEEN '$fognoo' and '$lognoo'",
                            $att_id,
                            $irc
                        );
                        $v1 = 0;
                        $v2 = 0;
                        $v3 = 0;
                        $v4 = 0;
                        while (_fetch($lstmt)) {
                            $irc = json_decode($irc);
                            foreach ($irc as $key => $el) {
                                if ($el->id == $sid) {
                                    //echo $el->val . " $sid, ";
                                    if ($el->val == 1)
                                        $v1++;
                                    if ($el->val == 2)
                                        $v2++;
                                    if ($el->val == 3)
                                        $v3++;
                                    if ($el->val == 4)
                                        $v4++;
                                }
                            }
                        }
                        $sv1 += $v1;
                        $sv2 += $v2;
                        $sv3 += $v3;
                        $sv4 += $v4;

                        $niit = $v3 + $v4 + $v2;
                        $shuvi = $v3 + $v4 + $v2 + $v1;
                        if ($niit == 0)
                            $huvi = "100";
                        else $huvi = round(($shuvi - $niit) / $shuvi * 100);

                        $dniit += $niit;
                        $dshuvi += $shuvi;
                    ?>
                        <td style="text-align: center;"><?= $v2 * 2 ?></td>
                        <td style="text-align: center;"><?= $v3 * 2 ?></td>
                        <td style="text-align: center;"><?= $v4 * 2 ?></td>
                        <td class="fw-bold" style="text-align: center;"><?= $niit * 2 ?></td>
                        <td class="fw-bold" style="text-align: center;"><?= $huvi ?>% (<?= $shuvi * 2 ?>)</td>
                    <?php endforeach;

                    if ($dniit == 0)
                        $dhuvi = "100";
                    else $dhuvi = round(($dshuvi - $dniit) / $dshuvi * 100);
                    ?>
                    <td class="fw-bold" style="text-align: center;"><span class="alert alert-<?= $tuluvColor[2] ?>"><?= $sv2 * 2 ?></span></td>
                    <td class="fw-bold" style="text-align: center;"><span class="alert alert-<?= $tuluvColor[3] ?>"><?= $sv3 * 2 ?></span></td>
                    <td class="fw-bold" style="text-align: center;"><span class="alert alert-<?= $tuluvColor[4] ?>"><?= $sv4 * 2 ?></span></td>
                    <td class="fw-bold" style="text-align: center;"><span class="alert alert-<?= $tuluvColor[1] ?>"><?= $dniit * 2 ?></span></td>
                    <td class="fw-bold" style="text-align: center;"><?= $dhuvi ?>% (<?= $dshuvi * 2 ?>)</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="modal fade" id="detial" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detialLabel">ИРЦ БҮРТГЭЛ</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-body">

                </div>
            </div>
        </div>
    </div>
    <script>
        function detial(id) {
            row_click(id)
            $.ajax({
                url: "../att/detial",
                type: "POST",
                data: {
                    mode: 2,
                    id: id
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#modal-body").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $('#modal-body').html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $('#modal-body').html(data);
                },
                async: true
            });
        }
    </script>
<?php
}