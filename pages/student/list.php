<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
$sql = "";
if ($user_role < 2) {
    $sql = "class.teacherid = '$user_id' and ";
}
_select(
    $stmt,
    $count,
    "SELECT students.id, students.code, students.fname, students.lname, students.gender, students.phone, students.class, students.pass, students.tuluv, class.name , class.sname, students.class
        FROM students INNER JOIN class ON students.class = class.id WHERE $sql students.tuluv=?",
    "i",
    [1],
    $id,
    $code,
    $fname,
    $lname,
    $gender,
    $phone,
    $class,
    $pass,
    $tuluv,
    $cname,
    $sname,
    $classid
);

_select(
    $tstmt,
    $tcount,
    "SELECT id, name, sname FROM class WHERE $sql tuluv=?",
    "i",
    ['1'],
    $cid,
    $cname,
    $sname
);

$classList = array();

while (_fetch($tstmt)) {
    $item = new stdClass();
    $item->id = $cid;
    $item->name = $cname;
    $item->sname = $sname;

    array_push($classList, $item);
}

$columnNumber = 7;
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
        <h3>Суралцагчийн бүртгэл <?php ?></h3>
        <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#add">БҮРТГЭХ</button>
    </div>

    <div id="table">
        <table class="table" id="datalist">
            <thead class="table-light">
                <tr>
                    <th>№</th>
                    <th>Эцэг/эхийн нэр</th>
                    <th>Нэр</th>
                    <th>Утас</th>
                    <th>Хүйс</th>
                    <th>РД</th>
                    <th>Асран хамгаалагч</th>
                    <th>Анги</th>
                    <th>Судалгаа</th>
                    <th></th>
                </tr>
            </thead>
            <?php if ($count > 0) : ?>
                <?php $too = 0;
                while (_fetch($stmt)) :
                    $too++;
                    _selectNoParam(
                        $pstmt,
                        $pcount,
                        "SELECT tax_pareant.id, fname, lname, phone FROM parent INNER JOIN tax_pareant ON parent.id = tax_pareant.parent_id  WHERE student_id = $id",
                        $pid,
                        $pfname,
                        $plname,
                        $pphone
                    );
                    ?>
                    <tr>
                        <td><?= $too ?></td>
                        <td id="f1-<?= $id ?>"><?= $fname ?></td>
                        <td id="f2-<?= $id ?>"><?= $lname ?></td>
                        <td id="f3-<?= $id ?>"><?= $phone ?></td>
                        <td id="f4-<?= $id ?>"><?= $gender ?></td>
                        <td id="f5-<?= $id ?>"><?= $code ?></td>
                        <td id="f7-<?= $id ?>"><span onclick="getParent(<?= $id ?>)" class="badge badge-success" type="button" data-mdb-toggle="modal" data-mdb-target="#parentModal"><?php
                            if($pcount > 0){
                                while (_fetch($pstmt)){
                                    echo substr($pfname, 0, 2) . ".$plname ($pphone)";
                                }
                            } else echo "Бүртгэгдээгүй";
                        ?></span></span></td>
                        <td id="f6-<?= $id ?>" style="font-size: 12px;"><?= $sname ?> <?= $cname ?></td>
                        <td><a href="/sudalgaa/insertsudalgaa?id=<?=$id?>&angi=<?=$classid?>&type=0"><div class="btn btn-warning">Судалгаа бөглөх</div></a></td>
                        <td>
                            <i class="fas fa-trash m-1 fa-lg text-danger" type="button" data-mdb-toggle="modal" data-mdb-target="#delete" onclick="deleteBtn(<?= $id ?>)"></i>
                            <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#change" onclick="editBtn(<?= $id ?>, <?= $class ?>, <?= $tuluv ?>)"></i>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </table>
    </div>

    <div class="modal fade" id="change" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLabel">Суралцагч засах</h5>
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
                                <label class="form-label" for="lname">Суралцагчийн нэр*</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="phone" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="phone">Утас*</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="rd" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="rd">РД</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            <div class="form mb-3">
                                <label class="form-label" for="gender">Хүйс*</label>
                                <select class="form form-control mb-3" id="gender">
                                    <option>Эрэгтэй</option>
                                    <option>Эмэгтэй</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form mb-3">
                                <label class="form-label" for="tuluv">Төлөв*</label>
                                <select class="form form-control mb-3" id="tuluv">
                                <?php foreach ($tuluv_Student as $el=>$val) { ?>
                                    <option value="<?= $el ?>"><?= $val ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="class">Анги*</label>
                            <select class="form form-control mb-3" id="class">
                                <?php foreach ($classList as $el) : ?>
                                    <option value="<?= $el->id ?>"><?= $el->sname ?> <?= $el->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id="changeinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" onclick="editStudent()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Суралцагч бүртгэх</h5>
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
                                <label class="form-label" for="alname">Суралцагчийн нэр*</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="aphone" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="aphone">Утас*</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="ard" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="ard">РД</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col">
                            <div class="form mb-3">
                                <label class="form-label" for="agender">Хүйс*</label>
                                <select class="form form-control mb-3" id="agender">
                                    <option>Эрэгтэй</option>
                                    <option>Эмэгтэй</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form mb-3">
                                <label class="form-label" for="atuluv">Төлөв*</label>
                                <select class="form form-control mb-3" id="atuluv">
                                <?php foreach ($tuluv_Student as $el=>$val) { ?>
                                    <option value="<?= $el ?>"><?= $val ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label class="form-label" for="aclass">Анги*</label>
                            <select class="form form-control mb-3" id="aclass">
                                <?php foreach ($classList as $el) : ?>
                                    <option value="<?= $el->id ?>"><?= $el->sname ?> <?= $el->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id="changeinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" onclick="addStudent()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel">Суралцагч устгах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="deletebody">

                    </div>
                    <input type="text" value="0" id="delete_s_id" readonly style="display: none;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                    <button type="button" class="btn btn-danger" onclick="deleteStudent()">Устгах</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="parentLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="parentLabel">Асран хамгаалагч</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <input type="text" id="add_parent" readonly style="display: none;" />
                        <div class="col" id="parentbody">
                        
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-outline mb-3">
                                <input type="text" value="" id="pphone" class="form form-control mb-3" autocomplete="FALSE" />
                                <label class="form-label" for="pphone">Утасны дугаар*</label>
                            </div>
                        </div>
                        <div class="col">
                            <button class="btn btn-secondary" onclick="findParent()">ХАЙХ</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col" id="parentAdd">
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function findParent() {
        let findPhone = $('#pphone').val();
        if(findPhone.length == 8){
            $.ajax({
                url: "parent_control",
                type: "POST",
                data: {
                    mode: 2,
                    phone: findPhone
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#parentAdd").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $("#parentAdd").html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $("#parentAdd").html(data);
                },
                async: true
            });
        }
        else $("#parentAdd").html("Утасны дугаар зөв оруулна уу!");
    }
    
    function getParent(id) {
        $('#add_parent').val(id);
        $.ajax({
            url: "parent_control",
            type: "POST",
            data: {
                mode: 1,
                id: id
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#parentbody").html("Алдаа гарлаа !");
            },
            beforeSend: function() {
                $("#parentbody").html("Түр хүлээнэ үү ...");
            },
            success: function(data) {
                $("#parentbody").html(data);
            },
            async: true
        });
    }

    function deleteStudent() {
        $.ajax({
            url: "ajax",
            type: "POST",
            data: {
                mode: 3,
                id: $('#delete_s_id').val()
            },
            error: function(xhr, textStatus, errorThrown) {},
            beforeSend: function() {},
            success: function(data) {
                location.reload();
            },
            async: true
        });
    }

    function editStudent() {
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
                    gender: $('#gender').val(),
                    phone: $('#phone').val(),
                    class: $('#class').val(),
                    tuluv: $('#tuluv').val(),
                    rd: $('#rd').val()
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
                    location.reload();
                },
                async: true
            });
        }
    }

    function addStudent() {
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
                    gender: $('#agender').val(),
                    phone: $('#aphone').val(),
                    class: $('#aclass').val(),
                    tuluv: $('#atuluv').val(),
                    rd: $('#ard').val()
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
                    location.reload();
                },
                async: true
            });
        }
    }

    function editBtn(id, angi, tuluv) {
        $('#changeinfo').hide();
        $('#t_id').val(id);
        $('#fname').val($('#f1-' + id).text());
        $('#lname').val($('#f2-' + id).text());
        $('#phone').val($('#f3-' + id).text());
        $('#gender').val($('#f4-' + id).text());
        $('#rd').val($('#f5-' + id).text());
        $('#class').val(angi);
        $('#tuluv').val(tuluv);
    }

    function deleteBtn(id) {
        $('#delete_s_id').val(id);
        $('#deletebody').html('"' + $('#f1-' + id).text() + ' ' + $('#f2-' + id).text() + '" Суралцагчийг утгахдаа итгэлтэй байна уу?');
    }
</script>
<?php
require ROOT . "/pages/dataTablefooter.php";
require ROOT . "/pages/end.php";
?>