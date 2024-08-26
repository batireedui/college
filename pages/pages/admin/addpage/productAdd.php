<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$action = 'productadd';
$id = "";
$title = "БҮТЭЭГДЭХҮҮН НЭМЭХ";
$tuluv = "";
if (isset($_GET['id']) != null) {
    $title = "БҮТЭЭГДЭХҮҮН ЗАСВАРЛАХ";
    $action = 'productupdate';
    $id = $_GET['id'];
    _selectRow(
        "SELECT name, jpname, price, too, uld, imgurl, medeelel, cateid, tuluv, productsub, turul FROM products WHERE id =?",
        "i",
        [$_GET['id']],
        $name,
        $namejpn,
        $price,
        $too,
        $uldtuluv,
        $imgurl,
        $medeelel,
        $cateidf,
        $tuluv,
        $productsub,
        $turul
    );
} else {
    $name = "";
    $price = "";
    $namejpn="";
    $too = "";
    $imgurl = "";
    $medeelel = "";
    $cateidf = "";
    $tuluv = "";
    $uldtuluv = "";
    $productsub = "";
    $turul = "";
}

if (isset($_GET['id']) == '12') {
    _selectNoParam(
        $st,
        $count,
        "SELECT id, hezee FROM zamdognoo",
        $zid,
        $hezee
    );
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title"><?= $title ?></p>
                        <form action="/admin/record/new" method="POST">
                            <div class="modal-body">
                                <?php
                                _selectNoParam(
                                    $cstmt,
                                    $ccount,
                                    "SELECT id, name FROM category",
                                    $cateid,
                                    $catename
                                );
                                ?>
                                <label>Бүтээгдэхүүний ангилал</label>
                                <select class="form-control" name="cateid" id="selectedcate" onchange="selectcate(this.value)">
                                    <?php
                                    while (_fetch($cstmt)) {
                                        echo "<option value=" . $cateid;
                                        echo $cateid == $cateidf ? " selected>" : ">";
                                        echo $catename . "</option>";
                                    }

                                    ?>
                                </select><br>
                                <input style="display: none" name="proIDedit" id="proIDedit" type="text" value="<?= $id ?>" />
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="proname">Бүтээгдэхүүний нэр /Монгол/</label>
                                        <input class="form-control" name="proname" id="proname" type="text" value="<?= $name ?>" placeholder="Монголоор" /><br>
                                    </div>
                                    <div class="col">
                                        <label for="proname">Бүтээгдэхүүний нэр /Япон/</label>
                                        <input class="form-control" name="pronamejpn" id="pronamejpn" type="text" value="<?= $namejpn ?>" placeholder="Япон" /><br>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="proprice">Бүтээгдэхүүний үнэ /₮/</label>
                                        <input class="form-control" name="proprice" id="proprice" type="number" value="<?= $price ?>" placeholder="Зөвхөн тоо оруулна" />
                                    </div>
                                    <div class="col">
                                        <label for="protoo">Бүтээгдэхүүний үлдэгдэл</label>
                                        <input class="form-control" name="protoo" id="protoo" type="number" value="<?= $too ?>" placeholder="Зөвхөн тоо оруулна" />
                                    </div>
                                </div>
                                <label for="tit">Бүтээгдэхүүний зураг сонгох</label>
                                <div style="flex-direction: row;flex-wrap: unset;display: flex;">
                                    <input id="imgurl" class="form-control" name="imgurl" type="text" value="<?= $imgurl ?>" readonly>
                                    <input type="button" id="ckfinder-popup-1" class="btn btn-success" value="Зураг">
                                </div><br>
                                <div class="form-group row">
                                    <div class="form-check form-check-flat" style="margin-left: 50px;">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-control" id="ctuluv" name="ctuluv" <?php echo $tuluv == "1" ? "checked" : ""; ?>>
                                            Идэвхтэй эсэх (Дэлгэцэнд харуулах эсэх)
                                            <i class="input-helper"></i></label>
                                    </div>
                                    <div class="form-check form-check-flat" style="margin-left: 50px;">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="form-control" id="uldtuluv" name="uldtuluv" <?php echo $uldtuluv == "1" ? "checked" : ""; ?>>
                                            Үлдэгдэл тооцох эсэх
                                            <i class="input-helper"></i></label>
                                    </div>
                                </div>
                                <div id="avralshow" style="display: none">
                                    <label for="tit">Авралын төрөл</label>
                                    <div class="form-group row">
                                        <div class="form-check form-check-flat" style="margin-left: 50px;">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-control" id="galtogt" name="aturul" onclick="songoClick()" value="togt" <?php echo $turul == "togt" ? "checked" : ""; ?>>
                                                Тогтсон авралтай
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-flat" style="margin-left: 50px; display: none">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-control" id="galhusel" name="aturul" onclick="songoClick()" value="husel" <?php echo $turul == "husel" ? "checked" : ""; ?>>
                                                Хувийн хүсэлттэй
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-flat" style="margin-left: 50px; display: none">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-control" id="galsongoh" name="aturul" onclick="songoClick()" value="song" <?php echo $turul == "song" ? "checked" : ""; ?>>
                                                Сонгох авралтай
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-flat" style="margin-left: 50px;">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-control" id="galsonghusel" name="aturul" onclick="songoClick()" value="songhusel" <?php echo $turul == "songhusel" ? "checked" : ""; ?>>
                                                Сонгох болон Хувийн хүсэлттэй
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div id="songohlist" style="display: none">
                                    
                                    </div>
                                    
                                    <div id="divhuseltlist" style="display: none">
                                        
                                    </div>
                                </div>
                                <div id="suvargashow" style="display: none">
                                    <label for="tit">Суварганы төрөл</label>
                                    <div class="form-group row">
                                        <div class="form-check form-check-flat" style="margin-left: 50px;">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-control" id="suvargahuselt" name="aturul" value="suvargahuselt" onclick="suvargaClick()" <?php echo $turul == "suvargahus" ? "checked" : ""; ?>>
                                                Хүсэлт, аврал бичих
                                                <i class="input-helper"></i></label>
                                        </div>
                                        <div class="form-check form-check-flat" style="margin-left: 50px;">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-control" id="suvargaded" name="aturul" value="suvargaded" onclick="suvargaClick()" <?php echo $turul == "suvargaded" ? "checked" : ""; ?>>
                                                Дэд суваргатай
                                                <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                     <div id="suvargadedlist" style="display: none">
                                    
                                    </div>
                                    
                                    <div id="suvargahuseltlist" style="display: none">
                                        <input type="text" class="form-control" style="margin: 0px 30px 0px 30px; width: 90%;" name="suvargahuselttile" placeholder="Энд тайлбараа оруулна уу." value="<?=$productsub; ?>">
                                    </div>
                                </div>
                               
                                <div id="zamdcag">
                                    <div class="form-group row">
                                        <div class="col">
                                            <label for="">Ёслолын огноо</label>
                                            <input type="date" class="form-control" id="zamdognoo" name="ognoo" />
                                        </div>
                                        <div class="col">
                                            <label for="">Ёслолын цаг</label>
                                            <select class="form-control" name="cag" id="cag">
                                                <option>08</option>
                                                <option>09</option>
                                                <option>10</option>
                                                <option>11</option>
                                                <option>12</option>
                                                <option>13</option>
                                                <option>14</option>
                                                <option>15</option>
                                                <option>16</option>
                                                <option>17</option>
                                                <option>18</option>
                                                <option>19</option>
                                                <option>20</option>
                                                <option>21</option>
                                                <option>22</option>
                                                <option>23</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <label for="">Минут</label>
                                            <select class="form-control" name="min" id="zamdmin">
                                                <option>00</option>
                                                <option>05</option>
                                                <option>10</option>
                                                <option>15</option>
                                                <option>20</option>
                                                <option>25</option>
                                                <option>30</option>
                                                <option>35</option>
                                                <option>40</option>
                                                <option>45</option>
                                                <option>50</option>
                                                <option>55</option>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <br>
                                            <input type="button" class="btn btn-success" name="zamdcagadd" value="Нэмэх" onclick="ognooadd()"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col">
                                            <table class="table table-striped">
                                                <tr>
                                                <td>Огноо</td>
                                                <td>#</td>
                                                </tr>
                                            <tbody id="ognoolist">
                                            <?php
                                            if ($count > 0) {
                                                while (_fetch($st))
                                                    echo "<tr><td>$hezee</td><td><button type='button' class='btn btn-danger btn-sm' onclick='ognoodelete(\"$zid\")'>Устгах</button></td></tr>";
                                            }
                                            else
                                            {
                                                echo "<tr><td style='color: red; text-align:center'>Цагийн хуваарь оруулаагүй байна</td></tr>";
                                            }
                                            ?>
                                            </tbody></table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <label for="tit">Бүтээгдэхүүний тайлбар</label>
                                <textarea id="editmedeelel" name="medeelel"><?= $medeelel ?></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="<?= $action ?>">Хадгалах</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <?php require ROOT . '/pages/admin/footer.php'; ?>

            <script src="https://cdn.ckeditor.com/ckeditor5/12.4.0/classic/ckeditor.js"></script>
            <script src="/ckfinder/ckfinder.js"></script>
            <script type="text/javascript">
                let actype = "<?=$action?>";
                function filtersongochoose(val, list) {
                    var keyword = document.getElementById(val).value;
                    var select = document.getElementById(list);
                    for (var i = 0; i < select.length; i++) {
                        var txt = select.options[i].text;
                        if (!txt.match(keyword)) {
                            $(select.options[i]).attr('disabled', 'disabled').hide();
                        } else {
                            $(select.options[i]).removeAttr('disabled').show();
                        }
            
                    }
                }
                
                function addsubid(val){
                    $.ajax({
                        url: '/admin/addpage/productSubIdAction',
                        type: 'POST',
                        data: jQuery.param({
                            type: "addsubid",
                            subid: val,
                            pid: '<?=$id?>'
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        success: function(detialres) {
                            console.log(detialres);
                                songoAjax();
                        },
                        error: function(deterr) {
                            songoAjax();
                        }
                    });
                }
                function removesubid(val){
                    console.log(val);
                    $.ajax({
                        url: '/admin/addpage/productSubIdAction',
                        type: 'POST',
                        data: jQuery.param({
                            type: "removeid",
                            id: val
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        success: function(detialres) {
                                songoAjax();
                        },
                        error: function(deterr) {
                            songoAjax();
                        }
                    });
                }
                selectcate(document.getElementById("selectedcate").value);
                if(actype==="productupdate"){
                    if(document.getElementById("galtogt").checked || document.getElementById("galsonghusel").checked || document.getElementById("galhusel").checked) {
                        songoClick();
                    }
                    else if(document.getElementById("suvargahuselt").checked || document.getElementById("suvargaded").checked)
                    {
                        suvargaClick();
                    }
                }
                function selectcate(val) {
                    console.log(val);
                    if (val === "11" || val === "14") {
                        $('#avralshow').css("display", "");
                        $('#zamdcag').css("display", "none");
                        $('#suvargashow').css("display", "none");
                    } else if (val === "12" && actype==="productupdate") {
                        $('#zamdcag').css("display", "");
                        $('#avralshow').css("display", "none");
                        $('#suvargashow').css("display", "none");
                    } else if (val === "5" && actype==="productupdate") {
                        $('#suvargashow').css("display", "");
                         $('#zamdcag').css("display", "none");
                        $('#avralshow').css("display", "none");
                    }
                    else {
                        $('#avralshow').css("display", "none");
                        $('#zamdcag').css("display", "none");
                        $('#suvargashow').css("display", "none");
                    }
                    
                };
                function suvargaClick(){
                    if(actype==="productupdate"){
                        if(document.getElementById("suvargaded").checked) {
                            $('#suvargadedlist').css("display", "");
                            $('#suvargahuseltlist').css("display", "none");
                        }
                        else if(document.getElementById("suvargahuselt").checked) {
                            $('#suvargahuseltlist').css("display", "");
                            $('#suvargadedlist').css("display", "none");
                        }
                        else{
                            $('#suvargahuseltlist').css("display", "none");
                            $('#suvargadedlist').css("display", "none");
                        }
                    }
                    else{
                       $('#suvargahuseltlist').css("display", "none");
                       $('#suvargadedlist').css("display", "none");
                    }
                }
                function songoClick(){
                    if(actype==="productupdate"){
                        if(document.getElementById("galtogt").checked) {
                            $('#songohlist').css("display", "");
                            $('#divhuseltlist').css("display", "none");
                        }
                        else if(document.getElementById("galsonghusel").checked) {
                            $('#songohlist').css("display", "");
                            $('#divhuseltlist').css("display", "");
                        }
                        else if(document.getElementById("galhusel").checked) {
                            $('#songohlist').css("display", "none");
                            $('#divhuseltlist').css("display", "");
                        }
                        else{
                            $('#songohlist').css("display", "none");
                            $('#divhuseltlist').css("display", "none");
                        }
                    }
                    else{
                        $('#songohlist').css("display", "none");
                        $('#divhuseltlist').css("display", "none");
                    }
                }
                songoAjax();
                function songoAjax() {
                       $.ajax({
                        url: '/admin/addpage/galSongoList',
                        type: 'POST',
                        data: jQuery.param({
                            post: "select",
                            id: '<?=$id?>'
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        success: function(detialres) {
                                $('#songohlist').html("<h3 style='margin-top: 25px;'>Сонгох аврал нэмэх</h3>"+detialres);
                        },
                        error: function(deterr) {
                            console.log(deterr);
                        }
                    });
                    $.ajax({
                        url: '/admin/addpage/galHuseltList',
                        type: 'POST',
                        data: jQuery.param({
                            post: "select",
                            id: '<?=$id?>'
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        success: function(detialres) {
                                $('#divhuseltlist').html("<h3 style='margin-top: 25px;'>Хувийн хүсэлт нэмэх</h3>"+detialres);
                        },
                        error: function(deterr) {
                            console.log(deterr);
                        }
                    });
                    $.ajax({
                        url: '/admin/addpage/suvargaDedList',
                        type: 'POST',
                        data: jQuery.param({
                            post: "select",
                            id: '<?=$id?>'
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        success: function(detialres) {
                                $('#suvargadedlist').html("<h3 style='margin-top: 25px;'>Дэд суварга нэмэх</h3>"+detialres);
                        },
                        error: function(deterr) {
                            console.log(deterr);
                        }
                    });
                };
                function ognoodelete(id) {
                    console.log(id);
                       $.ajax({
                        url: '/admin/record/new',
                        type: 'POST',
                        data: jQuery.param({
                            zamdogoodelete: "zamdogoodelete",
                            id: id
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        success: function(detialres) {
                            if(detialres=="nodata"){
                                $('#ognoolist').html("<tr><td style='color: red; text-align:center'>Цагийн хуваарь оруулаагүй байна</td></tr>");
                            }
                            else
                            {
                                let json = JSON.parse(detialres);
                                let ht = "";
                                json.map((el) => {
                                    ht += "<tr><td>"+el.hezee+"</td><td><button type='button' class='btn btn-danger btn-sm' onclick='ognoodelete(\""+el.id+"\")'>Устгах</button></td></tr>";
                                });
    
                                $('#ognoolist').html(ht);
                            }
                        },
                        error: function(deterr) {
                            console.log(deterr);
                        }
                    });
                };
                function ognooadd() {
                    
                    let ognoo = document.getElementById("zamdognoo").value;
                    let cag = document.getElementById("cag").value;
                    let min = document.getElementById("zamdmin").value;
                    ognoo = ognoo+"";
                    console.log(ognoo);
                    if(ognoo.length > 0){
                       ognoo = ognoo+" "+cag+":"+min+":00";
                       $.ajax({
                        url: '/admin/record/new',
                        type: 'POST',
                        data: jQuery.param({
                            zamdogooadd: "zamdogooadd",
                            ognoo: ognoo
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        success: function(detialres) {
                            let json = JSON.parse(detialres);
                            let ht = "";
                            json.map((el) => {
                                ht += "<tr><td>"+el.hezee+"</td><td><button type='button' class='btn btn-danger btn-sm' onclick='ognoodelete(\""+el.id+"\")'>Устгах</button></td></tr>";
                            });

                            $('#ognoolist').html(ht);
                        },
                        error: function(deterr) {
                            console.log(deterr);
                        }
                    })
                }
                    else
                    {
                        alert("Огноогоо сонгоно уу!");   
                    }
                    /**/
                    
                };
                let EditEditor;
                ClassicEditor
                    .create(document.querySelector('#editmedeelel'), {
                        ckfinder: {
                            uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
                        },
                        toolbar: ['ckfinder', 'imageUpload', '|',
                            'heading', '|',
                            'fontfamily', 'fontsize', '|',
                            'alignment', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'subscript', 'superscript', '|',
                            'link', '|',
                            'outdent', 'indent', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'code', 'codeBlock', '|',
                            'insertTable', '|',
                            'uploadImage', 'blockQuote', '|',
                            'undo', 'redo'
                        ]
                    })
                    .then(ed => {
                        EditEditor = ed;
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
                let button1 = document.getElementById('ckfinder-popup-1');
                button1.onclick = function() {
                    selectFileWithCKFinder('imgurl');
                };

                function selectFileWithCKFinder(elementId) {
                    CKFinder.popup({
                        chooseFiles: true,
                        width: 800,
                        height: 600,
                        onInit: function(finder) {
                            finder.on('files:choose', function(evt) {
                                let file = evt.data.files.first();
                                let output = document.getElementById(elementId);
                                output.value = file.getUrl();
                            });

                            finder.on('file:choose:resizedImage', function(evt) {
                                var output = document.getElementById(elementId);
                                output.value = evt.data.resizedUrl;
                            });
                        }
                    });
                }
            </script>
            <?php require ROOT . '/pages/admin/end.php'; ?>