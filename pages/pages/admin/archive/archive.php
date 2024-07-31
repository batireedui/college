<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php'; 

$id = "0";
$fdate = date('Y-m-d');
$ldate = date('Y-m-d');

if(isset($_POST["sub"])){
    $id = $_POST["turul"];
    $startdate = $_POST["startdate"];
    $enddate = $_POST["enddate"];
    $fdate = $_POST["startdate"];
    $ldate = $_POST["enddate"];
}

?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">АРХИВ</h4>
                <div class="row">
                    <div class="col-12">
                        <form method=post>
                        <div class="row" style="margin-top: 10px">

                                <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                    <select class="form-control" name="turul">
                                        <option value='11' <?php echo $id == 11 ? "selected" : null?>>Галын тахилгат ёслол</option>
                                        <option value='14' <?php echo $id == 14 ? "selected" : null?>>Төлөөлөн</option>
                                        <option value='3' <?php echo $id == 3 ? "selected" : null?>>Өвөг дээдсийн ёслол</option>
                                        <option value='5' <?php echo $id == 5 ? "selected" : null?>>Тэнгэрийн суварга</option>
                                        <option value='10' <?php echo $id == 10 ? "selected" : null?>>АЗ ЖАРГАЛЫН БУРХАН</option>
                                        <option value='8' <?php echo $id == 8 ? "selected" : null?>>МАНАЛ БУРХАН</option>
                                        <option value='9' <?php echo $id == 9 ? "selected" : null?>>Хүслийн дэвтэр</option>
                                        <option value='12' <?php echo $id == 12 ? "selected" : null?>>ЗАМД ОРОХ ЁСЛОЛ</option>
                                        <option value='7' <?php echo $id == 7 ? "selected" : null?>>Хүүхдийн Авралын Бунхан</option>
                                    </select>
                                </div>
                                <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                    <input type="date" class="form-control" name="startdate" value="<?php echo $fdate;?>">
                                </div>
                                <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                    <input type="date" class="form-control" name="enddate" value="<?php echo $ldate;?>">
                                </div>
                                <div class="col-sm-1">
                                    <input type="submit" class="btn btn-primary" value="Хайх" name="sub">
                                </div>
                                <div class="col-sm-2">
                                    <div onclick="ExportToExcel('xlsx')" class="btn btn-success btn-icon-text">Excel<i class="ti-file btn-icon-append"></i></div>
                                </div>
                        </div>
                        </form>
                       
                            <?php if($id == 11) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                               _select(
                                    $cstmt,
                                    $ccount,
                                    "SELECT orders.payid, orders.id, UPPER(honer), UPPER(boner), itemgal.tursun, zutas, total, ognoo FROM `itemgal` INNER JOIN orders ON itemgal.orderid = orders.id WHERE orders.tuluv = ? and itemgal.tuluv = ? $fsql GROUP BY orderid, boner ORDER BY tulsunognoo ASC",
                                    "ii",
                                    ['1', '1'],
                                    $payid,
                                    $oid,
                                    $hname,
                                    $bname,
                                    $tursun,
                                    $zphone,
                                    $ototal,
                                    $ognoo
                                );
                                _selectNoParam($stmt, $count, "SELECT COUNT(productid), products.name, products.id FROM `itemgal` INNER JOIN products ON itemgal.productid = products.id INNER JOIN orders ON itemgal.orderid = orders.id WHERE orders.tuluv = '1' and itemgal.tuluv = '1' $fsql GROUP BY productid", $countp, $namep, $idp);
                                _selectRowNoParam("SELECT COUNT(itemgal.id) FROM `itemgal` INNER JOIN orders ON itemgal.orderid = orders.id WHERE orders.tuluv = '1' and itemgal.tuluv = '1' $fsql", $countHuselt);
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $ccount ?>
                                        </div>
                                        <div type="button" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт хэрэглүүр: <?= $countHuselt ?>
                                        </div>
                                        <?php
                                        while (_fetch($stmt)) {
                                            echo "<div class='btn btn-outline-info btn-sm' style='margin-left: 10px; margin-top: 10px;'>$namep: $countp</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="table-responsive" style="height: 62vh">
                                 <table id="gal-listing" class="">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Төрөл</th>
                                            <th class="fix">Дугаар</th>
                                            <th>Захиалагч</th>
                                            <th>Хэний нэр дээр</th>
                                            <th>Огноо</th>
                                            <th>Утас</th>
                                            <th>Хэрэглүүр</th>
                                            <th>Хэрэглүүр/Япон</th>
                                            <th>Хүсэлт</th>
                                            <th>Хүсэлт/Япон</th>
                                            <th>Хандив</th>
                                            <th>Төрсөн</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $t = 1;
                                        if ($ccount > 0) {
                                            while (_fetch($cstmt)) {
                                                _select(
                                                    $cstmtc,
                                                    $ccountc,
                                                    "SELECT products.name, itemgal.huselt, zproducts.price, zproducts.id, jpname, jphuselt, ognoo, ymar FROM itemgal INNER JOIN products ON itemgal.productid = products.id INNER JOIN zproducts ON itemgal.zproductid = zproducts.id INNER JOIN orders ON zproducts.orderid = orders.id WHERE itemgal.orderid = ? and boner =? $fsql",
                                                    "is",
                                                    [$oid, $bname],
                                                    $cname,
                                                    $chuselt,
                                                    $zprice,
                                                    $zid,
                                                    $jpname,
                                                    $jphuselt,
                                                    $ognoo,
                                                    $ymar
                                                );
                                                $rs = "";
                                                if ($ccountc > 1) {
                                                    $rs = " rowspan=$ccountc";
                                                }
                                                echo "";
                                                $av = 1;
                                                while (_fetch($cstmtc)) {
                                                    if ($av == 1) {
                                                        echo "<tr>
                                                                <td $rs>$t</td>
                                                                <td $rs>$ymar</td>
                                                                <td $rs class='fix'><div style=''>$payid</div></td>
                                                                <td $rs>$hname></td>
                                                                <td $rs>$bname</td>
                                                                <td $rs>$ognoo</td>
                                                                <td $rs>$zphone</td>
                                                                <td>$cname</td>
                                                                <td>$jpname</td>
                                                                <td>$chuselt</td>
                                                                <td>$jphuselt</td>
                                                                <td>" . formatMoney($zprice) . "</td>
                                                                <td $rs>$tursun</td>
                                                            </tr>";
                                                    } else echo "<tr><td>$cname</td><td>$jpname</td><td>$chuselt</td>
                                                                <td>$jphuselt</td><td>" . formatMoney($zprice) . "</td></tr>";
                                                    $av++;
                                                }
                                                $t++;
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                </div>
                        <?php endif; ?>
                        
                        <?php if($id == 14) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                               _select(
                                    $cstmt,
                                    $ccount,
                                    "SELECT orders.payid, orders.id, UPPER(honer), UPPER(boner), itemtuluulun.tursun, zutas, total, ognoo, facebook FROM `itemtuluulun` INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = ? and itemtuluulun.tuluv = ? $fsql GROUP BY orderid, boner ORDER BY tulsunognoo ASC",
                                    "ii",
                                    ['1', '1'],
                                    $payid,
                                    $oid,
                                    $hname,
                                    $bname,
                                    $tursun,
                                    $zphone,
                                    $ototal,
                                    $ognoo,
                                    $facebook
                                );
                                _selectNoParam($stmt, $count, "SELECT COUNT(productid), products.name, products.id FROM `itemtuluulun` INNER JOIN products ON itemtuluulun.productid = products.id INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = '1' and itemtuluulun.tuluv = '1' $fsql GROUP BY productid", $countp, $namep, $idp);
                                _selectRowNoParam("SELECT COUNT(itemtuluulun.id) FROM `itemtuluulun` INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = '1' and itemtuluulun.tuluv = '1' $fsql", $countHuselt);
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $ccount ?>
                                        </div>
                                        <div type="button" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт хэрэглүүр: <?= $countHuselt ?>
                                        </div>
                                        <?php
                                        while (_fetch($stmt)) {
                                            echo "<div class='btn btn-outline-info btn-sm' style='margin-left: 10px; margin-top: 10px;'>$namep: $countp</div>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="table-responsive" style="height: 62vh">
                            <table id="gal-listing" class="">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="fix">Дугаар</th>
                                        <th>Овог</th>
                                        <th>Нэр</th>
                                        <th>Утас</th>
                                        <th>Facebook</th>
                                        <th>Хэрэглүүр</th>
                                        <th>Хүсэлт</th>
                                        <th>Хандив</th>
                                        <th>Төрсөн</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 1;
                                    if ($ccount > 0) {
                                        while (_fetch($cstmt)) {
                                            _select(
                                                $cstmtc,
                                                $ccountc,
                                                "SELECT products.name, itemtuluulun.huselt, zproducts.price, zproducts.id, jpname, jphuselt FROM itemtuluulun INNER JOIN products ON itemtuluulun.productid = products.id INNER JOIN zproducts ON itemtuluulun.zproductid = zproducts.id INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE itemtuluulun.orderid = ? and boner =? $fsql",
                                                "is",
                                                [$oid, $bname],
                                                $cname,
                                                $chuselt,
                                                $zprice,
                                                $zid,
                                                $jpname,
                                                $jphuselt
                                            );
                                            $rs = "";
                                            if ($ccountc > 1) {
                                                $rs = " rowspan=$ccountc";
                                            }
                                            echo "";
                                            $av = 1;
                                            while (_fetch($cstmtc)) {
                                                if ($av == 1) {
                                                    echo "<tr>
                                                            <td $rs>$t</td>
                                                            <td $rs class='fix'><div style=''>$payid</div></td>
                                                            <td $rs><div class='editcell' onblur='updateValue(this, $zid, \"honer\")' contenteditable='true'>$hname</div></td>
                                                            <td $rs><div class='editcell' onblur='updateValue(this, $zid, \"boner\")' contenteditable='true'>$bname</div></td>
                                                            <td $rs>$zphone</td>
                                                            <td $rs><div class='editcell' onblur='updateValue(this, $zid, \"facebook\")' contenteditable='true'>$facebook</div></td>
                                                            <td>$cname</td>
                                                            <td><div class='editcell' onblur='updateValue(this, $zid, \"huselt\")' contenteditable='true'>$chuselt</div></td>
                                                            <td>" . formatMoney($zprice) . "</td>
                                                            <td $rs><div class='editcell' onblur='updateValue(this, $zid, \"tursun\")' contenteditable='true'>$tursun</div></td>
                                                        </tr>";
                                                } else echo "<tr>
                                                                <td>$cname</td>
                                                                <td><div class='editcell' onblur='updateValue(this, $zid, \"huselt\")' contenteditable='true'>$chuselt</div></td>
                                                                <td>" . formatMoney($zprice) . "</td></tr>";
                                                $av++;
                                            }
                                            $t++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endif; ?>
                        
                        <?php if($id == 3) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                                _select(
                                    $stmtDeedes,
                                    $countDeedes,
                                    "SELECT orders.payid, orders.id, UPPER(zner), UPPER(hend), utas, zognoo, handiv, zproducts.price, itemdeedes.id, itemdeedes.dtuluv, itemdeedes.too, ymar FROM `itemdeedes` INNER JOIN orders ON itemdeedes.orderid = orders.id INNER JOIN zproducts ON itemdeedes.zproductid = zproducts.id WHERE orders.tuluv = ? and tuluvs = ? $fsql ORDER BY orders.id ASC",
                                    "ii",
                                    ['1', '1'],
                                    $payidDeedes,
                                    $oidDeedes,
                                    $znerDeedes,
                                    $hendDeedes,
                                    $utasDeedes,
                                    $zognooDeedes,
                                    $handivDeedes,
                                    $priceDeedes,
                                    $itemidDeedes,
                                    $dtuluvDeedes,
                                    $tooDeedes,
                                    $ymar
                                    
                                );
                                _selectRowNoParam("SELECT SUM(itemdeedes.too) FROM `itemdeedes` INNER JOIN orders ON itemdeedes.orderid = orders.id WHERE orders.tuluv = '1' and itemdeedes.tuluvs = '1' $fsql", $countHuselt);
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $countDeedes ?>
                                         </div>
                                         <div class="btn btn-danger btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Сүнсний тоо: <?= $countHuselt ?>
                                         </div>
                                    </div>
                                </div>
                                <div class="table-responsive" style="height: 60vh">
                                    <table id="gal-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Дугаар</th>
                                                <th>Төрөл</th>
                                                <th>Төлөв</th>
                                                <th>Захиалж буй хүний овог, нэр</th>
                                                <th>Хэний нэр дээр</th>
                                                <th>Утас</th>
                                                <th>Хэдэн удаа</th>
                                                <th>Хандив</th>
                                                <th>Дүн</th>
                                                <th>Огноо</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $t = 1;
                                            if ($countDeedes > 0) {
                                                while (_fetch($stmtDeedes)) {
                                                    
                                                    $tval = "<select onchange='updateTuluv(this, \"$itemidDeedes\", \"dtuluv\")'";
                                                    if($dtuluvDeedes == '1') { $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Илгээгдсэн</option><option value='2'>Баталгаажсан</option></select>"; }
                                                    else if ($dtuluvDeedes == '2') { $tval .= "class='badge badge-danger'><option value='0' >Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2' selected>Баталгаажсан</option></select>"; }
                                                    else { $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2'>Баталгаажсан</option></select>"; }                                                    echo "<tr>
                                                            <td>$t</td>
                                                            <td>$payidDeedes</td>
                                                            <td>$ymar</td>
                                                            <td>$tval</td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidDeedes\", \"zner\")' contenteditable>$znerDeedes</div></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidDeedes\", \"hend\")' contenteditable>$hendDeedes</div></td>
                                                            <td>$utasDeedes</td>
                                                            <td class='toonuud'>$tooDeedes</td>
                                                            <td>$handivDeedes</td>
                                                            <td>$priceDeedes</td>
                                                            <td>$zognooDeedes</td>
                                                        </tr>";
                                                    $t++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif; ?>
                        
                        <?php if($id == 5) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                                _select(
                                    $stmtSuvarga,
                                    $countSuvarga,
                                    "SELECT orders.payid, orders.id, UPPER(zovogner), UPPER(tovogner), zutas, tursun, husel, zproducts.price, itemtenger.id, itemtenger.dtuluv, products.name, products.jpname , orders.ognoo FROM `itemtenger` INNER JOIN orders ON itemtenger.orderid = orders.id INNER JOIN zproducts ON itemtenger.zproductid = zproducts.id INNER JOIN products ON itemtenger.productid = products.id  WHERE orders.tuluv = ? and tuluvs = ? $fsql ORDER BY orders.id DESC",
                                    "ii",
                                    ['1', '1'],
                                    $payidSuvarga,
                                    $oidSuvarga,
                                    $zovognerSuvarga,
                                    $tovognerSuvarga,
                                    $utasSuvarga,
                                    $tursunSuvarga,
                                    $huselSuvarga,
                                    $priceSuvarga,
                                    $itemidSuvarga,
                                    $dtuluvSuvarga,
                                    $nameSuvarga,
                                    $jpnameSuvarga,
                                    $ognooSuvarga
                                );
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $countSuvarga ?>
                                         </div>
                                    </div>
                                </div>
                                <div class="table-responsive" style="height: 60vh">
                                    <table id="gal-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Дугаар</th>
                                                <th>Төлөв</th>
                                                <th>Захиалж буй хүний овог, нэр</th>
                                                <th>Хэний нэр дээр</th>
                                                <th>Төрсөн огноо</th>
                                                <th>Утас</th>
                                                <th>Суварга</th>
                                                <th>Япон</th>
                                                <th>Суварга/Хүсэлт</th>
                                                <th>Дүн</th>
                                                <th>Огноо</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $t = 1;
                                            if ($countSuvarga > 0) {
                                                while (_fetch($stmtSuvarga)) {
                                                    $tval = "<select onchange='updateTuluv(this, \"$itemidSuvarga\", \"dtuluv\")'";
                                                    if($dtuluvSuvarga == '1') { $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Илгээгдсэн</option></select>"; }
                                                    else { $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option></select>"; }
                                                    echo "<tr>
                                                            <td>$t</td>
                                                            <td>$payidSuvarga</td>
                                                            <td>$tval</td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidSuvarga\", \"zovogner\")' contenteditable>$zovognerSuvarga</div></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidSuvarga\", \"tovogner\")' contenteditable>$tovognerSuvarga</div></td>
                                                            <td>$tursunSuvarga</td>
                                                            <td>$utasSuvarga</td>
                                                            <td>$nameSuvarga</td>
                                                            <td>$jpnameSuvarga</td>
                                                            <td>$huselSuvarga</td>
                                                            <td>$priceSuvarga</td>
                                                            <td>$ognooSuvarga</td>
                                                        </tr>";
                                                    $t++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif; ?>
                        <?php if($id == 10) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                                _select(
                                    $stmtAz,
                                    $countAz,
                                    "SELECT orders.payid, orders.id, zovogner, hend, zognoo, utas, huselt, zproducts.price, itemazjargal.id, itemazjargal.dtuluv, orders.ognoo FROM `itemazjargal` INNER JOIN orders ON itemazjargal.orderid = orders.id INNER JOIN zproducts ON itemazjargal.zproductid = zproducts.id WHERE orders.tuluv = ? and tuluvs=? $fsql ORDER BY orders.id DESC",
                                    "ii",
                                    ['1', '1'],
                                    $payidAz,
                                    $oidAz,
                                    $ovognerAz,
                                    $hendAz,
                                    $zognooAz,
                                    $utasAz,
                                    $huseltAz,
                                    $priceAz,
                                    $itemidAz,
                                    $dtuluvAz,
                                    $hezeeAz
                                );
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $countAz ?>
                                         </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="gal-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Дугаар</th>
                                                <th>Төлөв</th>
                                                <th>Захиалж буй хүний овог, нэр</th>
                                                <th>Хэнд</th>
                                                <th>Төрсөн огноо</th>
                                                <th>Утас</th>
                                                <th>Хүсэлт</th>
                                                <th>Дүн</th>
                                                <th>Захиалсан</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $t = 1;
                                            if ($countAz > 0) {
                                                while (_fetch($stmtAz)) {
                                                    $tval = "<select style='border: 0;' onchange='updateTuluv(this, \"$itemidAz\", \"dtuluv\")'";
                                                    if($dtuluvAz == '1')
                                                    { $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Илгээгдсэн</option><option value='2'>Зураг ирсэн</option></select>"; }
                                                    else if($dtuluvAz == '2') { $tval .= "class='badge badge-danger'><option value='0'>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2' selected>Зураг ирсэн</option></select>";}
                                                    else { $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2'>Зураг ирсэн</option></select>";}
                                                    echo "<tr>
                                                            <td>$t</td>
                                                            <td>$payidAz</td>
                                                            <td>$tval</td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidAz\", \"zovogner\")' contenteditable>$ovognerAz</div></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidAz\", \"hend\")' contenteditable>$hendAz</div></td>
                                                            <td><div class='editcell'>$zognooAz</div></td>
                                                            <td>$utasAz</td>
                                                            <td>$huseltAz</td>
                                                            <td>$priceAz</td>
                                                            <td>$hezeeAz</td>
                                                        </tr>";
                                                    $t++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif; ?>
                        <?php if($id == 8) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                                _select(
                                    $stmtManal,
                                    $countManal,
                                    "SELECT orders.payid, orders.id, zovogner, tognoo, utas, huselt, zproducts.price, itemmanal.id, itemmanal.dtuluv FROM `itemmanal` INNER JOIN orders ON itemmanal.orderid = orders.id INNER JOIN zproducts ON itemmanal.zproductid = zproducts.id WHERE tuluvs=? and orders.tuluv = ? $fsql",
                                    "ii",
                                    ['1', '1'],
                                    $payidManal,
                                    $oidManal,
                                    $ovognerManal,
                                    $tognooManal,
                                    $utasManal,
                                    $huseltManal,
                                    $priceManal,
                                    $itemidManal,
                                    $dtuluvManal
                                );
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $countManal ?>
                                         </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="gal-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Дугаар</th>
                                                <th>Төлөв</th>
                                                <th>Захиалж буй хүний овог, нэр</th>
                                                <th>Төрсөн огноо</th>
                                                <th>Утас</th>
                                                <th>Хүсэлт</th>
                                                <th>Дүн</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $t = 1;
                                            if ($countManal > 0) {
                                                while (_fetch($stmtManal)) {
                                                    $tval = "<select style='border: 0;' onchange='updateTuluv(this, \"$itemidManal\", \"dtuluv\")'";
                                                    if($dtuluvManal == '1') $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Илгээгдсэн</option><option value='2'>Зураг ирсэн</option></select>";
                                                    else if($dtuluvManal == '2') $tval .= "class='badge badge-danger'><option value='0'>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2' selected>Зураг ирсэн</option></select>";
                                                    else $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2'>Зураг ирсэн</option></select>";
                                                    echo "<tr>
                                                            <td>$t</td>
                                                            <td>$payidManal</td>
                                                            <td>$tval</td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidManal\", \"zovogner\")' contenteditable>$ovognerManal</div></td>
                                                            <td><div class='editcell'>$tognooManal</div></td>
                                                            <td>$utasManal</td>
                                                            <td>$huseltManal</td>
                                                            <td>$priceManal</td>
                                                        </tr>";
                                                    $t++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif; ?>
                        <?php if($id == 9) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                                _select(
                                    $stmtDevter,
                                    $countDevter,
                                    "SELECT orders.payid, orders.id, zovogner, hend, yslol, utas, kod, zproducts.price, itemdevter.id, itemdevter.dtuluv, tulsunognoo FROM `itemdevter` INNER JOIN orders ON itemdevter.orderid = orders.id INNER JOIN zproducts ON itemdevter.zproductid = zproducts.id WHERE tuluvs=? and tuluv = ? $fsql order by tulsunognoo DESC",
                                    "ii",
                                    ['1', '1'],
                                    $payidDevter,
                                    $oidDevter,
                                    $ovognerDevter,
                                    $hendDevter,
                                    $yslolDevter,
                                    $utasDevter,
                                    $kodDevter,
                                    $priceDevter,
                                    $itemidDevter,
                                    $dtuluvDevter,
                                    $tulsunDevter
                                );
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $countDevter ?>
                                         </div>
                                    </div>
                                </div>
                                <div class="table-responsive" style="height: 60vh">
                                    <table id="gal-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Дугаар</th>
                                                <th>Захиалж буй хүний овог, нэр</th>
                                                <th>Хэний нэр дээр</th>
                                                <th>Замд орох ёслолд</th>
                                                <th>Код</th>
                                                <th>Утас</th>
                                                <th>Төлөв</th>
                                                <th>Дүн</th>
                                                <th>Огноо</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $t = 1;
                                            if ($countDevter > 0) {
                                                while (_fetch($stmtDevter)) {
                                                    $tval = "<select style='border: 0;' onchange='updateTuluv(this, \"$itemidDevter\", \"dtuluv\")'";
                                                    if($dtuluvDevter == '1') $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Бэлэн болсон</option><option value='2'>Авсан</option></select>";
                                                    else if($dtuluvDevter == '2') $tval .= "class='badge badge-danger'><option value='0'>Хүлээгдэж байгаа</option><option value='1'>Бэлэн болсон</option><option value='2' selected>Авсан</option></select>";
                                                    else $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Бэлэн болсон</option><option value='2'>Авсан</option></select>";
                                                    echo "<tr>
                                                            <td>$t</td>
                                                            <td><button class='btn btn-success btn-sm'>$payidDevter</button></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidDevter\", \"zovogner\")' contenteditable>$ovognerDevter</div></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidDevter\", \"hend\")' contenteditable>$hendDevter</div></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidDevter\", \"yslol\")' contenteditable>$yslolDevter</div></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidDevter\", \"kod\")' contenteditable>$kodDevter</div></td>
                                                            <td><div class='editcell' onblur='updateValue(this, \"$itemidDevter\", \"utas\")' contenteditable>$utasDevter</div></td>
                                                            <td>$tval</td>
                                                            <td>$priceDevter</td>
                                                            <td>$tulsunDevter</td>
                                                        </tr>";
                                                    $t++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif; ?>
                        <?php if($id == 12) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                                _select(
                                    $stmtZamd,
                                    $countZamd,
                                    "SELECT orders.payid, orders.id, ovog, ner, rd, tursun, gender, medner, tgazar, hayag, utas, facebook, hezee, zproducts.price, itemzamd.id, itemzamd.kod, itemzamd.dtuluv, sms FROM `itemzamd` INNER JOIN orders ON itemzamd.orderid = orders.id INNER JOIN zproducts ON itemzamd.zproductid = zproducts.id WHERE tuluvs=? and tuluv = ? $fsql ORDER BY hezee DESC",
                                    "ii",
                                    ['1', '1'],
                                    $payidZamd,
                                    $oidZamd,
                                    $ovogZamd,
                                    $nerZamd,
                                    $rdZamd,
                                    $tursunZamd,
                                    $genderZamd,
                                    $mednerZamd,
                                    $tgazarZamd,
                                    $hayagZamd,
                                    $utasZamd,
                                    $facebookZamd,
                                    $hezeeZamd,
                                    $priceZamd,
                                    $itemidZamd,
                                    $kodZamd,
                                    $dtuluvZamd,
                                    $smsZamd
                                );
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $countZamd ?>
                                         </div>
                                    </div>
                                </div>
                                <div class="table-responsive"  style="height: 60vh">
                                    <table id="gal-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th class='fix'>Дугаар</th>
                                                <th>ЗОЁ-Код</th>
                                                <th>SMS</th>
                                                <th>Төлөв</th>
                                                <th>Ёслолд орох</th>
                                                <th>Овог</th>
                                                <th>Нэр</th>
                                                <th>Төрсөн огноо</th>
                                                <th>Хүйс</th>
                                                <th>Мэдээлэл өгсөн хүний нэр</th>
                                                <th>Төрсөн газар</th>
                                                <th>Утасны дугаар</th>
                                                <th>Facebook</th>
                                                <th>Гэрийн хаяг</th>
                                                <th>РД</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $t = 1;
                                            $old = "";
                                            if ($countZamd > 0) {
                                                while (_fetch($stmtZamd)) {
                                                    $tval = "<select onchange='updateTuluv(this, \"$itemidZamd\", \"dtuluv\")'";
                                                    if($dtuluvZamd == '1') $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Орсон</option></select>";
                                                    else $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Орсон</option></select>";
                                                    echo "<tr>
                                                            <td>$t</td>
                                                            <td class='fix'>$payidZamd</td>
                                                            <td><div>$kodZamd</div></td>
                                                            <td><div class='badge badge-info' style='cursor: pointer' onclick='sendsms($itemidZamd)'>SMS: $smsZamd</div></td>
                                                            <td>$tval</td>
                                                            <td><div>$hezeeZamd</div></td>
                                                            <td><div>$ovogZamd</div></td>
                                                            <td><div>$nerZamd</div></td>
                                                            
                                                            <td><div>$tursunZamd</div></td>
                                                            <td><div>$genderZamd</div></td>
                                                            <td><div>$mednerZamd</div></td>
                                                            <td><div>$tgazarZamd</div></td>
                                                            
                                                            <td><div>$utasZamd</div></td>
                                                            <td><div>$facebookZamd</div></td>
                                                            <td><div>$hayagZamd</div></td>
                                                            <td><div>$rdZamd</div></td>
                                                        </tr>";
                                                    $t++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif; ?>
                        <?php if($id == 7) :
                                $fsql = " and orders.ognoo between '$startdate 00:00:00' and '$enddate 23:59:00'";
                               _select(
                                    $stmtHuuhed,
                                    $countHuuhed,
                                    "SELECT orders.payid, orders.id, UPPER(tner), UPPER(ehovogner), tognoo, utas, zproducts.price, itemhuuhed.id, itemhuuhed.dtuluv FROM `itemhuuhed` INNER JOIN orders ON itemhuuhed.orderid = orders.id INNER JOIN zproducts ON itemhuuhed.zproductid = zproducts.id WHERE tuluvs=? and tuluv = ? $fsql GROUP BY itemhuuhed.id DESC",
                                    "ii",
                                    ['1', '1'],
                                    $payidHuuhed,
                                    $oidHuuhed,
                                    $tnerHuuhed,
                                    $ehovognerHuuhed,
                                    $tognooHuuhed,
                                    $zphoneHuuhed,
                                    $zpriceHuuhed,
                                    $itemidHuuhed,
                                    $dtuluvHuuhed
                                );
                                ?>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                            Нийт захиалагч: <?= $countHuuhed ?>
                                         </div>
                                    </div>
                                </div>
                                 <div class="table-responsive" style="height: 60vh">
                                    <table id="gal-listing" class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Дугаар</th>
                                                <th>Төлөв</th>
                                                <th>Талийгаач хүүхдийн нэр</th>
                                                <th>Нас барсан огноо</th>
                                                <th>Ээжийн нэр</th>
                                                <th>Утас</th>
                                                <th>Дүн</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $t = 1;
                                            if ($countHuuhed > 0) {
                                                while (_fetch($stmtHuuhed)) {
                                                    $tval = "<select style='border: 0;' onchange='updateTuluv(this, \"$itemidHuuhed\", \"dtuluv\")'";
                                                    if($dtuluvHuuhed == '1') $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Илгээгдсэн</option><option value='2'>Зураг ирсэн</option></select>";
                                                    else if($dtuluvHuuhed == '2') $tval .= "class='badge badge-danger'><option value='0'>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2' selected>Зураг ирсэн</option></select>";
                                                    else $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2'>Зураг ирсэн</option></select>";
                                                    echo "<tr>
                                                            <td>$t</td>
                                                            <td>$payidHuuhed</td>
                                                            <td>$tval</td>
                                                            <td><div>$tnerHuuhed</div></td>
                                                            <td><div>$tognooHuuhed</div></td>
                                                            <td>$ehovognerHuuhed</td>
                                                            <td>$zphoneHuuhed</td>
                                                            <td>$zpriceHuuhed</td>
                                                        </tr>";
                                                    $t++;
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require ROOT . '/pages/admin/footer.php'; ?>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function sendsms(id){
            if(confirm("Мессеж илгээхдээ итгэлтэй байна уу?") == true){
                $.ajax({
                    url: '/admin/zahialga/sendsms',
                    type: 'post',
                    data:{
                        type: "zamdsms",
                        id: id
                    },
                    success: function(php_result)
                    {
                        alert(php_result);
                    }
                })
            }
        }
        function updateValue(){
            
        }
        function ExportToExcel(type, fn, dl) {
            var today = new Date();
            var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            var time = today.getHours() + "-" + today.getMinutes() + "-" + today.getSeconds();
            var dateTime = date + ' ' + time;
            var elt = document.getElementById('gal-listing');
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "sheet1"
            });
            return dl ?
                XLSX.write(wb, {
                    bookType: type,
                    bookSST: true,
                    type: 'base64'
                }) :
                XLSX.writeFile(wb, fn || ('Архив-' + dateTime + '.' + (type || 'xlsx')));
        }
        
        function tablefilter(val) {
            var input, filter, table, tr, td, i;
            if (val === 1) {
                input = document.getElementById("filterInput");
            } else if (val === 2) {
                input = document.getElementById("filterName");
            } else {
                input = document.getElementById("filterPhone");
            }
            filter = input.value.toUpperCase();
            table = document.getElementById("order-listing");
            tr = table.getElementsByTagName("tr");
            var show = true;
            var spannedRows = 0;
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[val];
                if (spannedRows > 0) {
                    if (show)
                        tr[i].style.display = "";
                    else
                        tr[i].style.display = "none";
                    spannedRows--;
                } else if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    let rs = td.getAttribute("rowspan");
                    console.log("rs = " + rs);
                    if (rs && rs > 1) {
                        show = td.innerHTML.toUpperCase().indexOf(filter) > -1;
                        spannedRows = rs - 1;
                    }
                }
            }
        }
    </script>