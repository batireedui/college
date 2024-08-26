<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$tsas = 0;
_selectRowNoParam(
    "select cas, dans, dansner from setting",
    $tsas,
    $dans,
    $dansner
) ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Тохиргоо</p>
                        <div class="col-md-4">
                            <div class="form-check form-check-flat" style="margin-left: 50px;">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-control" id="tsas" name="tsas" <?php echo $tsas == "1" ? "checked" : "" ?> onchange="tsasChange(this.checked)">
                                    Цасан ширхэг харуулах
                                    <i class="input-helper"></i><i class="input-helper"></i>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-left: 50px; margin-top: 30px;">
                            <label>Дансны нэр</label>
                            <input type="text" id="dansner" class="form-control" value="<?= $dansner ?>" />
                        </div>
                        <div class="col-md-4" style="margin-left: 50px;">
                            <label>Банк, дансны дугаар</label>
                            <input type="text" id="dans" class="form-control" value="<?= $dans ?>" />
                        </div>
                        <div class="col-md-4" style="margin-left: 50px; margin-top: 10px;">
                            <button class="btn btn-primary" onclick="dansChange()">ХАДГАЛАХ</button>
                        </div>
                    </div>

                </div>
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">Нууц үг солих</p>
                        <div class="col-md-4" style="margin-left: 50px; margin-top: 30px;">
                            <label>Хуучин нууц үг</label>
                            <input type="password" id="oldpass" class="form-control" />
                        </div>
                        <div class="col-md-4" style="margin-left: 50px;">
                            <label>Шинэ нууц үг</label>
                            <input type="password" id="pass" class="form-control" />
                        </div>
                        <div class="col-md-4" style="margin-left: 50px;">
                            <label>Шинэ нууц үг давтах</label>
                            <input type="password" id="passagain" class="form-control" />
                        </div>
                        <div class="col-md-4" style="margin-left: 50px; margin-top: 10px;">
                            <button class="btn btn-primary" onclick="passChange()">ХАДГАЛАХ</button>
                        </div>
                    </div>

                </div>
            </div>

            <?php require ROOT . '/pages/admin/footer.php'; ?>
            <script>
                function passChange() {
                    let oldpass = $("#oldpass").val();
                    let pass = $("#pass").val();
                    let passagain = $("#passagain").val();
                    if (pass != "" && oldpass != "") {
                        if (pass === passagain) {
                            $.ajax({
                                url: "settings-val",
                                type: "POST",
                                data: {
                                    mode: "passchange",
                                    pass: pass,
                                    oldpass: oldpass
                                },
                                error: function(xhr, textStatus, errorThrown) {},
                                beforeSend: function() {},
                                success: function(data) {
                                    alert(data);
                                },
                                async: true
                            });} 
                        else {
                            alert("Давтаж оруулсан нууц үг тохирохгүй байна!");
                        }
                    } else {
                        alert("Хоосон утга байна!");
                    }
                }
                function dansChange() {
                    let dans = $("#dans").val();
                    let dansner = $("#dansner").val();
                    if (dansner != "" && dans != "") {
                        $.ajax({
                            url: "settings-val",
                            type: "POST",
                            data: {
                                mode: "dans",
                                dansner: dansner,
                                dans: dans
                            },
                            error: function(xhr, textStatus, errorThrown) {},
                            beforeSend: function() {},
                            success: function(data) {
                                alert(data);
                            },
                            async: true
                        });
                    } else {
                        alert("Хоосон утга байна!");
                    }
                }

                function tsasChange(val) {
                    console.log(val);
                    $.ajax({
                        url: "settings-val",
                        type: "POST",
                        data: {
                            mode: "tsas",
                            val: val

                        },
                        error: function(xhr, textStatus, errorThrown) {},
                        beforeSend: function() {},
                        success: function(data) {
                            console.log(data);
                        },
                        async: true
                    });
                }
            </script>
            <?php require ROOT . '/pages/admin/end.php'; ?>