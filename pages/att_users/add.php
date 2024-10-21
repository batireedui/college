<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
if (checkErh(2, $_SESSION['user_role'], $_SESSION['user_id'])) {
    $date = date('Y-m-d');
    $monthNumber = date('m');
    _selectNoParam(
        $stmt,
        $count,
        "SELECT teacher.id, teacher.fname, teacher.lname, teacher.phone, teacher.email, teacher.at, teacher.pass, teacher.user_role, teacher.tuluv, teacher.office_id, teacher.department_id, at.name FROM teacher INNER JOIN at ON teacher.user_role = at.id WHERE teacher.tuluv = '1' ORDER BY lname",
        $id,
        $fname,
        $lname,
        $phone,
        $email,
        $at,
        $pass,
        $user_role,
        $tuluv,
        $office_id,
        $department_id,
        $user_type
    );

    _select(
        $ostmt,
        $ocount,
        "SELECT id, name FROM office WHERE tuluv=?",
        "i",
        [1],
        $oid,
        $oname
    );

    _select(
        $dstmt,
        $dcount,
        "SELECT id, name FROM department WHERE tuluv=?",
        "i",
        [1],
        $did,
        $dname
    );
    $oarray = array();
    $darray = array();
    while (_fetch($ostmt)) {
        $orow = new stdClass();
        $orow->oid = $oid;
        $orow->oname = $oname;
        array_push($oarray, $orow);
    }

    while (_fetch($dstmt)) {
        $orow = new stdClass();
        $orow->did = $did;
        $orow->dname = $dname;
        array_push($darray, $orow);
    }
?>
    <div>
        <div class="alert alert-info m-3">
            <?= $this_on ?> ХИЧЭЭЛИЙН ЖИЛ
        </div>
        <div class="row mb-3 p-3">
            <div class="col-md">
                <h3>ЦАГ БҮРТГЭХ</h3>
            </div>
        </div>
        <div id="main">
            <table class="table table-bordered table-hover" id="datalist">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Эцэг/эхийн нэр</th>
                        <th>Нэр</th>
                        <th>Утас</th>
                        <th>Албан тушаал</th>
                        <th>Алба</th>
                        <th>Хэлтэс</th>
                    </tr>
                </thead>
                <?php if ($count > 0) : ?>
                    <?php $too = 0;
                    while (_fetch($stmt)) :
                        $too++ ?>
                        <tr>
                            <td><?= $too ?></td>
                            <td class="text-center">
                                <?php if (file_exists(ROOT . "/www/images/users/$id-t.jpg")) { ?>
                                    <img src="/images/users/<?= $id ?>-t.jpg" id="imageList-<?= $id ?>" class="rounded-circle cover" height="30" loading="lazy" width="30">
                                <?php } else { ?>
                                    <img src="/images/user.jpg" id="imageList-<?= $id ?>" class="rounded-circle cover" height="30" loading="lazy" width="30">
                                <?php } ?>
                            </td>
                            <td role="button" class="text-center" data-mdb-toggle='modal' data-mdb-target='#addtime' onclick='add_userid(<?= $id ?>, "<?= $fname ?> <?= $lname ?>")'>
                                <i class="fab fa-algolia" style="font-size: 28px;color: #7a05cb;">
                            </td>
                            <td role="button" class="text-center" data-mdb-toggle='modal' data-mdb-target='#offtime' onclick='off_userid(<?= $id ?>, "<?= $fname ?> <?= $lname ?>")'>
                                <i class="fas fa-power-off" style="font-size: 28px;color: #0765ff;">
                            </td>
                            <td role="button" class="text-center" data-mdb-toggle='modal' data-mdb-target='#detial' onclick='set_userid(<?= $id ?>)'>
                                <i class="fas fa-calendar-days" style="font-size: 28px;color: #cb0505;"></i>
                            </td>
                            <td id="f1-<?= $id ?>"><?= $fname ?></td>
                            <td id="f2-<?= $id ?>"><?= $lname ?></td>
                            <td id="f3-<?= $id ?>"><?= $phone ?></td>
                            <td id="f5-<?= $id ?>"><?= $at ?> </small></td>
                            <td id="f8-<?= $id ?>"><?php
                                                    foreach ($oarray as $e) {
                                                        if ($e->oid == $office_id) {
                                                            echo $e->oname;
                                                        }
                                                    }
                                                    ?>
                            </td>
                            <td id="f9-<?= $id ?>">
                                <?php
                                foreach ($darray as $e) {
                                    if ($e->did == $department_id) {
                                        echo $e->dname;
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
    <div class="modal fade" id="detial" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detialLabel">ЦАГ БҮРТГЭЛИЙН ТҮҮХ</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type='text' class='d-none' id='getuserid' />
                    <div class='row'>
                        <div class="col">
                            <label>Он</label>
                            <select class="form form-control mb-3" id="lon">
                                <?php
                                $currenton = $thison;
                                while ($currenton >= $starton) { ?>
                                    <option><?= $currenton ?></option>
                                <?php $currenton--;
                                } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Сар</label>
                            <select class="form form-control mb-3" id="lsar">
                                <?php
                                $month = 1;
                                while ($month < 13) {
                                    if ($month == $monthNumber) echo "<option selected>$month</option>";
                                    else echo "<option>$month</option>";
                                    $month++;
                                } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label></label>
                            <button class="btn btn-warning w-100" onclick="getTime()" id="showBtn">Харах</button>
                        </div>
                    </div>
                    <div id="modal-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addtime" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detialLabel">ЦАГ БҮРТГЭХ</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <input type='text' class='d-none' id='adduserid' />
                    <div>
                        <h3 id="addusername"></h3>
                    </div>
                    <div class='row'>
                        <div class="col">
                            <label>Өдөр</label>
                            <?php $edate = date('Y-m-d'); ?>
                            <input type="date" class="form-control" value="<?= $edate ?>" name="hezee" id="addudur" />
                        </div>
                        <div class="col">
                            <label>Цаг</label>
                            <select class="form-control" id="addcag">
                                <?php
                                $c = 5;
                                while ($c < 24) {
                                    if ($c < 10)
                                        echo "<option>0$c</option>";
                                    else echo "<option>$c</option>";
                                    $c++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Минут</label>
                            <select class="form-control" id="addmin">
                                <?php
                                $c = 1;
                                while ($c < 61) {
                                    if ($c < 10)
                                        echo "<option>0$c</option>";
                                    else echo "<option>$c</option>";
                                    $c++;
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col">
                            <label></label>
                            <button class="btn btn-warning w-100" onclick="addtime()" id="showBtnadd">ЦАГ БҮРТГЭХ</button>
                        </div>
                        <div id="modal-info" class="m-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="offtime" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detialLabel">ЧӨЛӨӨ БҮРТГЭХ</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <input type='text' class='d-none' id='offuserid' />
                    <div>
                        <h3 id="offusername"></h3>
                    </div>
                    <div class='row'>
                        <div class="col">
                            <label>Чөлөө эхлэх өдөр</label>
                            <?php $edate = date('Y-m-d'); ?>
                            <input type="date" class="form-control" value="<?= $edate ?>" id="offstart" />
                        </div>
                        <div class="col">
                            <label>Чөлөө дуусах өдөр</label>
                            <?php $edate = date('Y-m-d'); ?>
                            <input type="date" class="form-control" value="<?= $edate ?>" id="offend" />
                        </div>
                        <div class="col">
                            <label></label>
                            <button class="btn btn-warning w-100" onclick="offtime()" id="showBtnoff">ЦАГ БҮРТГЭХ</button>
                        </div>
                        <div id="modal-off" class="m-3">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function add_userid(user_id, name) {
            $('#addusername').html(name);
            $('#modal-info').html('');
            $('#adduserid').val(user_id);
        }

        function off_userid(user_id, name) {
            $('#offusername').html(name);
            $('#modal-off').html('');
            $('#offuserid').val(user_id);
        }

        function set_userid(user_id) {
            $('#modal-body').html('');
            $('#getuserid').val(user_id);
        }

        function getTime() {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 'oneteacher',
                    user_id: $('#getuserid').val(),
                    lon: $("#lon").val(),
                    lsar: $("#lsar").val()
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('#modal-body').html("Алдаа");
                    document.getElementById("showBtn").disabled = false;
                },
                beforeSend: function() {
                    $('#modal-body').html("Түр хүлээнэ үү");
                    document.getElementById("showBtn").disabled = true;
                },
                success: function(data) {
                    document.getElementById("showBtn").disabled = false;
                    $('#modal-body').html(data);
                },
                async: true
            });
        }

        function addtime() {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 'addtime',
                    adduserid: $('#adduserid').val(),
                    addcag: $("#addcag").val(),
                    addudur: $("#addudur").val(),
                    addmin: $("#addmin").val()
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('#modal-info').html("Алдаа");
                    document.getElementById("showBtnadd").disabled = false;
                },
                beforeSend: function() {
                    $('#modal-info').html("Түр хүлээнэ үү");
                    document.getElementById("showBtnadd").disabled = true;
                },
                success: function(data) {
                    document.getElementById("showBtnadd").disabled = false;
                    $('#modal-info').html(data);
                },
                async: true
            });
        }

        function offtime() {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 'offtime',
                    offuserid: $('#offuserid').val(),
                    offstart: $("#offstart").val(),
                    offend: $("#offend").val()
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('#modal-off').html("Алдаа");
                    document.getElementById("showBtnoff").disabled = false;
                },
                beforeSend: function() {
                    $('#modal-off').html("Түр хүлээнэ үү");
                    document.getElementById("showBtnoff").disabled = true;
                },
                success: function(data) {
                    document.getElementById("showBtnoff").disabled = false;
                    $('#modal-off').html(data);
                },
                async: true
            });
        }
    </script>
<?php } else echo "Хандах эрх хүрэлцэхгүй байна"; ?>
<?php require ROOT . "/pages/footer.php"; ?>

<?php require ROOT . "/pages/end.php"; ?>