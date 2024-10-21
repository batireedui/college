<?php require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$id = 0;
if (!isset($_GET['id'])) {
} else {
    $id = $_GET['id'];
    _selectRowNoParam(
        "SELECT id, buleg_id, name, ded, hariulttype, turul, tuluv FROM s_shalguurs WHERE id=$id",
        $id,
        $buleg_id,
        $name,
        $ded,
        $hariulttype,
        $turul,
        $tuluv
    );
    _selectNoParam(
        $bstmt,
        $bcount,
        "SELECT id, name FROM s_shalguurbuleg",
        $bid,
        $bname
    );
    //Олон сонголт
    _selectNoParam(
        $dstmt,
        $dcount,
        "SELECT id, name, shalguur_id, tuluv FROM s_shalguurdeds WHERE shalguur_id = $id and turul = '0'",
        $did,
        $dname,
        $dshalguur_id,
        $dtuluv
    );
    //Дэд олон сонголт
    _selectNoParam(
        $mstmt,
        $mcount,
        "SELECT id, name, shalguur_id, tuluv FROM s_shalguurdeds WHERE shalguur_id = $id and turul = '1'",
        $mid,
        $mname,
        $mshalguur_id,
        $mtuluv
    );
?>
            <!-- Basic Bootstrap Table -->
            <div class="card m-3" style="padding: 20px;">
                <form action="ajax/action" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Бүлэг</label>
                        <select class="form-select" name="buleg">
                            <?php
                            while (_fetch($bstmt)) {
                                echo "<option value='$bid'";
                                echo $bid == $buleg_id ? "selected" : null;
                                echo ">$bname</option>";
                            };
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Шалгуур үзүүлэлтийн нэр</label>
                        <input type="text" class="form-control" name="shner" value="<?= $name ?>" />
                        <input type="text" name="id" style="display: none;" value="<?= $id ?>" />
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tuluv" <?php echo $tuluv == "1" ? "checked" : null ?>>
                                <label class="form-check-label"> Төлөв </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hariult" id="typeone" value="0" onchange="yesno(this)" <?php echo $turul == "0" ? "checked" : null ?> />
                                <label class="form-check-label" for="typeone">
                                    Тийм/Үгүй хариулт
                                </label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="hariult" id="typemulti" value="1" onchange="yesno(this)" <?php echo $turul == "0" ? null : "checked" ?> />
                                <label class="form-check-label" for="typemulti" >
                                    Олон хариулт
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3" id="expandDiv">
                            <div class="form-check">
                                <input class="form-check-input" id="expand" type="checkbox" name="expand" onchange="yesnoded(this)" <?php echo $ded == "0" ? null : "checked" ?>>
                                <label class="form-check-label" for="expand"> Задаргаатай </label>
                            </div>
                        </div>
                        <div class="col-md-3" id="dedtype">
                            <div class="form-check">
                                <input class="form-check-input" id="dedturul" type="checkbox" name="dedturul" <?php echo $hariulttype == "0" ? null : "checked" ?>>
                                <label class="form-check-label" for="dedturul"> Олон сонголт</label>
                            </div>
                        </div>
                    </div>
                    <div id="dedDiv" class="mb-3 row" style="margin: 30px;">
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="dedner" placeholder="Сонгох хариултыг бичнэ үү" />
                        </div>
                        <div class="col-md-3">
                            <input type="button" class="btn btn-primary" value="Хадгалах" onclick="addDed(<?= $id ?>)" />
                        </div>
                        <div class="col-md-12">
                            <div id="dedinfo" class="alert alert-danger" role="alert" style="margin-top: 10px;">

                            </div>
                        </div>
                        <div id="ded" class="col-md-12">
                            <?php
                            if ($dcount > 0) { ?>
                                <table class="table table-bordered doc-table mt-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">Хариултууд</th>
                                            <th scope="col">Төлөв</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while (_fetch($dstmt)) {
                                            echo "<tr>
                                                <td scope='row'><div class='editcell' onblur='updateValue(this, \"$did\", \"name\")' contenteditable>$dname</div></td>
                                                <td>$dtuluv</td>
                                            </tr>";
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                    <div id="zdedDiv" class="mb-3 row" style="margin: 30px;">
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="zdedner" placeholder="Задрах хариултыг бичнэ үү" />
                        </div>
                        <div class="col-md-3">
                            <input type="button" class="btn btn-primary" value="Хадгалах" onclick="zaddDed(<?= $id ?>)" />
                        </div>
                        <div class="col-md-12">
                            <div id="zdedinfo" class="alert alert-danger" role="alert" style="margin-top: 10px;">

                            </div>
                        </div>
                        <div id="zded" class="col-md-12">
                            <?php
                            if ($mcount > 0) { ?>
                                <table class="table table-bordered doc-table mt-3">
                                    <thead>
                                        <tr>
                                            <th scope="col">
                                                Хариултын нэр
                                            </th>
                                            <th scope="col">Төлөв</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        while (_fetch($mstmt)) {
                                            echo "<tr>
                                                <td scope='row'><div class='editcell' onblur='updateValue(this, \"$mid\", \"name\")' contenteditable>$mname</div></td>
                                                <td>$mtuluv</td>
                                            </tr>";
                                        };
                                        ?>
                                    </tbody>
                                </table>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-primary" value="Хадгалах" name="shalguuredit" />
                    </div>
                </form>
            </div>
            <?php require ROOT . "/pages/footer.php"; ?>
            <script type="text/javascript">
                yesno(null);

                function oneOrMulti(v) {
                    if (v) {
                        $('#expandDiv').css("display", "");
                        $('#dedDiv').css("display", "none");
                    } else {
                        $('#expandDiv').css("display", "none");
                        $('#dedDiv').css("display", "");
                        document.getElementById("expand").checked = false;
                    }
                    yesnoded(null);
                }

                function yesno(t) {
                    if (t === null) {
                        if (document.getElementById("typeone").checked === true) {
                            oneOrMulti(true);
                        } else {
                            oneOrMulti(false);
                        }
                    } else {
                        if (t.checked === true && t.id === "typeone") {
                            oneOrMulti(true);
                        } else {
                            oneOrMulti(false);
                        }
                    }
                }

                function yesnoded(t) {
                    console.log(document.getElementById("typeone").checked);
                    console.log(document.getElementById("expand").checked);
                    if (t === null) {
                        if (document.getElementById("expand").checked === true && document.getElementById("typeone").checked === true) {
                            $('#dedtype').css("display", "");
                            $('#zdedDiv').css("display", "");
                        } else if (document.getElementById("typemulti").checked === true) {
                            $('#dedtype').css("display", "");
                            $('#zdedDiv').css("display", "none");
                        } else {
                            $('#dedtype').css("display", "none");
                            $('#zdedDiv').css("display", "none");
                        }
                    } else {
                        if (t.checked === true && document.getElementById("typeone").checked === true) {
                            $('#dedtype').css("display", "");
                            $('#zdedDiv').css("display", "");
                        } else if (document.getElementById("typemulti").checked === true) {
                            $('#dedtype').css("display", "");
                            $('#zdedDiv').css("display", "none");
                        } else {
                            $('#dedtype').css("display", "none");
                            $('#zdedDiv').css("display", "none");
                        }
                    }
                }

                function addDed(shalguurid) {
                    if ($('#dedner').val().trim() === "") {
                        $('#dedinfo').css("display", "")
                        $('#dedinfo').html('Сонгох хариултыг бичнэ үү!');
                    } else {
                        $('#dedinfo').css("display", "none")
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/shalguur',
                            data: jQuery.param({
                                type: "addDed",
                                shalguurid: shalguurid,
                                name: $('#dedner').val(),
                            }),
                            success: function(data) {
                                $("#ded").html(data);
                            }
                        });
                    }
                }

                function zaddDed(shalguurid) {
                    if ($('#zdedner').val().trim() === "") {
                        $('#zdedinfo').css("display", "")
                        $('#zdedinfo').html('Задрах хариултыг бичнэ үү!');
                    } else {
                        $('#zdedinfo').css("display", "none")
                        $.ajax({
                            type: 'POST',
                            url: 'ajax/shalguur',
                            data: jQuery.param({
                                type: "zaddDed",
                                zshalguurid: shalguurid,
                                zname: $('#zdedner').val(),
                            }),
                            success: function(data) {
                                $("#zded").html(data);
                            }
                        });
                    }
                }

                function updateValue(element, id, turul) {
                    var value = element.innerText;
                    $.ajax({
                        url: 'updateval',
                        type: 'post',
                        data: {
                            type: "shalguurdeds",
                            turul: turul,
                            id: id,
                            value: value
                        },
                        success: function(php_result) {

                        }
                    })
                }
            </script>
        <?php require ROOT . "/pages/end.php";
    } ?>