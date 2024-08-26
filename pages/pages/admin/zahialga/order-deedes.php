<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
_select(
    $stmtDeedes,
    $countDeedes,
    "SELECT orders.payid, orders.id, UPPER(zner), UPPER(hend), utas, zognoo, handiv, zproducts.price, itemdeedes.id, itemdeedes.dtuluv, itemdeedes.too, ymar FROM `itemdeedes` INNER JOIN orders ON itemdeedes.orderid = orders.id INNER JOIN zproducts ON itemdeedes.zproductid = zproducts.id WHERE orders.tuluv = ? and tuluvs = ? ORDER BY zner, orders.id ASC",
    "ii",
    ['1', '0'],
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
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ӨВӨГ ДЭЭДСИЙН ЁСЛОЛ</h4>
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
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(2, -1)'>
                                    Нийт захиалагч: <?= $countDeedes ?>
                                </div>
                                <div id="too0" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(2, 0)'>
                                    
                                </div>
                                <div id="too1" class="btn btn-success btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(2, 1)'>
                                    
                                </div>
                                <div id="too3" class="btn btn-danger btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(2, 2)'>
                                    
                                </div>
                                <div id="too2" class="btn btn-danger btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                    
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <form onsubmit="return submitForm(this);" method="POST" action="/admin/zahialga/hold">
                                <input type="date" name="date1" id="date1" class="form-control" value="<?php echo date('Y-m-d');?>"/>
                            </div>
                            <div class="col-sm-2">
                                <input type="date" name="date2" id="date2" class="form-control" value="<?php echo date('Y-m-d');?>"/>
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" class="btn btn-danger" name="deedeshold" value="Архивлах"/>
                            </div>
                            </form>
                        </div>
                        <div class="row" style="margin-top: 20px">
                            <div class="col-sm-1" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1, 100)" placeholder="З/дугаар">
                            </div>
                            <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(4, 100)" placeholder="Хэний нэр дээр ...">
                            </div>
                            <div class="col-sm-2" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(5, 100)" placeholder="Утасны дугаараар хайх">
                            </div>
                            <div class="col-sm-2">
                                <input type="date" id="fdate1" class="form-control" value="<?php echo date('Y-m-d');?>"/>
                            </div>
                            <div class="col-sm-2">
                                <input type="date" id="fdate2" class="form-control" value="<?php echo date('Y-m-d');?>"/>
                            </div>
                            <div class="col-sm-1">
                                <input type="button" class="btn btn-warning" onclick="filterDate()" value="ШҮҮХ"/>
                            </div>
                            <div class="col-sm-1">
                                <input type="button" class="btn btn-warning" onclick="filterCancel()" value="ШҮҮЛТ БОЛИХ"/>
                            </div>
                            <div class="col-sm-1" style="display: flex; justify-content: flex-end;">
                                <button onclick="ExportToExcel('xlsx')" class="btn btn-success">Excel</button>
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
                                        <th>Утас</th>
                                        <th>Хэдэн удаа</th>
                                        <th>Хандив</th>
                                        <th>Дүн</th>
                                        <th>Огноо</th>
                                        <th>Төрөл</th>
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
                                            else { $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Илгээгдсэн</option><option value='2'>Баталгаажсан</option></select>"; }
                                            echo "<tr>
                                                    <td>$t</td>
                                                    <td>$payidDeedes</td>
                                                    <td>$tval</td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidDeedes\", \"zner\")' contenteditable>$znerDeedes</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidDeedes\", \"hend\")' contenteditable>$hendDeedes</div></td>
                                                    <td>$utasDeedes</td>
                                                    <td class='toonuud'>$tooDeedes</td>
                                                    <td>$handivDeedes</td>
                                                    <td>$priceDeedes</td>
                                                    <td>$zognooDeedes</td>
                                                    <td>$ymar</td>
                                                </tr>";
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
        function submitForm() {
            let d1 = document.getElementById("date1").value;    
            let d2 = document.getElementById("date2").value;
            let text = d1 + "-ний өдрөөс " + d2 + " өдөр хүртэлх захиалгуудыг АРХИВТ хадгалах уу?";
            return confirm(text);
        }
        function updateTuluv(element, id, turul)
            {
                var value = element.value;
                $.ajax({
                    url: '/admin/zahialga/updateval',
                    type: 'post',
                    data:{
                        type: "deedesupdate",
                        turul: turul,
                        id: id,
                        value: value
                    },
                    success: function(php_result)
                    {
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
                        type: "deedesupdate",
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
                XLSX.writeFile(wb, fn || ('Өвөг дээдсийн ёслол-' + dateTime + '.' + (type || 'xlsx')));
        }
        
        function Tooloh(){
              let too0 = 0;
              let too1 = 0;
              let too3 = 0;
              var inputs = document.querySelectorAll("select");
              for (var i = 0 ; i < inputs.length ; i++) {
                if(inputs[i].value == 0){
                    too0++;
                }
                else if(inputs[i].value == 2){
                    too3++;
                }
                else too1++;
              }
              document.getElementById("too0").innerHTML = "Хүлээгдэж байгаа: " + too0;
              document.getElementById("too1").innerHTML = "Илгээгдсэн: " + too1;
              document.getElementById("too3").innerHTML = "Баталгаажсан: " + too3;
              let too2 = 0;
              var inputs = document.querySelectorAll(".toonuud");
              for (var i = 0 ; i < inputs.length ; i++) {
                too2 += parseInt(inputs[i].innerHTML);
              }
              document.getElementById("too2").innerHTML = "Сүнсний тоо: " + too2;
        }
        Tooloh();
        function filterCancel(){
            var table, tr, i;
            
            table = document.getElementById("gal-listing");
            
            tr = table.getElementsByTagName("tr");

            for (i = 0; i < tr.length; i++) {
                tr[i].style.display = "";
            }
        }
        function filterDate(){
            var input, filter, table, tr, td, i;

            let startDate = new Date(document.getElementById("fdate1").value);
            let stopDate = new Date(document.getElementById("fdate2").value);
            
            table = document.getElementById("gal-listing");
            
            tr = table.getElementsByTagName("tr");
            
            var show = true;
            var spannedRows = 0;

            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td");
                if (!td || !td[2]) continue;
                let td_date = new Date(td[9].innerHTML);
                
                if (spannedRows > 0) {
                    if (show)
                        tr[i].style.display = "";
                    else
                        tr[i].style.display = "none";
                    spannedRows--;
                } else if (td) {
                    if (td_date >= startDate && td_date <= stopDate) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    
                    let rs = td[9].getAttribute("rowspan");
                    if (rs && rs > 1) {
                        show = (td_date >= startDate && td_date <= stopDate);
                        spannedRows = rs - 1;
                    }
                }
            }
        }
        function tablefilter(val, cl) {
            var input, filter, table, tr, td, i;
            if (val === 1) {
                input = document.getElementById("filterInput");
            } else if (val === 4) {
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