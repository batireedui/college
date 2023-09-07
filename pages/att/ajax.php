<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];

    $date = @$_POST['date'];
    $class = @$_POST['class'];
    $cag = @$_POST['cag'];

    function check($date, $class, $cag)
    {
        $id = '0';
        _selectRowNoParam(
            "SELECT att.id, fname, lname FROM att INNER JOIN teacher ON att.tid = teacher.id WHERE ognoo = '$date' and cagid = '$cag' and classid = '$class' and tid != '" . $_SESSION['user_id'] . "'",
            $cid,
            $fname,
            $lname
        );
        if (!empty($cid))
            $id = "<div  class='alert alert-success' role='alert'>Таны сонгосон цагт \"$fname $lname\" багш ирц бүртгэсэн байна!</div>";
        else {
            _selectRowNoParam(
                "SELECT att.id, class.name FROM att INNER JOIN class ON att.classid = class.id WHERE ognoo = '$date' and cagid = '$cag' and classid != '$class' and tid = '" . $_SESSION['user_id'] . "'",
                $aid,
                $cname
            );
            if (!empty($aid))
                $id = "<div  class='alert alert-success' role='alert'>Та энэ цаг дээр \"$cname\" ангид ирц бүртгэсэн байна!</div>";
        }
        return $id;
    }

    if ($mode == 1) {
        $ircArr = array();
        $checkid = check($date, $class, $cag);
        if ($checkid == '0') {
            $editIrc = false;
            $oldsedev = "";
            _selectRowNoParam(
                "SELECT att.id, irc, sedev FROM att WHERE ognoo = '$date' and cagid = '$cag' and classid = '$class' and tid = '" . $_SESSION['user_id'] . "'",
                $oldid,
                $oldirc,
                $oldsedev
            );
            if (!empty($oldid)) {
                $editIrc = true;
                $oldirc = json_decode($oldirc);
                echo "<div  class='alert alert-success' role='alert'>
                    Та өмнө нь ирц оруулсан байна! Мэдээллээ өөрчлөөд ИРЦ ХАДГАЛ дарна уу!
                </div>";
            }
            _selectNoParam(
                $lstmt,
                $lcount,
                "SELECT id, lessonName, cag FROM tlesson WHERE tid = '" . $_SESSION['user_id'] . "' and tuluv = 1",
                $l_id,
                $l_name,
                $l_cag
            );

            _select(
                $stmt,
                $count,
                "SELECT students.id, students.fname, students.lname  
                    FROM students WHERE students.tuluv=? and class = '$class'",
                "i",
                [1],
                $id,
                $fname,
                $lname,
            ); ?>
            <div class="row">
                <div class="col-md">
                    <select class="form form-control mb-3" id="lesson">
                        <?php while (_fetch($lstmt)) : ?>
                            <option value="<?= $l_id ?>"><?= $l_name ?> (<?= $l_cag ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md">
                    <input type="text" value="<?= $oldsedev ?>" id="sedev" class="form form-control mb-3" placeholder="Хичээлийн сэдэв" />
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary w-100" onclick="cancel()">ЦУЦЛАХ</button>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md" id="info">

                </div>
            </div>
            <table class="table table-bordered" id="datalist">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>Нэр</th>
                        <th></th>
                    </tr>
                </thead>
                <?php if ($count > 0) : ?>
                    <?php $too = 0;
                    while (_fetch($stmt)) :
                        $ircItem = new stdClass();
                        $ircItem->id = $id;

                        if ($editIrc) {
                            foreach ($oldirc as $key => $el) {
                                if ($el->id == $id) {
                                    $ircItem->val = $el->val;
                                    break;
                                }
                                $ircItem->val = 1;
                            }
                        } else {
                            $ircItem->val = 1;
                        }
                        array_push($ircArr, $ircItem);
                        $too++ ?>
                        <tr>
                            <td style="width: 3px;"><?= $too ?></td>
                            <td id="f1-<?= $id ?>"><span style="font-size: 12px;"><?= $fname ?></span> <?= $lname ?></td>
                            <td style="text-align: center;">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" id="v1-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 1)" value="1" <?php
                                                                                                                                                                    if ($editIrc) {
                                                                                                                                                                        foreach ($oldirc as $key => $el) {
                                                                                                                                                                            if ($el->id == $id && $el->val == 1)
                                                                                                                                                                                echo 'checked=""';
                                                                                                                                                                        }
                                                                                                                                                                    } else echo 'checked=""';
                                                                                                                                                                    ?>>
                                    <label class="btn btn-outline-primary" for="v1-<?= $id ?>">
                                        Ирсэн
                                    </label>
                                    <input type="radio" class="btn-check" id="v3-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 3)" value="3" <?php
                                                                                                                                                                    if ($editIrc) {
                                                                                                                                                                        foreach ($oldirc as $key => $el) {
                                                                                                                                                                            if ($el->id == $id && $el->val == 3)
                                                                                                                                                                                echo 'checked=""';
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                    ?>>
                                    <label class="btn btn-outline-primary" for="v3-<?= $id ?>">
                                        Чөл
                                    </label>
                                    <input type="radio" class="btn-check" id="v4-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 4)" value="4" <?php
                                                                                                                                                                    if ($editIrc) {
                                                                                                                                                                        foreach ($oldirc as $key => $el) {
                                                                                                                                                                            if ($el->id == $id && $el->val == 4)
                                                                                                                                                                                echo 'checked=""';
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                    ?>>
                                    <label class="btn btn-outline-primary" for="v4-<?= $id ?>">
                                        Тас
                                    </label>
                                    <input type="radio" class="btn-check" id="v2-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 2)" value="2" <?php
                                                                                                                                                                    if ($editIrc) {
                                                                                                                                                                        foreach ($oldirc as $key => $el) {
                                                                                                                                                                            if ($el->id == $id && $el->val == 2)
                                                                                                                                                                                echo 'checked=""';
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                    ?>>
                                    <label class="btn btn-outline-primary" for="v2-<?= $id ?>">
                                        Өвчтэй
                                    </label>

                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
            <div class="mb-5">
                <button class="btn btn-success w-100" onclick="<?php echo $editIrc ? "save_change_att($oldid)" : "save_att()" ?>">ИРЦ ХАДГАЛ</button>
            </div>
            <script>
                $('#class').prop('disabled', true);
                $('#cag').prop('disabled', true);
                $('#date').prop('disabled', true);

                function cancel() {
                    $('#class').prop('disabled', false);
                    $('#cag').prop('disabled', false);
                    $('#date').prop('disabled', false);
                    $("#table").html("");
                }

                ircArr = <?php echo json_encode($ircArr) ?>;
                niit = 0;
                v1 = 0;
                v2 = 0;
                v3 = 0;
                v4 = 0;

                function tool() {
                    niit = 0;
                    v1 = 0;
                    v2 = 0;
                    v3 = 0;
                    v4 = 0;
                    ircArr.map((el) => {
                        niit++;
                        if (el.val == 1) v1++;
                        else if (el.val == 2) v2++;
                        else if (el.val == 3) v3++;
                        else if (el.val == 4) v4++;
                    });
                    too = '<span class="badge badge-primary m-1">Нийт: ' + niit + '</span><span class="badge badge-success m-1">Ирсэн: ' + v1 + '</span><span class="badge badge-info m-1">Чөлөөтэй: ' + v3 + '</span><span class="badge badge-danger m-1">Тасалсан: ' + v4 + '</span><span class="badge badge-warning m-1">Өвчтэй: ' + v2 + '</span>';
                    $("#info").html(too);
                    console.log(niit + " v1-" + v1 + " v2-" + v2 + " v3-" + v3 + " v4-" + v4);
                }
                tool();

                function changeVal(id, val) {
                    ircArr.map((el) => {
                        if (el.id == id) {
                            el.val = val;
                        }
                    });
                    console.log(id + "-" + val)
                    tool();
                }

                function save_att() {
                    console.log(ircArr)
                    $.ajax({
                        url: "ajax",
                        type: "POST",
                        data: {
                            mode: 2,
                            date: $('#date').val(),
                            class: $('#class').val(),
                            cag: $('#cag').val(),
                            lesson: $('#lesson').val(),
                            sedev: $('#sedev').val(),
                            ircpost: ircArr,
                            niit: niit,
                            v1: v1,
                            v2: v2,
                            v3: v3,
                            v4: v4
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            $("#table").html("Алдаа гарлаа !");
                        },
                        beforeSend: function() {
                            $("#table").html("Түр хүлээнэ үү ...");
                        },
                        success: function(data) {
                            $("#table").html(data);
                            $('#class').prop('disabled', false);
                            $('#cag').prop('disabled', false);
                            $('#date').prop('disabled', false);
                        },
                        async: true
                    });
                }

                function save_change_att(attid) {
                    console.log(ircArr)
                    $.ajax({
                        url: "ajax",
                        type: "POST",
                        data: {
                            mode: 3,
                            attid: attid,
                            lesson: $('#lesson').val(),
                            sedev: $('#sedev').val(),
                            ircpost: ircArr,
                            niit: niit,
                            v1: v1,
                            v2: v2,
                            v3: v3,
                            v4: v4
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            $("#table").html("Алдаа гарлаа !");
                        },
                        beforeSend: function() {
                            $("#table").html("Түр хүлээнэ үү ...");
                        },
                        success: function(data) {
                            $("#table").html(data);
                            $('#class').prop('disabled', false);
                            $('#cag').prop('disabled', false);
                            $('#date').prop('disabled', false);
                        },
                        async: true
                    });
                }
            </script>
    <?php
        } else {
            echo $checkid;
        }
    } elseif ($mode == 2) {
        $lesson = $_POST['lesson'];
        $sedev = $_POST['sedev'];
        $niit = $_POST['niit'];
        $v1 = $_POST['v1'];
        $v2 = $_POST['v2'];
        $v3 = $_POST['v3'];
        $v4 = $_POST['v4'];
        $ircpost = json_encode($_POST['ircpost']);

        $success = _exec(
            "INSERT INTO att (classid, tid, lessonid, ognoo, cagid, irc, emoj, bich, sedev, niit, v1, v2, v3, v4) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'iiisissssiiiii',
            [$class, $_SESSION['user_id'], $lesson, $date, $cag, $ircpost, null, ognoo(), $sedev, $niit, $v1, $v2, $v3, $v4],
            $count
        );

        echo "<div  class='alert alert-success' role='alert'>Амжилттай хадгалагдлаа!</div>";
    } elseif ($mode == 3) {
        $attid = $_POST['attid'];
        $lesson = $_POST['lesson'];
        $sedev = $_POST['sedev'];
        $niit = $_POST['niit'];
        $v1 = $_POST['v1'];
        $v2 = $_POST['v2'];
        $v3 = $_POST['v3'];
        $v4 = $_POST['v4'];
        $ircpost = json_encode($_POST['ircpost']);

        $success = _exec(
            "UPDATE att SET lessonid=?, sedev=?, irc=?, niit=?, v1=?, v2=?, v3=?, v4=? WHERE id = ?",
            'issiiiiii',
            [$lesson, $sedev, $ircpost, $niit, $v1, $v2, $v3, $v4, $attid],
            $count
        );
        echo "<div  class='alert alert-success' role='alert'>Амжилттай хадгалагдлаа!</div>";
    }
    ?>
<?php
}
?>