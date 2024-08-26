<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$tuluv = ""; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">БАГШ НАРЫН ХӨЗӨР НЭМЭХ</p>
                        <form action="/admin/record/huzuraction" method="POST">
                            <div class="modal-body">
                                <div class="form-group row">
                                    <?php
                                        _selectNoParam(
                                            $tstmt,
                                            $tcount,
                                            "SELECT id, name, utas, dtuluv FROM huzurteacher",
                                            $id, $name, $utas, $dtuluv
                                        );
                                    ?>
                                    <div class="col-md-5">
                                        <label for="proprice">Нэр</label>
                                        <select class="form-control" name="teachid">
                                        <?php
                                            while (_fetch($tstmt)){
                                                echo "<option value='$id'>$name</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <?php
                                        _selectNoParam(
                                            $tstmt,
                                            $tcount,
                                            "SELECT id, name, price, pricet FROM huzurtype",
                                            $id, $name, $price, $pricet
                                        );?>
                                    <div class="col-md-5">
                                        <label for="proprice">Утас</label>
                                        <select class="form-control" name="huzurid">
                                        <?php
                                            while (_fetch($tstmt)){
                                                echo "<option value='$id'>$name</option>";
                                            }
                                        ?>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="proprice">.</label>
                                        <input type="submit" class="btn btn-primary" name="huzurteachsetadd" value="Хадгалах" style="width: 100%"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        _selectNoParam(
                            $tstmt,
                            $tcount,
                            "SELECT huzurteachset.id, huzurteacher.name, huzurteacher.utas, huzurtype.name, huzurtype.price, huzurtype.pricet FROM `huzurteachset` INNER JOIN huzurteacher ON huzurteachset.teachid = huzurteacher.id INNER JOIN huzurtype ON huzurteachset.huzurid = huzurtype.id",
                            $id, $tname, $tutas, $hname, $hprice, $hpricet
                        );?>
                        <div class="table-responsive">
                            <table class='table table-striped table-borderless' style="width: 100%">
                                <thead>
                                    <th></th>
                                    <th>Багш</th>
                                    <th>Утас</th>
                                    <th>Хөзөр</th>
                                    <th>Үнэ</th>
                                    <th>Үнэ /Танхим/</th>
                                </thead>
                                <?php
                                $ntoo = 1;
                                if ($tcount > 0) {
                                    while (_fetch($tstmt)) {
                                        echo "<tr>
                                    <td>$ntoo</td>
                                    <td>$tname</td>
                                    <td>$tutas</td>
                                    <td>$hname</td>
                                    <td>$hprice</td>
                                    <td>$hpricet</td>
                                    <td><a href='#$id'><button type='button' class='btn btn-success btn-sm'>Идэвхтэй</button></a></td>
                                    </tr>";
                                        $ntoo++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Мэдээлэл байхгүй байна</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">БАГШ НАР</p>
                        <form action="/admin/record/huzuraction" method="POST">
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-5">
                                        <label for="proprice">Нэр</label>
                                        <input class="form-control" name="name" type="text" value="" />
                                    </div>
                                    <div class="col-md-5">
                                        <label for="proprice">Утас</label>
                                        <input class="form-control" name="utas" type="text" value="" />
                                    </div>
                                    <div class="col-md-2">
                                        <label for="proprice">.</label>
                                        <input type="submit" class="btn btn-primary" name="teacheradd" value="Хадгалах"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        _selectNoParam(
                            $tstmt,
                            $tcount,
                            "SELECT id, name, utas, dtuluv FROM huzurteacher",
                            $id, $name, $utas, $dtuluv
                        );?>
                        <div class="table-responsive">
                            <table class='table table-striped table-borderless' style="width: 100%">
                                <thead>
                                    <th></th>
                                    <th>Нэр</th>
                                    <th>Утас</th>
                                    <th>Төлөв</th>
                                </thead>
                                <?php
                                $ntoo = 1;
                                if ($tcount > 0) {
                                    while (_fetch($tstmt)) {
                                        echo "<tr>
                                    <td>$ntoo</td>
                                    <td>$name</td>
                                    <td><div class='editcell' onblur='updatetValue(this, \"$id\", \"utas\")' contenteditable>$utas</div></td>
                                    <td><a href='#$id'><button type='button' class='btn btn-success btn-sm'>Идэвхтэй</button></a></td>
                                    </tr>";
                                        $ntoo++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Мэдээлэл байхгүй байна</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">ХӨЗРИЙН ТӨРӨЛ, ҮНЭ</p>
                        <form action="/admin/record/huzuraction" method="POST">
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label for="proprice">Нэр</label>
                                        <input class="form-control" name="hname" type="text" value="" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="proprice">Үнэ</label>
                                        <input class="form-control" name="hprice" type="text" value="" />
                                    </div>
                                    <div class="col-md-3">
                                        <label for="proprice">Үнэ/Танхим/</label>
                                        <input class="form-control" name="hpricet" type="text" value="" />
                                    </div>
                                    <div class="col-md-2">
                                        <label for="proprice">.</label>
                                        <input type="submit" class="btn btn-primary" name="huzurtypeadd" value="Хадгалах"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php
                        _selectNoParam(
                            $tstmt,
                            $tcount,
                            "SELECT id, name, price, pricet FROM huzurtype",
                            $htid, $name, $price, $pricet
                        );?>
                        <div class="table-responsive">
                            <table class='table table-striped table-borderless' style="width: 100%">
                                <thead>
                                    <th></th>
                                    <th>Нэр</th>
                                    <th>Үнэ</th>
                                    <th>Үнэ/Танхим/</th>
                                </thead>
                                <?php
                                $ntoo = 1;
                                if ($tcount > 0) {
                                    while (_fetch($tstmt)) {
                                        echo "<tr>
                                    <td>$ntoo</td>
                                    <td>$name</td>
                                    <td><div class='editcell' onblur='updateValue(this, \"$htid\", \"price\")' contenteditable>$price</div></td>
                                    <td><div class='editcell' onblur='updateValue(this, \"$htid\", \"pricet\")' contenteditable>$pricet</div></td>
                                    <td><a href='#$htid'><button type='button' class='btn btn-success btn-sm'>Идэвхтэй</button></a></td>
                                    </tr>";
                                        $ntoo++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Мэдээлэл байхгүй байна</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <?php require ROOT . '/pages/admin/footer.php'; ?>
            <script>
                function updateValue(element, id, turul)
                    {
                        var value = element.innerText;
                        $.ajax({
                            url: '/admin/huzur/updateHuzur',
                            type: 'post',
                            data:{
                                type: "huzurtypeupdate",
                                turul: turul,
                                id: id,
                                value: value
                            },
                            success: function(php_result)
                            {
        
                            }
                        })
                }
                function updatetValue(element, id, turul)
                    {
                        var value = element.innerText;
                        $.ajax({
                            url: '/admin/huzur/updateHuzur',
                            type: 'post',
                            data:{
                                type: "teacherupdate",
                                turul: turul,
                                id: id,
                                value: value
                            },
                            success: function(php_result)
                            {
        
                            }
                        })
                }
            </script>
            <?php require ROOT . '/pages/admin/end.php'; ?>