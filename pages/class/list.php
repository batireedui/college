<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

_select(
    $tstmt,
    $tcount,
    "SELECT id, fname, UPPER(lname) FROM teacher WHERE tuluv=? and user_role=1 ORDER BY lname",
    "i",
    ['1'],
    $tid,
    $fname,
    $lname
);

$teachers = array();

while (_fetch($tstmt)) {
    $item = new stdClass();
    $item->tid = $tid;
    $item->name = $fname . " " . $lname;

    array_push($teachers, $item);
}

?>

<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h3>Ангийн бүртгэл</h3>
        <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#add">БҮРТГЭХ</button>
    </div>

    <div id="table">

    </div>

    <div class="modal fade" id="change" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLabel">Анги засах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <input type="text" value="" id="angi_name" class="form form-control mb-3" />
                        <label class="form-label" for="angi_name">Ангийн нэр</label>
                    </div>
                    <input type="text" value="0" id="angi_id" readonly style="display: none;" />
                    <div class="row mb-4">
                        <div class="col">
                            <label class="form-label" for="hugacaa">Хугацаа</label>
                            <select class="form form-control mb-3" id="hugacaa">
                                <option>3</option>
                                <option>1</option>
                                <option>1.5</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label" for="teacherList">Багш</label>
                            <select class="form form-control mb-3" id="teacherList">
                                <?php foreach ($teachers as $el) : ?>
                                    <option value="<?= $el->tid ?>"><?= $el->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id="changeinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" onclick="editAngi()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addLabel">Анги бүртгэх</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <input type="text" value="" id="add_angi_name" class="form form-control" />
                        <label class="form-label" for="add_angi_name">Ангийн нэр</label>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label class="form-label" for="addhugacaa">Хугацаа</label>
                            <select class="form form-control" id="addhugacaa">
                                <option>3</option>
                                <option>1</option>
                                <option>1.5</option>
                            </select>
                        </div>
                        <div class="col">
                            <label class="form-label" for="add_teacher_id">Багш</label>
                            <select class="form form-control" id="add_teacher_id">
                                <?php foreach ($teachers as $el) : ?>
                                    <option value="<?= $el->tid ?>"><?= $el->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div id="addinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" onclick="addAngi()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel">Анги устгах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="deletebody">

                    </div>
                    <input type="text" value="0" id="delete_angi_id" readonly style="display: none;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                    <button type="button" class="btn btn-danger" onclick="deleteAngi()">Устгах</button>
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

    function deleteAngi() {
        $.ajax({
            url: "ajax",
            type: "POST",
            data: {
                mode: 3,
                angi_id: $('#delete_angi_id').val()
            },
            error: function(xhr, textStatus, errorThrown) {},
            beforeSend: function() {},
            success: function(data) {
                get();
                $('#delete').modal('hide');
            },
            async: true
        });
    }

    function editAngi() {
        if ($('#teacherList').val() === null) {
            $('#changeinfo').html("Багш сонго!");
            $('#changeinfo').show();
        } else {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 1,
                    angi_id: $('#angi_id').val(),
                    teacher_id: $('#teacherList').val(),
                    angi_name: $('#angi_name').val(),
                    hugacaa: $('#hugacaa').val()
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

    function addAngi() {
        $('#addinfo').hide();
        if ($('#add_teacher_id').val() === null || $('#add_angi_name').val() === '') {
            $('#addinfo').html("Мэдээлэл дутуу байна!");
            $('#addinfo').show();
        } else {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 2,
                    teacher_id: $('#add_teacher_id').val(),
                    angi_name: $('#add_angi_name').val(),
                    hugacaa: $('#addhugacaa').val()
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#addbody").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $('#addinfo').html("Түр хүлээнэ үү ...");
                    $('#addinfo').show();
                },
                success: function(data) {
                    get();
                    $('#add').modal('hide');
                },
                async: true
            });
        }
    }

    function setTeacher(id, angi) {
        $('#changeinfo').hide();
        $('#teacherList').val(id);
        $('#angi_id').val(angi);
        $('#angi_name').val($('#f1-' + angi).text());
    }

    function deleteBtn(angi) {
        $('#delete_angi_id').val(angi);
        $('#deletebody').html('"' + $('#f1-' + angi).text() + '" ангийг утгахдаа итгэлтэй байна уу?');
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>