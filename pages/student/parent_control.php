<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];
    if ($mode == 1) {
        $id = $_POST['id'];
        _selectNoParam(
            $pstmt,
            $pcount,
            "SELECT tax_pareant.id, fname, lname, phone FROM parent INNER JOIN tax_pareant ON parent.id = tax_pareant.parent_id  WHERE student_id = $id",
            $pid,
            $pfname,
            $plname,
            $pphone
        ); ?>
        <table class="table">
            <thead>
                <th>Хэн болох</th>
                <th>Нэр</th>
                <th>Утас</th>
                <th></th>
            </thead>
            <tbody>
                <?php
                while (_fetch($pstmt)) { ?>
                    <tr>
                        <td><?= $pfname ?></td>
                        <td><?= $plname ?></td>
                        <td><?= $pphone ?></td>
                        <td><span class="badge badge-danger" role="button" onclick="deleteParent(<?= $pid ?>)">Устгах</span></td>
                    </tr>
                <?php   } ?>
            </tbody>
        </table>
        <script>
            function deleteParent(pid) {
                if (pid > 0) {
                    $.ajax({
                        url: "parent_control",
                        type: "POST",
                        data: {
                            mode: 4,
                            pid: pid
                        },
                        error: function(xhr, textStatus, errorThrown) {

                        },
                        beforeSend: function() {

                        },
                        success: function(data) {
                            //$("#parentAdd").html(data);
                            getParent($('#add_parent').val());
                        },
                        async: true
                    });
                } else alert("Мэдээлэл гүйцэд оруулна уу!");
            }
        </script>
        <?php
    } else if ($mode == 2) {
        $phone = $_POST['phone'];
        _selectRowNoParam(
            "SELECT id, fname, lname FROM parent WHERE phone = $phone",
            $apid,
            $apfname,
            $aplname
        );
        if (!empty($apid)) { ?>
            <div style="padding: 25px;border-radius: 10px;border: 2px solid #c1c0c0;">
                <div class="row">
                    <div class="col">
                        Асран хамгаалагч нэмэх
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label class="form-label" for="add-fname">Хэн болох *</label>
                        <input type="text" class="form form-control" value="<?= $apfname ?>" autocomplete="FALSE" readonly />
                    </div>
                    <div class="col">
                        <label class="form-label" for="add-lname">Нэр*</label>
                        <input type="text" class="form form-control" value="<?= $aplname ?>" autocomplete="FALSE" readonly />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="text" class="form form-control" value="<?= $phone ?>" autocomplete="FALSE" readonly />
                    </div>
                    <div class="col">
                        <button class="btn btn-warning" onclick="saveParent(<?= $apid ?>)">НЭМЭХ</button>
                    </div>
                </div>
            </div>
            <script>
                function saveParent(eseh) {
                    let student_id = $('#add_parent').val();
                    if (student_id.length > 0) {
                        $.ajax({
                            url: "parent_control",
                            type: "POST",
                            data: {
                                mode: 3,
                                eseh: eseh,
                                student_id: student_id
                            },
                            error: function(xhr, textStatus, errorThrown) {

                            },
                            beforeSend: function() {

                            },
                            success: function(data) {
                                //$("#parentAdd").html(data);
                                getParent($('#add_parent').val());
                                $('#parentAdd').hide();
                            },
                            async: true
                        });
                    } else alert("Мэдээлэл гүйцэд оруулна уу!");
                }
            </script>
        <?php } else {
        ?>
            <div style="padding: 25px;border-radius: 10px;border: 2px solid #c1c0c0;">
                <div class="row">
                    <div class="col">
                        Асран хамгаалагч бүртгэх
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <label class="form-label" for="add-fname">Хэн болох*</label>
                        <input type="text" value="" id="add-fname" class="form form-control" placeholder="Аав" autocomplete="FALSE" />
                    </div>
                    <div class="col">
                        <label class="form-label" for="add-lname">Нэр*</label>
                        <input type="text" value="" id="add-lname" class="form form-control" autocomplete="FALSE" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <input type="text" id="add-utas" class="form form-control" value="<?= $phone ?>" autocomplete="FALSE" readonly />
                    </div>
                    <div class="col">
                        <button class="btn btn-warning" onclick="saveParent(0)">ХАДГАЛАХ</button>
                    </div>
                </div>
            </div>
            <script>
                function saveParent(eseh) {
                    let addfname = $('#add-fname').val();
                    let addlname = $('#add-lname').val();
                    let student_id = $('#add_parent').val();
                    console.log(student_id);

                    if (addfname.length > 0 && addlname.length > 0) {
                        $.ajax({
                            url: "parent_control",
                            type: "POST",
                            data: {
                                mode: 3,
                                eseh: eseh,
                                addfname: addfname,
                                addlname: addlname,
                                utas: $('#add-utas').val(),
                                student_id: student_id
                            },
                            error: function(xhr, textStatus, errorThrown) {
                                //$("#parentAdd").html("Алдаа гарлаа !");
                            },
                            beforeSend: function() {
                                //$("#parentAdd").html("Түр хүлээнэ үү ...");
                            },
                            success: function(data) {
                                //$("#parentAdd").html(data);
                                getParent($('#add_parent').val());
                                $('#parentAdd').hide();
                            },
                            async: true
                        });
                    } else alert("Мэдээлэл гүйцэд оруулна уу!");
                }
            </script>
<?php }
    } else if ($mode == 3) {
        $student_id = $_POST['student_id'];
        $eseh = $_POST['eseh'];

        if ($eseh == 0) {
            $addfname = $_POST['addfname'];
            $addlname = $_POST['addlname'];
            $utas = $_POST['utas'];
            $newpass = password_hash($utas, PASSWORD_BCRYPT, ["cost" => 8]);
            
            $success = _exec(
                "INSERT INTO parent (fname, lname, pass, phone) VALUES(?, ?, ?, ?)",
                'ssss',
                [$addfname, $addlname, $newpass, $utas],
                $lastid
            );

            if (!empty($lastid)) {
                $success = _exec(
                    "INSERT INTO tax_pareant (student_id, parent_id) VALUES(?, ?)",
                    'ii',
                    [$student_id, $lastid],
                    $lastid
                );
            }
        } else {
            $success = _exec(
                "INSERT INTO tax_pareant (student_id, parent_id) VALUES(?, ?)",
                'ii',
                [$student_id, $eseh],
                $lastid
            );
        }
    } else if ($mode == 4) {
        $pid = $_POST['pid'];

        if (!empty($pid)) {
            $success = _exec(
                "DELETE FROM tax_pareant WHERE id=?",
                'i',
                [$pid],
                $lastid
            );
        }
    }
}
