<?php
if (isset($_SESSION['user_id'])) {
    $mode = @$_POST['mode'];
    if ($mode == 1) {
        $class = @$_POST['class'];
        $son = @$_POST['son'];
        $ssar = @$_POST['ssar'];
        $lon = @$_POST['lon'];
        $lsar = @$_POST['lsar'];

        $last = date("Y-m-t", strtotime("$lon-$lsar-1"));
        $start = date("Y-m-d", strtotime("$son-$ssar-1"));

        $sql = "";
        if ($_SESSION['user_role'] < 2) {
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

        _selectRowNoParam(
            "SELECT sname, name, fname, lname FROM class INNER JOIN teacher ON class.teacherid = teacher.id WHERE class.id='$class'",
            $sname,
            $class_name,
            $tfname,
            $tlname
        );

        $dd = 0;

?>
<h3 style='text-align: center;'>ИРЦИЙН НЭГТГЭЛ</h3>
<p style='text-align: center;'><?php echo "$sname $class_name"; ?></p>
<div style="display: flex;justify-content: space-between;">
    <?php if($son == $lon && $ssar == $lsar){ ?>
    <div>Хугацаа: <?=$lon?> оны <?=$lsar?>-р сар</div>
    <?php } else {?>
    <div>Хугацаа: <?=$son?> оны <?=$ssar?>-р сараас <?=$lon?> оны <?=$lsar?>-р сар</div>
    <?php } ?>
    <div>Хэвлэсэн: <?=date("Y.m.d H:i")?></div>
</div>
        <table class="table table-bordered table-hover">
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
                                if($irc != null) {
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
                            }
                            $sv1 += $v1;
                            $sv2 += $v2;
                            $sv3 += $v3;
                            $sv4 += $v4;

                            $niit = $v3 + $v4 + $v2;
                            $shuvi = $v3 + $v4 + $v2 + $v1;
                            if ($v4 == 0)
                                $huvi = "100";
                            else $huvi = round(($shuvi - $v4) / $shuvi * 100);

                            $dniit += $niit;
                            $dshuvi += $shuvi;
                        ?>
                            <td style="text-align: center;"><?= $v2 * 2 ?></td>
                            <td style="text-align: center;"><?= $v3 * 2 ?></td>
                            <td style="text-align: center;"><?= $v4 * 2 ?></td>
                            <td class="fw-bold" style="text-align: center;"><?= $niit * 2 ?></td>
                            <td class="fw-bold" style="text-align: center;"><?= $huvi ?>% (<?= $shuvi * 2 ?>)</td>
                        <?php endforeach;

                        if ($sv4 == 0)
                            $dhuvi = "100";
                        else $dhuvi = round(($dshuvi - $sv4) / $dshuvi * 100);
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
        <p style='text-align: center;'>Анги удирдсан багш .......................... <?php echo substr($tfname, 0, 2). ".$tlname"; ?></p>
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
                    url: "../att/student",
                    type: "POST",
                    data: {
                        mode: 1,
                        id: id,
                        son: $('#son').val(),
                        ssar: $('#ssar').val(),
                        lon: $('#lon').val(),
                        lsar: $('#lsar').val()
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
    } else if ($mode == 2) {
        $sdate = @$_POST['sdate'];
        $ldate = @$_POST['ldate'];

        _selectNoParam(
            $sstmt,
            $scount,
            "SELECT classid, lessonid, class.sname, class.name, lessonName FROM `att`
            INNER JOIN class ON att.classid = class.id  
            INNER JOIN tlesson ON att.lessonid = tlesson.id 
             WHERE att.tid = '" . $_SESSION['user_id'] . "' and att.ognoo BETWEEN '$sdate' and '$ldate' GROUP BY att.lessonid, att.classid",
            $classid,
            $lessonid,
            $sname,
            $class_name,
            $lessonName
        );
    ?>
<h5 style='text-align: center;'>ЦАГИЙН ТООЦОО</h5>
<p style='text-align: center; text-transform: uppercase;'><?php echo $school_name."ийн багш <br>" . $_SESSION['user_fname'] . " овогтой " . $_SESSION['user_lname']; ?></p>

<div style="display: flex;justify-content: space-between;">
    <div>Хугацаа: <?=$sdate?> өдрөөс <?=$ldate?>-н хүртэл</div>
    <div>Хэвлэсэн: <?=date("Y.m.d H:i")?></div>
</div>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px">№</th>
                    <th>Анги</th>
                    <th>Хичээл</th>
                    <th>Сэдэв</th>
                    <th style='text-align: center'>Огноо</th>
                    <th style='text-align: center'>Цаг</th>
                </tr>
            </thead>
            <?php
            $tmp_sum = 0;
            $dun = 0;
            while (_fetch($sstmt)) {
                _selectNoParam(
                    $istmt,
                    $icount,
                    "SELECT classid, att.lessonid, sedev, ognoo, att.id FROM `att`  
                        WHERE att.tid= '" . $_SESSION['user_id'] . "' and classid='$classid' and  lessonid='$lessonid' and ognoo BETWEEN '$sdate' and '$ldate' ORDER BY ognoo",
                    $classid,
                    $lessonid,
                    $sedev,
                    $ognoo,
                    $attid
                ); 
                if($tmp_sum > 0){
                    echo "<tr style='background-color: #aee1f1'>
                    <td colspan='5' class='fw-bold' style='text-align: center'>Нийт</td>
                    <td colspan='5' class='fw-bold' style='text-align: center'>$tmp_sum</td>
                    </tr>";
                    $tmp_sum = 0;
                }
                ?>
                <?php
                $dd = 0;
                while (_fetch($istmt)) {
                    $dd++;
                    $tmp_sum = $icount*2;
                ?>
                    <tr>
                        <td><?= $dd ?></td>
                        <?php
                        if ($dd == 1) {
                        ?>
                            <td rowspan="<?= $icount ?>" style="vertical-align: middle;"><?= $sname ?>-р анги<br><span style="font-size: 10px"><?=$class_name?></span></td>
                            <td rowspan="<?= $icount ?>" style="vertical-align: middle;"><?= $lessonName ?></td>
                        <?php
                        }
                        ?>
                        <td><div class='editcell' onblur='updateSedev(this, <?=$attid?>)' contenteditable=''><?= $sedev ?></div></td>
                        <td style='text-align: center' style='text-align: center'><?= str_replace("-", ".", $ognoo) ?></td>
                        <td style='text-align: center' style='text-align: center'>2</td>
                    </tr>

    <?php
                }
                $dun += $tmp_sum;
            }
            ?>
            <tr style='background-color: #aee1f1'>
                <td colspan='5' class='fw-bold' style='text-align: center'>Нийт</td>
                <td colspan='5' class='fw-bold' style='text-align: center'><?=$tmp_sum?></td>
            </tr>
            <tr style='background-color: #fff000'>
                <td colspan='5' class='fw-bold' style='text-align: center'>ДҮН</td>
                <td colspan='5' class='fw-bold' style='text-align: center'><?=$dun?></td>
            </tr>
            </table>"
            <p style='text-align: center;'>Цагийн тооцоо хийсэн .......................... <?php echo substr($_SESSION['user_fname'], 0, 2).".".$_SESSION['user_lname']; ?></p>
            <p style='text-align: center;'>Цагийн тооцоо тулсан .......................... /&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;/</p>
            <p style='text-align: center;'>Цагийн тооцоо хянасан ........................../&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;/</p>
     <?php   }
    }
