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
$oarray = array();
$darray = array();
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
?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
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
                                <option value="1">Багш</option>
                                <option value="3">Арга зүйч/Менежер</option>
                                <option value="4">Захирал</option>
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
                                <option value="1">Багш</option>
                                <option value="3">Арга зүйч/Менежер</option>
                                <option value="5">ЗАА-н ажилтан</option>
                                <option value="6">Хүний нөөц/Дотоод хяналт</option>
                                <option value="7">ХАБ</option>
                                <option value="4">Захирал</option>
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
                    get();
                    $('#add').modal('hide');
                },
                async: true
            });
        }
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
<?php
require ROOT . "/pages/dataTablefooter.php";
require ROOT . "/pages/end.php";
?>