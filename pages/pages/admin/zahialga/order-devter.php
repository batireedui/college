<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
_select(
    $stmtDevter,
    $countDevter,
    "SELECT orders.payid, orders.id, zovogner, hend, yslol, utas, kod, zproducts.price, itemdevter.id, itemdevter.dtuluv, tulsunognoo FROM `itemdevter` INNER JOIN orders ON itemdevter.orderid = orders.id INNER JOIN zproducts ON itemdevter.zproductid = zproducts.id WHERE tuluvs=? and tuluv = ? order by tulsunognoo DESC",
    "ii",
    ['0', '1'],
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
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Хүслийн дэвтэр</h4>
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
                                <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(7, -1)'>
                                    Нийт захиалагч: <?= $countDevter ?>
                                </div>
                                <div id="too0" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;'  onclick='tablefilter(7, 0)'>
                                    
                                </div>
                                <div id="too1" class="btn btn-success btn-sm" style='margin-left: 10px; margin-top: 10px;'  onclick='tablefilter(7, 1)'>
                                    
                                </div>
                                <div id="too2" class="btn btn-danger btn-sm" style='margin-left: 10px; margin-top: 10px;'  onclick='tablefilter(7, 2)'>
                                    
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
                                    <input type="submit" class="btn btn-danger" name="devterhold" value="Архивлах"/>
                                </div>
                            </form>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1, 100)" placeholder="Захиалгын дугаараар хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(3, 100)" placeholder="Хэний нэр дээр ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(6, 100)" placeholder="Утасны дугаараар хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <button onclick="ExportToExcel('xlsx')" class="btn btn-success btn-icon-text">Excel файлаар гаргах<i class="ti-file btn-icon-append"></i></button>
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
                        type: "devterupdate",
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
                        type: "devterupdate",
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
                XLSX.writeFile(wb, fn || ('Хүслийн дэвтэр-' + dateTime + '.' + (type || 'xlsx')));
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
        }
    </script>