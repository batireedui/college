<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$columnNumber = 5;

_select(
    $ostmt,
    $ocount,
    "SELECT id, name FROM office WHERE tuluv=?",
    "i",
    [1],
    $oid,
    $oname
);

_select(
    $dstmt,
    $dcount,
    "SELECT id, name FROM department WHERE tuluv=?",
    "i",
    [1],
    $did,
    $dname
);

_select(
    $atstmt,
    $atcount,
    "SELECT id, name FROM at WHERE tuluv=?",
    "i",
    [1],
    $atid,
    $atname
);

$oarray = array();
$darray = array();
$atarray = array();

while (_fetch($ostmt)) {
    $orow = new stdClass();
    $orow->oid = $oid;
    $orow->oname = $oname;
    array_push($oarray, $orow);
}

while (_fetch($dstmt)) {
    $orow = new stdClass();
    $orow->did = $did;
    $orow->dname = $dname;
    array_push($darray, $orow);
}

while (_fetch($atstmt)) {
    $atrow = new stdClass();
    $atrow->atid = $atid;
    $atrow->atname = $atname;
    array_push($atarray, $atrow);
}
?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
    #upload_file {
        display: none;
    }
</style>
<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h3>Багшийн бүртгэл</h3>
        <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#add">БҮРТГЭХ</button>
    </div>

    <div id="table">

    </div>

    <div class="modal fade" id="change" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLabel">Багш засах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" value="0" id="t_id" readonly style="display: none;" />
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="fname" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="fname">Эцэг/эхийн нэр*</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="lname" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="lname">Багшийн нэр*</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="phone" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="phone">Утас*</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="email" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="email">E-mail</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="at" class="form form-control" placeholder="Мэдээллийн технологийн багш" />
                                <label class="form-label" for="at">Албан тушаал</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="office">Алба*</label>
                            <select class="form form-control mb-3" id="office">
                                <?php foreach ($oarray as $el) { ?>
                                    <option value="<?= $el->oid ?>"><?= $el->oname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label" for="defartment">Хэлтэс*</label>
                            <select class="form form-control mb-3" id="defartment">
                                <?php foreach ($darray as $el) { ?>
                                    <option value="<?= $el->did ?>"><?= $el->dname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="user_role">Төрөл*</label>
                            <select class="form form-control mb-3" id="user_role">
                                <?php foreach ($atarray as $el) { ?>
                                    <option value="<?= $el->atid ?>"><?= $el->atname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label" for="tuluv">Төлөв*</label>
                            <select class="form form-control mb-3" id="tuluv">
                                <option value="1">Ажиллаж байгаа</option>
                                <option value="2">Гарсан</option>
                            </select>
                        </div>
                    </div>
                    <div id="changeinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" onclick="editTeacher()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imagechange" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLabel">Багш зураг солих</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3 text-center">
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-outline mb-3">
                                    <input type="text" value="" id="pfname" class="form form-control mb-3" autocomplete="FALSE" readonly/>
                                    <label class="form-label" for="pfname">Эцэг/эхийн нэр*</label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-outline mb-3">
                                    <input type="text" value="" id="plname" class="form form-control mb-3" autocomplete="FALSE" readonly/>
                                    <label class="form-label" for="plname">Багшийн нэр*</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <img id="pro" src="/images/image.jpg" style="width: 300px;height: 200px;object-fit: cover;border: solid;margin: auto" />
                            <br>
                            <progress id="progress_bar" value="0" max="100" style="width:300px;"></progress>
                            <p id="progress_status"></p>
                            <label for="upload_file" class="custom-file-upload btn btn-primary mb-1"> Зураг сонгох</label>
                            <input class="form form-control margin" type="file" class="form form-control" formnovalidate id="upload_file" name="file" accept=".jpg, .png, .jpeg" onchange="imageSave(event)">
                            <p>2:1.5 харьцаатай зураг оруулна уу!</p>
                        </div>
                    </div>
                    <div id="changeinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Багш бүртгэх</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="afname" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="afname">Эцэг/эхийн нэр*</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="alname" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="alname">Багшийн нэр*</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="aphone" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="aphone">Утас*</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="aemail" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="aemail">E-mail</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="aoffice">Алба*</label>
                            <select class="form form-control mb-3" id="aoffice">
                                <?php foreach ($oarray as $el) { ?>
                                    <option value="<?= $el->oid ?>"><?= $el->oname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label" for="adefartment">Хэлтэс*</label>
                            <select class="form form-control mb-3" id="adefartment">
                                <?php foreach ($darray as $el) { ?>
                                    <option value="<?= $el->did ?>"><?= $el->dname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="aat" class="form form-control" placeholder="Мэдээллийн технологийн багш" />
                                <label class="form-label" for="aat">Албан тушаал</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="auser_role">Төрөл*</label>
                            <select class="form form-control mb-3" id="auser_role">
                                <?php foreach ($atarray as $el) { ?>
                                    <option value="<?= $el->atid ?>"><?= $el->atname ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label" for="atuluv">Төлөв*</label>
                            <select class="form form-control mb-3" id="atuluv">
                                <option value="1">Ажиллаж байгаа</option>
                                <option value="2">Гарсан</option>
                            </select>
                        </div>
                    </div>
                    <div id="addinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" onclick="addTeacher()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel">Багш устгах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="deletebody" class="mb-3">

                    </div>
                    <div id="deleteinfo" class="alert alert-warning" style="display: none;">

                    </div>
                    <input type="text" value="0" id="delete_t_id" readonly style="display: none;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                    <button type="button" class="btn btn-danger" onclick="deleteTeacher()">Устгах</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function pass(id, name) {
        if (confirm(name + " -н нууц үгийг шинэчлэх үү!") == true) {
          $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 4,
                    id: id
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Алдаа гарлаа. Дахин оролдоно уу!");
                },
                beforeSend: function() {
    
                },
                success: function(data) {
                    alert("Шинэчлэгдсэн нууц үг нь: " + data);
                },
                async: true
            });
        } 
    }
    function get() {
        $.ajax({
            url: "ajax-list",
            type: "POST",
            data: {
                angi_id: $('#angi_id').val(),
                teacher_id: $('#teacherList').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#table").html("Алдаа гарлаа !");
            },
            beforeSend: function() {
                $("#table").html("Түр хүлээнэ үү ...");
            },
            success: function(data) {
                $("#table").html(data);
            },
            async: true
        });
    }
    get();

    function deleteTeacher() {
        $.ajax({
            url: "ajax",
            type: "POST",
            data: {
                mode: 3,
                id: $('#delete_t_id').val()
            },
            error: function(xhr, textStatus, errorThrown) {
                $('#deleteinfo').show();
                $("#deleteinfo").html("Алдаа гарлаа!");
            },
            beforeSend: function() {
                $('#deleteinfo').show();
                $("#deleteinfo").html("Түр хүлээнэ үү!");
            },
            success: function(data) {
                if (data === "Амжилттай!") {
                    get();
                    $('#delete').modal('hide');
                } else $("#deleteinfo").html(data);
            },
            async: true
        });
    }

    function editTeacher() {
        if ($('#phone').val() === '' || $('#fname').val() === '' || $('#lname').val() === '') {
            $('#changeinfo').html("Мэдээлэл дутуу байна!");
            $('#changeinfo').show();
        } else {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 1,
                    id: $('#t_id').val(),
                    fname: $('#fname').val(),
                    lname: $('#lname').val(),
                    phone: $('#phone').val(),
                    email: $('#email').val(),
                    office: $('#office').val(),
                    department: $('#defartment').val(),
                    at: $('#at').val(),
                    user_role: $('#user_role').val(),
                    tuluv: $('#tuluv').val(),
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('#changeinfo').show();
                    $("#changeinfo").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $('#changeinfo').show();
                    $("#changeinfo").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    get();
                    $('#change').modal('hide');
                },
                async: true
            });
        }
    }

    function addTeacher() {
        $('#addinfo').hide();
        if ($('#aphone').val() === '' || $('#afname').val() === '' || $('#alname').val() === '') {
            $('#addinfo').html("Мэдээлэл дутуу байна!");
            $('#addinfo').show();
        } else {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 2,
                    fname: $('#afname').val(),
                    lname: $('#alname').val(),
                    phone: $('#aphone').val(),
                    email: $('#aemail').val(),
                    at: $('#aat').val(),
                    aoffice: $('#aoffice').val(),
                    adepartment: $('#adefartment').val(),
                    user_role: $('#auser_role').val(),
                    tuluv: $('#atuluv').val(),
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('#addinfo').show();
                    $("#addinfo").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $('#addinfo').show();
                    $("#addinfo").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    if(data =="Амжилттай"){
                        $('#add').modal('hide');
                        window.location.reload();
                    }
                    else {
                        $("#addinfo").html(data);
                    }
                },
                async: true
            });
        }
    }
    
    function imageBtn(id){
        $('#t_id').val(id);
        $('#pfname').val($('#f1-' + id).text());
        $('#plname').val($('#f2-' + id).text());
        
        let pre = document.getElementById("pro");
        let imgc = '/images/users/' + id + '.jpg';
        pre.src = imgc;
    }
    function editBtn(id, t, oid, did) {
        $('#changeinfo').hide();
        $('#t_id').val(id);
        $('#fname').val($('#f1-' + id).text());
        $('#lname').val($('#f2-' + id).text());
        $('#phone').val($('#f3-' + id).text());
        $('#email').val($('#f4-' + id).text());
        $('#at').val($('#f5-' + id).text());
        $('#user_role').val($('#f6-' + id).text());
        $('#tuluv').val(t);
        $('#office').val(oid);
        $('#defartment').val(did);
    }

    function deleteBtn(id) {
        $('#delete_t_id').val(id);
        $('#deletebody').html('"' + $('#f1-' + id).text() + ' ' + $('#f2-' + id).text() + '" багшийг утгахдаа итгэлтэй байна уу?');
        $('#deleteinfo').hide();
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    const now = new Date();

    const MAX_WIDTH = 500;
    const MAX_HEIGHT = 300;
    const MIME_TYPE = "image/jpg";
    const QUALITY = 1;

    function calculateSize(img, maxWidth, maxHeight) {
        let width = img.width;
        let height = img.height;

        // calculate the width and height, constraining the proportions
        if (width > height) {
            if (width > maxWidth) {
                height = Math.round((height * maxWidth) / width);
                width = maxWidth;
            }
        } else {
            if (height > maxHeight) {
                width = Math.round((width * maxHeight) / height);
                height = maxHeight;
            }
        }
        return [width, height];
    }

    function imageSave(event) {
        if (event.target.files.length > 0) {
            const file = event.target.files[0]; // get the file
            const blobURL = window.URL.createObjectURL(file);
            const img = new Image();
            img.src = blobURL;
            img.onerror = function() {
                window.URL.revokeObjectURL(this.src);
                console.log("Cannot load image");
            };
            img.onload = function() {
                window.URL.revokeObjectURL(this.src);
                const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
                const canvas = document.createElement("canvas");
                canvas.width = newWidth;
                canvas.height = newHeight;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, newWidth, newHeight);
                canvas.toBlob(
                    (blob) => {

                    },
                    MIME_TYPE,
                    QUALITY
                );
                let pre = document.getElementById("pro");
                let imgc = canvas.toDataURL('image/jpg')
                pre.src = imgc;
                uploadFile(imgc);
                
                pre = document.getElementById("imageList-"+$('#t_id').val());
                imgc = canvas.toDataURL('image/jpg');
                pre.src = imgc;
                //console.log(imgc);
            };
        }
    }

    function uploadFile(file) {
        var formData = new FormData();
        formData.append('file_to_upload', file);
        formData.append('file_name', $('#t_id').val());
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener("progress", progressHandler, false);
        ajax.onreadystatechange = function() {
                console.log(this.responseText);
        };
        ajax.open('POST', '/imageSave', true);
        ajax.send(formData);
    }

    function progressHandler(event) {
        var percent = (event.loaded / event.total) * 100;
        document.getElementById("progress_bar").value = Math.round(percent);
        document.getElementById("progress_status").innerHTML = Math.round(percent) + "% ";
    }
</script>
<?php
require ROOT . "/pages/dataTablefooter.php";
require ROOT . "/pages/end.php";
?>