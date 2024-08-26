<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$tuluv = ""; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">ХӨЗӨР-ЦАГ ОРУУЛАХ</p>
                        <form action="/admin/huzur/huzurapi" method="POST" onsubmit="disableButton()">
                            <input type="text" name="cagadd" style="display: none" value="1"/>
                            <div class="modal-body">
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="proprice">Төрөл</label>
                                        <?php
                                        _selectNoParam(
                                            $cstmt,
                                            $ccount,
                                            "SELECT id, name FROM huzurtype",
                                            $hzid,
                                            $hzname
                                        ); ?>
                                        <select class="form-control" name="turul" onchange="getTeach(value)">
                                            <option>Төрлөө сонгоно уу</option>
                                            <?php
                                            while (_fetch($cstmt)) {
                                                echo "<option value='$hzid'>$hzname</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="">Багш</label>
                                        <select class="form-control" name="teacher" id="teachList">
                                            
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="proprice">Огноо</label>
                                        <input class="form-control" name="ognoo" id="proprice" type="date" value="" />
                                    </div>
                                    <div class="col">
                                        <label for="protoo">Цаг</label>
                                        <select class="form-control" name="cag">
                                            <?php
                                            for ($i = 7; $i < 23; $i++)
                                                echo "<option>$i</option>";
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="protoo">Мин</label>
                                        <select class="form-control" name="min">
                                            <?php
                                            for ($i = 0; $i < 60; $i = $i + 5)
                                                echo $i < 10 ? "<option>0$i</option>" : "<option>$i</option>"
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="protoo">Холбоос</label>
                                        <select class="form-control" name="link">
                                            <option>Тэндоү Зөвлөгөө</option>
                                            <option>Tendou Card</option>
                                            <option>Танхим</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input id="subbtn" type="submit" class="btn btn-primary" name="cagadd" value ="Хадгалах" />
                            </div>
                        </form>
                        <?php
                        _selectNoParam(
                            $cstmt,
                            $ccount,
                            "SELECT huzurcag.id, huzurtype.name, huzurteacher.name, huzurteacher.utas, huzurcag.hezee, price, pricet, link, user_type FROM huzurcag INNER JOIN huzurtype ON huzurcag.huzurtypeid = huzurtype.id INNER JOIN huzurteacher ON huzurcag.teachid = huzurteacher.id ORDER BY huzurcag.hezee DESC",
                            $id,
                            $type,
                            $teach,
                            $utas,
                            $hezee,
                            $price,
                            $pricet,
                            $link,
                            $user_type
                        ); ?>
                        <div class="table-responsive">
                            <table class='table table-striped table-borderless' style="width: 100%">
                                <thead>
                                    <th></th>
                                    <th>Төрөл</th>
                                    <th>Багш</th>
                                    <th>Цаг</th>
                                    <th>Холбоос</th>
                                    <th>Нэмсэн</th>
                                    <th>Үйлдэл</th>
                                </thead>
                                <?php
                                $ntoo = 1;
                                if ($ccount > 0) {
                                while (_fetch($cstmt)) {
                                    
                                 _selectNoParam(
                                    $cistmt,
                                    $cicount,
                                    "SELECT id FROM itemhuzur WHERE huzurcagid='$id'",
                                        $itemid
                                    );
                                    echo "<tr>
                                        <td>$ntoo</td>
                                        <td>$type</td>
                                        <td>$teach</td>
                                        <td>$hezee</td>
                                        <td>$link</td>
                                        <td>$user_type</td>";
                                        if($cicount > 0){
                                            echo "<td><button type='button' class='btn btn-success btn-sm'>Захиалгатай</button></td>";
                                        }
                                        else {
                                        echo "<td><a href='/admin/record/deletehuzur?id=$id' onclick='return confirm(\"$type - $hezee цаг устгах уу?\")'><button type='button' class='btn btn-danger btn-sm'>Устгах</button></a></td>";}
                                        echo "</tr>";
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
            function disableButton() {
                var btn = document.getElementById('subbtn');
                btn.disabled = true;
                btn.value = 'Түр хүлээнэ үү...'
            }
            function getTeach(id){
                $.ajax({
                    url: '/admin/huzur/huzurapi',
                    type: 'POST',
                    data: jQuery.param({
                        getTeach: "getTeach",
                        id: id
                    }),
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                    success: function(detialres) {
                        $('#teachList').html(detialres);
                    },
                    error: function(deterr) {
                        console.log(deterr);
                    }
                });
            }
            </script>
            <?php require ROOT . '/pages/admin/end.php'; ?>