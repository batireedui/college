<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
_select(
    $stmtAr,
    $countAr,
    "SELECT orders.payid, orders.id, wp_users.display_name, wp_users.user_phone, products.name, zproducts.too, zproducts.price, zproducts.dtuluv, zproducts.id, orders.total, tulsunognoo FROM `orders` INNER JOIN zproducts ON orders.id = zproducts.orderid INNER JOIN products ON zproducts.productid = products.id INNER JOIN wp_users ON orders.userid = wp_users.id WHERE products.cateid = ? and orders.tuluv = ? order by orders.payid desc",
    "ii",
    ['1', '1'],
    $payidAr,
    $oidAr,
    $nerAr,
    $utasAr,
    $pnameAr,
    $tooAr,
    $priceAr,
    $dtuluvAr,
    $zidAr,
    $totalAr,
    $tulsunAr
);
_select(
    $stmttoo,
    $counttoo,
    "SELECT name, too FROM products  WHERE products.cateid = ?",
    "i",
    ['1'],
    $tooName,
    $tooToo
);
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">АРИУН ХУУДАС</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12"><span>ҮЛДЭГДЛҮҮД</span></div>
                            <div class="col-sm-12">
                                <?php while (_fetch($stmttoo))
                                    {
                                        echo "<div class='btn btn-outline-primary btn-sm' style='margin-left: 10px; margin-top: 10px;'>
                                                $tooName: <strong>$tooToo</strong>
                                            </div>";
                                    }
                                ?>
                            </div>
                            <div class="col-sm-12"><br><span>ЗАХИАЛГА</span></div>
                            <div class="col-sm-12">
                                <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(4, -1)'>
                                    Нийт захиалагч: <?= $countAr ?>
                                </div>
                                <div id="too0" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(4, 0)'>
                                    
                                </div>
                                <div id="too1" class="btn btn-success btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(4, 1)'>
                                    
                                </div>
                                <div id="too2" class="btn btn-danger btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(4, 2)'>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1, 100)" placeholder="Захиалгын дугаар ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(2, 100)" placeholder="Захиалагч ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(4, 100)" placeholder="Утасны дугаараар ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <button onclick="ExportToExcel('xlsx')" class="btn btn-success btn-icon-text">Excel файлаар гаргах<i class="ti-file btn-icon-append"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive"  style="height: 50vh">
                            <table id="gal-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Дугаар</th>
                                        <th>Захиалагч</th>
                                        <th>Утас</th>
                                        <!--<th>Дүн</th>-->
                                        <th>Төлөв</th>
                                        <th>Бүтээгдэхүүн</th>
                                        <th>Т/ш</th>
                                        <th>Үнэ</th>
                                        <th>Нийт</th>
                                        <th>Огноо</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 1;
                                    $mt = 1;
                                    $payid = "";
                                    $nerPrint = "";
                                    $totalPrint = "";
                                    $utasPrint = "";
                                    $val = "";
                                    $vale = "";
                                    $valb = "";
                                    if ($countAr > 0) {
                                        while (_fetch($stmtAr)) {
                                            $tval = "<select style='border: 0;' onchange='updateTuluv(this, \"$zidAr\", \"dtuluv\")'";
                                            if($dtuluvAr == '1')
                                            { $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Бэлэн болсон</option><option value='2'>Авсан</option></select>"; }
                                            else if($dtuluvAr == '2') { $tval .= "class='badge badge-danger'><option value='0'>Хүлээгдэж байгаа</option><option value='1'>Бэлэн болсон</option><option value='2' selected>Авсан</option></select>";}
                                            else { $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Бэлэн болсон</option><option value='2'>Авсан</option></select>";}
                                            $sum = $priceAr*$tooAr;
                                            
                                            echo "<tr><td>$t</td>
                                                    <td>$payidAr</td>
                                                    <td>$nerAr</td>
                                                    <td>$utasAr</td>
                                                    <td>$tval</td>
                                                    <td>$pnameAr</td>
                                                    <td>$tooAr</td>
                                                    <td>$priceAr</td>
                                                    <td>$sum</td>
                                                    <td>$tulsunAr</td>
                                                </tr>";
                                            $t++;
                                        }/*
                                            if($t == 1)
                                            {
                                                $payid = $payidAr;
                                                $mt = 0;
                                            }
                                            if($payid == $payidAr)
                                            {
                                                $mt++;
                                            }
                                            else {
                                                if($mt > 1 ) $rs = "rowspan='$mt'";
                                                else $rs = "";
                                                echo $valb . "<td $rs>$payid</td><td $rs>$nerPrint</td><td $rs>$totalPrint</td><td $rs>$utasPrint</td>" .$vale.$val;
                                                $mt = 1;
                                                $val = "";
                                                $vale = "";
                                                $valb = "";
                                            }
                                            
                                            if($mt == 1)
                                            {
                                                $valb .= "<tr><td>$t</td>";
                                                $vale .= "
                                                    <td>$tval</td>
                                                    <td>$pnameAr</td>
                                                    <td>$tooAr</td>
                                                    <td>$priceAr</td>
                                                    <td>$tulsunAr</td>
                                                </tr>";
                                            }
                                            else {
                                                $val .= "
                                                <tr><td>$t</td>
                                                    <td>$tval</td>
                                                    <td>$pnameAr</td>
                                                    <td>$tooAr</td>
                                                    <td>$priceAr</td>
                                                    <td>$tulsunAr</td>
                                                </tr>";
                                            }
                                            $payid = $payidAr;
                                            $nerPrint = $nerAr;
                                            $totalPrint = $totalAr;
                                            $utasPrint = $utasAr;
                                            $t++;
                                        }
                                        if($mt > 1 ) $rs = "rowspan='$mt'";
                                        else $rs = "";
                                        echo $valb . "<td $rs>$payid</td><td $rs>$nerPrint</td><td $rs>$totalPrint</td><td $rs>$utasPrint</td>" .$vale.$val;*/
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
        function Tooloh(){
              let too0 = 0;
              let too1 = 0;
              let too2 = 0;
              var inputs = document.querySelectorAll("select");
              for (var i = 0 ; i < inputs.length ; i++) {
                if(inputs[i].value == 0){
                    too0++;
                }
                else if(inputs[i].value == 1){
                    too1++;
                }
                else too2++;
              }
            document.getElementById("too0").innerHTML = "Хүлээгдэж байгаа: " + too0;
            document.getElementById("too1").innerHTML = "Бэлэн болсон: " + too1;
            document.getElementById("too2").innerHTML = "Авсан: " + too2;
        }
        Tooloh();
        function updateTuluv(element, id, turul)
            {
                var value = element.value;
                $.ajax({
                    url: '/admin/zahialga/updateval',
                    type: 'post',
                    data:{
                        type: "aruinupdate",
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
                Tooloh();
        }
        function updateValue(element, id, turul)
            {
                var value = element.innerText;
                $.ajax({
                    url: '/admin/zahialga/updateval',
                    type: 'post',
                    data:{
                        type: "ariunupdate",
                        turul: turul,
                        id: id,
                        value: value
                    },
                    success: function(php_result)
                    {

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
                XLSX.writeFile(wb, fn || ('АРИУН ХУУДАС - ' + dateTime + '.' + (type || 'xlsx')));
        }

        function tablefilter(val, cl) {
            var input, filter, table, tr, td, i;
            if (val === 1) {
                input = document.getElementById("filterInput");
            } else if (val === 2) {
                input = document.getElementById("filterName");
            } else {
                input = document.getElementById("filterPhone");
            }
            
            if(cl > 99) filter = input.value.toUpperCase();
            else if(cl < 0) filter = 'selected=""';
            else  filter = 'value="'+cl+'" selected=""';
            
            filter = filter.toUpperCase();
            
            table = document.getElementById("gal-listing");
            tr = table.getElementsByTagName("tr");
            var show = true;
            var spannedRows = 0;
            console.log(tr.length);
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[val];
                
                if (spannedRows > 0) {
                    console.log("spannedRows");
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