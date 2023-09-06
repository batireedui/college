<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];

    $date = $_POST['date'];
    $class = $_POST['class'];
    $cag = $_POST['cag'];

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
            $id = "Таны сонгосон цагт \"$fname $lname\" багш ирц бүртгэсэн байна!";
        else {
            _selectRowNoParam(
                "SELECT att.id, class.name FROM att INNER JOIN class ON att.classid = class.id WHERE ognoo = '$date' and cagid = '$cag' and classid != '$class' and tid = '" . $_SESSION['user_id'] . "'",
                $aid, $cname
            );
            if (!empty($aid))
                $id = "Та энэ цаг дээр \"$cname\" ангид ирц бүртгэсэн байна!";
        }
        return $id;
    }

    if ($mode == 1) {
        $ircArr = array();
        $checkid = check($date, $class, $cag);
        if ($checkid == '0') {
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
            <div class="row mb-3">
                <div class="col-md">
                    <select class="form form-control mb-3" id="lesson">
                        <?php while (_fetch($lstmt)) : ?>
                            <option value="<?= $l_id ?>"><?= $l_name ?> (<?= $l_cag ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md">
                    <input type="text" value="" id="sedev" class="form form-control mb-3" placeholder="Хичээлийн сэдэв" />
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
                        $ircItem->val = 1;
                        array_push($ircArr, $ircItem);
                        $too++ ?>
                        <tr>
                            <td style="width: 3px;"><?= $too ?></td>
                            <td id="f1-<?= $id ?>"><span style="font-size: 12px;"><?= $fname ?></span> <?= $lname ?></td>
                            <td style="text-align: center;">
                                <div class="btn-group" role="group">
                                    <input type="radio" class="btn-check" id="v1-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 1)" value="1" checked="">
                                    <label class="btn btn-outline-primary" for="v1-<?= $id ?>">
                                        Ирсэн
                                    </label>
                                    <input type="radio" class="btn-check" id="v2-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 2)" value="2">
                                    <label class="btn btn-outline-primary" for="v2-<?= $id ?>">
                                        Өвчтэй
                                    </label>
                                    <input type="radio" class="btn-check" id="v3-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 3)" value="3">
                                    <label class="btn btn-outline-primary" for="v3-<?= $id ?>">
                                        Чөл
                                    </label>
                                    <input type="radio" class="btn-check" id="v4-<?= $id ?>" name="user-<?= $id ?>" onclick="changeVal(<?= $id ?>, 4)" value="4">
                                    <label class="btn btn-outline-primary" for="v4-<?= $id ?>">
                                        Тас
                                    </label>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
            <div class="mb-5">
                <button class="btn btn-success w-100" onclick="save_att()">ИРЦ ХАДГАЛ</button>
            </div>
            <script>
                ircArr = <?php echo json_encode($ircArr) ?>;

                function changeVal(id, val) {
                    ircArr.map((el) => {
                        if (el.id == id) {
                            el.val = val;
                        }
                    });
                    console.log(id + "-" + val)
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
                            ircpost: ircArr
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            $("#table").html("Алдаа гарлаа !");
                        },
                        beforeSend: function() {
                            $("#table").html("Түр хүлээнэ үү ...");
                        },
                        success: function(data) {
                            $("#table").html(data);
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
        $ircpost = json_encode($_POST['ircpost']);

        $success = _exec(
            "INSERT INTO att (classid, tid, lessonid, ognoo, cagid, irc, emoj, bich, sedev) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'iiisissss',
            [$class, $_SESSION['user_id'], $lesson, $date, $cag, $ircpost, null, ognoo(), ""],
            $count
        );

        echo "Амжилттай хадгалагдлаа!";
    } elseif ($mode == 3) {
        $id = $_POST['id'];
        $success = _exec(
            "DELETE FROM att WHERE id = ?",
            'i',
            [$id],
            $count
        );
    }
    ?>
<?php
}
?>