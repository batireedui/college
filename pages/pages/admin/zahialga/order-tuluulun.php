<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$filterid = "";
if (isset($_GET['idp'])) $filterid = $_GET['idp'];
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Төлөөлөн</h4>
                <div class="modal fade" id="menuadd" tabindex="-1" role="dialog" aria-labelledby="menuaddlabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="menuaddlabel">Цэс, мэдээлэл нэмэх</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="/admin/record/new" method="POST">
                                <div class="modal-body">
                                    <label for="tit">Цэсний нэр</label>
                                    <input class="form-control" name="menuname" id="menutitle" type="text" /><br>
                                    <label for="tit">Цэсний байрлал</label>
                                    <div class="form-check form-check-flat">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-control" id="ctuluv" name="ctuluv">
                                            Идэвхтэй эсэх (Дэлгэцэнд харуулах эсэх)
                                            <i class="input-helper"></i></label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Хаах</button>
                                    <button type="submit" class="btn btn-primary" name="menuadd">Хадгалах</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <?php
                        if ($filterid == "") {
                            $fsql = "";
                        } else {
                            $fsql = " and itemtuluulun.productid=$filterid";
                        }
                        _select(
                            $cstmt,
                            $ccount,
                            "SELECT orders.payid, orders.id, UPPER(honer), UPPER(boner), itemtuluulun.tursun, zutas, total, ognoo, facebook, orders.dtuluv FROM `itemtuluulun` INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = ? and itemtuluulun.tuluv = ? $fsql GROUP BY orderid, boner ORDER BY tulsunognoo ASC",
                            "ii",
                            ['1', '0'],
                            $payid,
                            $oid,
                            $hname,
                            $bname,
                            $tursun,
                            $zphone,
                            $ototal,
                            $ognoo,
                            $facebook,
                            $dtuluv
                        );
                        _selectNoParam($stmt, $count, "SELECT COUNT(productid), products.name, products.id FROM `itemtuluulun` INNER JOIN products ON itemtuluulun.productid = products.id INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = '1' and itemtuluulun.tuluv = '0' GROUP BY productid", $countp, $namep, $idp);
                        _selectRowNoParam("SELECT COUNT(itemtuluulun.id) FROM `itemtuluulun` INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = '1' and itemtuluulun.tuluv = '0'", $countHuselt);
                        ?>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                    Нийт захиалагч: <?= $ccount ?>
                                </div>
                                <a href='/admin/zahialga/order-tuluulun'>
                                    <button type="button" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                        Нийт хэрэглүүр: <?= $countHuselt ?>
                                    </button>
                                </a>
                                <?php
                                while (_fetch($stmt)) {
                                    echo "<a href='/admin/zahialga/order-tuluulun?idp=$idp'><button class='btn btn-outline-info btn-sm' style='margin-left: 10px; margin-top: 10px;'>$namep: $countp</button></a>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1)" placeholder="Захиалгын дугаараар">
                            </div>
                            <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(2)" placeholder="Захиалагчийн нэрээр">
                            </div>
                            <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(4)" placeholder="Утасны дугаараар">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <a href="/admin/zahialga/hold?tuluulunhold=1" onclick='return confirm("Нийт захиалгуудыг биелэсэн төлөвт шилжүүлэх үү?")'><button class="btn btn-danger">Биелэсэнд шилжүүлэх</button></a>
                            </div>
                            <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                                <button onclick="ExportToExcel('xlsx')" class="btn btn-success btn-icon-text">Excel<i class="ti-file btn-icon-append"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive" style="height: 62vh">
                            <table id="gal-listing" class="">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="fix">Дугаар</th>
                                        <th>Овог, нэр, төрсөн огноо</th>
                                        <th>Хэрэглүүр</th>
                                        <th>Хүсэлт</th>
                                        <th>Утас</th>
                                        <th>Facebook</th>
                                        <th>Хандив</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 1;
                                    if ($ccount > 0) {
                                        while (_fetch($cstmt)) {
                                            $tval = "<select style='border: 0;' onchange='updateTuluv(this, \"$payid\", \"dtuluv\")'";
                                            if($dtuluv == '1')
                                            { $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Бичигдсэн</option><option value='2'>Зураг илгээсэн</option></select>"; }
                                            else if($dtuluv == '2') { $tval .= "class='badge badge-danger'><option value='0'>Хүлээгдэж байгаа</option><option value='1'>Бичигдсэн</option><option value='2' selected>Зураг илгээсэн</option></select>";}
                                            else { $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Бичигдсэн</option><option value='2'>Зураг илгээсэн</option></select>";}
                                            _select(
                                                $cstmtc,
                                                $ccountc,
                                                "SELECT products.name, itemtuluulun.huselt, zproducts.price, zproducts.id, jpname, jphuselt FROM itemtuluulun INNER JOIN products ON itemtuluulun.productid = products.id INNER JOIN zproducts ON itemtuluulun.zproductid = zproducts.id WHERE itemtuluulun.orderid = ? and boner =? $fsql",
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
                                                            <td $rs class='fix'><div style='text-align: center'>$payid <br>$tval</div></td>
                                                            <td $rs><div class='editcell' onblur='updateValue(this, $zid, \"honer\")' contenteditable='true'>($hname)</div></td>
                                                            <td>$cname</td>
                                                            <td><div class='editcell' onblur='updateValue(this, $zid, \"huselt\")' contenteditable='true'>$chuselt</div></td>
                                                            <td $rs>$zphone</td>
                                                            <td $rs><div class='editcell' onblur='updateValue(this, $zid, \"facebook\")' contenteditable='true'>$facebook</div></td>
                                                            <td>" . formatMoney($zprice) . "</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require ROOT . '/pages/admin/footer.php'; ?>
    <script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>
    <script>
        function updateTuluv(element, id, turul)
            {
                var value = element.value;
                $.ajax({
                    url: '/admin/zahialga/updateval',
                    type: 'post',
                    data:{
                        type: "tuluulunupdate",
                        turul: turul,
                        id: id,
                        value: value
                    },
                    success: function(php_result)
                    {
                        console.log(php_result);
                        if(value == "1" ){
                            element.classList.remove("badge-warning");
                            element.classList.remove("badge-danger");
                            element.classList.add("badge-success");
                        }
                        else if(value == "2" ){
                            element.classList.remove("badge-warning");
                            element.classList.remove("badge-success");
                            element.classList.add("badge-danger");
                        }
                        else {
                            element.classList.remove("badge-success");
                            element.classList.remove("badge-danger");
                            element.classList.add("badge-warning");
                        }
                    }
                });
        }
        function updateValue(element, id, turul)
            {
                var value = element.innerText;
                $.ajax({
                    url: '/admin/zahialga/updateval',
                    type: 'post',
                    data:{
                        type: "tuluulunhuseltupdate",
                        turul: turul,
                        id: id,
                        value: value
                    },
                    success: function(php_result)
                    {
                        console.log(php_result);
                    }
                })
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
                XLSX.writeFile(wb, fn || ('Төлөөлөн-' + dateTime + '.' + (type || 'xlsx')));
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
            table = document.getElementById("gal-listing");
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