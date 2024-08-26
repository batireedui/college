<?php require ROOT . '/pages/admin/start.php'; 
require ROOT . '/pages/admin/header.php';

function rand_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}
_select(
    $stmtZamd,
    $countZamd,
    "SELECT orders.payid, orders.id, ovog, ner, rd, tursun, gender, medner, tgazar, hayag, utas, facebook, hezee, zproducts.price, itemzamd.id, itemzamd.kod, itemzamd.dtuluv, sms FROM `itemzamd` INNER JOIN orders ON itemzamd.orderid = orders.id INNER JOIN zproducts ON itemzamd.zproductid = zproducts.id WHERE tuluvs=? and tuluv = ? ORDER BY hezee DESC",
    "ii",
    ['0', '1'],
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
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ЗАМД ОРОХ ЁСЛОЛ</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="btn btn-primary btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(4, -1)'>
                                    Нийт захиалагч: <?= $countZamd ?>
                                </div>
                                <div id="too0" class="btn btn-warning btn-sm" style='margin-left: 10px; margin-top: 10px;' onclick='tablefilter(4, 0)'>
                                    
                                </div>
                                <div id="too1" class="btn btn-success btn-sm" style='margin-left: 10px; margin-top: 10px;'  onclick='tablefilter(4, 1)'>
                                    
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
                                    <input type="submit" class="btn btn-danger" name="zamdhold" value="Архивлах"/>
                                </div>
                            </form>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1, 100)" placeholder="Захиалгын дугаараар хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(7, 100)" placeholder="Нэрээр хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(14, 100)" placeholder="Утасны дугаараар хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <button onclick="ExportToExcel('xlsx')" class="btn btn-success btn-icon-text">Excel файлаар гаргах<i class="ti-file btn-icon-append"></i></button>
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
                                        <th>Төрсөн</th>
                                        <th>Нас</th>
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
                                    $color = rand_color();
                                    if ($countZamd > 0) {
                                        while (_fetch($stmtZamd)) {
                                            $nas = 0;
                                            $dob = new DateTime($tursunZamd);
                                            $today   = new DateTime('today');
                                            $nas = $dob->diff($today)->y;
                                            $tval = "<select onchange='updateTuluv(this, \"$itemidZamd\", \"dtuluv\")'";
                                            if($dtuluvZamd == '1') $tval .= "class='badge badge-success'><option value='0'>Хүлээгдэж байгаа</option><option value='1' selected>Орсон</option></select>";
                                            else $tval .= "class='badge badge-warning'><option value='0' selected>Хүлээгдэж байгаа</option><option value='1'>Орсон</option></select>";
                                            echo "<tr>
                                                    <td>$t</td>
                                                    <td class='fix'>$payidZamd</td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"kod\")' contenteditable>$kodZamd</div></td>
                                                    <td><div class='badge badge-info' style='cursor: pointer' onclick='sendsms($itemidZamd)'>SMS: $smsZamd</div></td>
                                                    <td>$tval</td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"hezee\")' contenteditable>$hezeeZamd</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"ovog\")' contenteditable>$ovogZamd</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"ner\")' contenteditable>$nerZamd</div></td>
                                                    
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"tursun\")' contenteditable>$tursunZamd</div></td>
                                                    <td><div>$nas</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"gender\")' contenteditable>$genderZamd</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"medner\")' contenteditable>$mednerZamd</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"tgazar\")' contenteditable>$tgazarZamd</div></td>
                                                    
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"utas\")' contenteditable>$utasZamd</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"facebook\")' contenteditable>$facebookZamd</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"hayag\")' contenteditable>$hayagZamd</div></td>
                                                    <td><div class='editcell' onblur='updateValue(this, \"$itemidZamd\", \"rd\")' contenteditable>$rdZamd</div></td>
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
        function Tooloh(){
              let too0 = 0;
              let too1 = 0;
              var inputs = document.querySelectorAll("select");
              for (var i = 0 ; i < inputs.length ; i++) {
                if(inputs[i].value == 0){
                    too0++;
                }
                else too1++;
              }
            document.getElementById("too0").innerHTML = "Хүлээгдэж байгаа: " + too0;
            document.getElementById("too1").innerHTML = "Орсон: " + too1;
        }
        Tooloh();
        function updateTuluv(element, id, turul)
            {
                var value = element.value;
                $.ajax({
                    url: '/admin/zahialga/updateval',
                    type: 'post',
                    data:{
                        type: "zamdupdate",
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
                        type: "zamdupdate",
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
                XLSX.writeFile(wb, fn || ('ЗАМД ОРОХ ЁСЛОЛ-' + dateTime + '.' + (type || 'xlsx')));
        }
        
        function tablefilter(val, cl) {
            var input, filter, table, tr, td, i;
            if (val === 1) {
                input = document.getElementById("filterInput");
            } else if (val === 7) {
                input = document.getElementById("filterName");
            } else {
                input = document.getElementById("filterPhone");
            }
            if(cl > 99) filter = input.value.toUpperCase();
            else if(cl < 0) filter = 'selected=""';
            else  filter = 'value="'+cl+'" selected=""';

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
                    if (td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    let rs = td.getAttribute("rowspan");
                    if (rs && rs > 1) {
                        show = td.innerHTML.toUpperCase().indexOf(filter.toUpperCase()) > -1;
                        spannedRows = rs - 1;
                    }
                }
            }
        }
    </script>