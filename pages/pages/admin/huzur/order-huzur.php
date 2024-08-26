<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
_select(
    $stmtH,
    $countH,
    "SELECT orders.payid, orders.id, itemhuzur.id, huzurcagid, ner, facebook, itemhuzur.dun, itemhuzur.hezee, itemhuzur.dtuluv, huzurcag.hezee, huzurteacher.name, huzurteacher.utas, itemhuzur.utas, huzurcag.link, huzurcag.huzurtypeid, itemhuzur.tursun FROM `itemhuzur` INNER JOIN orders ON itemhuzur.orderid = orders.id INNER JOIN huzurcag ON huzurcagid = huzurcag.id INNER JOIN huzurteacher ON huzurcag.teachid = huzurteacher.id WHERE orders.tuluv = ? order by huzurcag.hezee desc",
    "i",
    ['1'],
    $payidH,
    $oidH,
    $itemidH,
    $huzurcagidH,
    $nerH,
    $faceH,
    $dunH,
    $hezeeH,
    $dtuluvH,
    $cagH,
    $teachNameH,
    $teachUtasH,
    $utasH,
    $linkH,
    $huzurtypeid,
    $tursun
);
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ХӨЗӨР ЦАГ</h4>
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
                            <div class="col-sm-12">
                                <div id="toot1" class="btn btn-outline-danger btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                </div>
                                <div id="toot2" class="btn btn-outline-danger btn-sm" style='margin-left: 10px; margin-top: 10px;'>
                                    
                                </div>
                            </div>
                        </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick="tablefilter(2, -1)">
                                    Нийт захиалагч: <?= $countH ?>
                                </div>
                                <div id="too0" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick="tablefilter(2, 0)">
                                    
                                </div>
                                <div id="too1" class="btn btn-success btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick="tablefilter(2, 1)">
                                    
                                </div>
                                <div id="too2" class="btn btn-danger btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick="tablefilter(2, 2)">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1, 100)" placeholder="Захиалгын дугаар ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(2, 100)" placeholder="Хэний нэр дээр ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(4, 100)" placeholder="Утасны дугаараар ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <button onclick="ExportToExcel('xlsx')" class="btn btn-success btn-icon-text">Excel файлаар гаргах<i class="ti-file btn-icon-append"></i></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="gal-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Дугаар</th>
                                        <th>Төлөв</th>
                                        <th>Авсан цаг</th>
                                        <th>Захиалагчийн овог, нэр</th>
                                        <th>Фэйсбүүк</th>
                                        <th>Төрсөн</th>
                                        <th>Утас</th>
                                        <th>Багш</th>
                                        <th>Багш утас</th>
                                        <th>Захиалсан</th>
                                        <th>Дүн</th>
                                        <th>Төрөл</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 1;
                                    if ($countH > 0) {
                                        while (_fetch($stmtH)) {
                                            $huzurtypener = "Амьдралын зөвлөгөө";
                                            if($huzurtypeid == "1") $huzurtypener = "Таван махбодь";
                                            else if($huzurtypeid == "2") $huzurtypener = "Өвөг дээдсийн хөзөр";
                                            $tval = "<select style='border: 0;' onchange='updateTuluv(this, \"$itemidH\", \"dtuluv\")'";
                                            if($dtuluvH == '1') $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Үзсэн</option><option value='2'>Үзээгүй</option></select>";
                                            else if($dtuluvH == '2') $tval .= "class='badge badge-danger'><option value='0'>Хүлээгдэж байгаа</option><option value='1'>Үзсэн</option><option value='2' selected>Үзээгүй</option></select>";
                                            else $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Үзсэн</option><option value='2'>Үзээгүй</option></select>";
                                            echo "<tr>
                                                    <td>$t</td>
                                                    <td>$payidH</td>
                                                    <td>$tval</td>
                                                    <td>$cagH</td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidH\", \"ner\")' contenteditable>$nerH</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidH\", \"facebook\")' contenteditable>$faceH</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidH\", \"tursun\")' contenteditable>$tursun</div></td>
                                                    <td>$utasH</td>
                                                    <td>$teachNameH</td>
                                                    <td>$teachUtasH</td>
                                                    <td>$hezeeH</td>
                                                    <td>$dunH</td>
                                                    <td>$huzurtypener <br>$linkH</td>
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
            document.getElementById("too1").innerHTML = "Үзсэн: " + too1;
            document.getElementById("too2").innerHTML = "Үзээгүй: " + too2;
        }
        function ToolohType(){
            let too1 = 0, too2 = 0, table, tr, td, filter = "Өвөг дээдсийн хөзөр";
            table = document.getElementById("gal-listing");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[12];
                if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
                        if(tr[i].style.display == "")
                        too1++;
                    } else {
                        if(tr[i].style.display == "")
                        too2++;
                    }
                }
            }
            document.getElementById("toot1").innerHTML = "Өвөг дээдсийн хөзөр: " + too1;
            document.getElementById("toot2").innerHTML = "Таван махбодь : " + too2;
        }
        Tooloh();
        ToolohType();
        function updateTuluv(element, id, turul)
            {
                var value = element.value;
                $.ajax({
                    url: '/admin/huzur/updateHuzur',
                    type: 'post',
                    data:{
                        type: "huzurtuluvupdate",
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
                    url: '/admin/huzur/updateHuzur',
                    type: 'post',
                    data:{
                        type: "huzurupdate",
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
                XLSX.writeFile(wb, fn || ('Хөзөр цаг - ' + dateTime + '.' + (type || 'xlsx')));
        }
        
        function tablefilter(val, cl) {
            var input, filter, table, tr, td, i;
            if (val === 1) {
                input = document.getElementById("filterInput");
            } else if (val === 3) {
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
            ToolohType();
        }

    </script>