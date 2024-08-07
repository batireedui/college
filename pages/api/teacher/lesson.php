<?php
require ROOT . '/pages/api/header.php';
require ROOT . '/pages/api/css.php';
if(isset($_GET["token"]))
{
    $userinfo = _teacherAuth($_GET["token"]);
    if(!empty($userinfo)){
        $user_id = $userinfo['id']; ?>

<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h5>Хичээлүүд</h5>
        <button class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#add">БҮРТГЭХ</button>
    </div>
    <div id="table">

    </div>

    <div class="modal fade" id="change" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLabel">Хичээл засах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-3">
                        <input type="text" value="" id="lesson_name" class="form form-control mb-3" />
                        <label class="form-label" for="lesson_name">Хичээлийн нэр</label>
                    </div>
                    <div class="form-outline mb-3">
                        <input type="text" value="" id="lesson_cag" class="form form-control mb-3" />
                        <label class="form-label" for="lesson_cag">Хичээлийн цаг</label>
                    </div>
                    <input type="text" value="0" id="lesson_id" readonly style="display: none;" />
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
                    <h5 class="modal-title" id="addLabel">Хичээл бүртгэх</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-outline mb-4">
                        <input type="text" value="" id="add_lesson_name" class="form form-control" />
                        <label class="form-label" for="add_lesson_name">Хичээлйн нэр</label>
                    </div>
                    <div class="form-outline mb-3">
                        <input type="text" value="" id="add_lesson_cag" class="form form-control mb-3" />
                        <label class="form-label" for="add_lesson_cag">Хичээлийн цаг</label>
                    </div>
                    <div id="addinfo" class="alert alert-warning" style="display: none;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary" onclick="addLesson()">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteLabel">Хичээл устгах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="deletebody">

                    </div>
                    <input type="text" value="0" id="delete_lesson_id" readonly style="display: none;" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Болих</button>
                    <button type="button" class="btn btn-danger" onclick="deleteLesson()">Устгах</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function change(id, tuluv) {
        console.log(tuluv.checked);

        $.ajax({
            url: "/lesson/ajax",
            type: "POST",
            data: {
                mode: 4,
                lesson_id: id,
                tuluv: tuluv.checked
            },
            error: function(xhr, textStatus, errorThrown) {},
            beforeSend: function() {},
            success: function(data) {
                $('#toastbody').html(data);
                tshow();
            },
            async: true
        });
    }

    function get() {
        $.ajax({
            url: "/lesson/ajax-list",
            type: "POST",
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

    function deleteLesson() {
        $.ajax({
            url: "/lesson/ajax",
            type: "POST",
            data: {
                mode: 3,
                lesson_id: $('#delete_lesson_id').val()
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
        if ($('#lesson_name').val() === "") {
            $('#changeinfo').html("Мэдээлэл дутуу!");
            $('#changeinfo').show();
        } else {
            $.ajax({
                url: "/lesson/ajax",
                type: "POST",
                data: {
                    mode: 1,
                    lesson_id: $('#lesson_id').val(),
                    lesson_name: $('#lesson_name').val(),
                    lesson_cag: $('#lesson_cag').val()
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
                    $("#changeinfo").html(data);
                    $('#change').modal('hide');
                    get();
                },
                async: true
            });
        }
    }

    function addLesson() {
        $('#addinfo').hide();
        if ($('#add_lesson_cag').val() === '' || $('#add_lesson_name').val() === '') {
            $('#addinfo').html("Мэдээлэл дутуу байна!");
            $('#addinfo').show();
        } else {
            $.ajax({
                url: "/lesson/ajax",
                type: "POST",
                data: {
                    mode: 2,
                    lesson_name: $('#add_lesson_name').val(),
                    lesson_cag: $('#add_lesson_cag').val()
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
                    $('#addinfo').html("");
                    $('#add').modal('hide');
                },
                async: true
            });
        }
    }

    function editBtn(id) {
        $('#changeinfo').hide();
        $('#lesson_id').val(id);
        $('#lesson_name').val($('#f1-' + id).text());
        $('#lesson_cag').val($('#f2-' + id).text());
    }

    function deleteBtn(angi) {
        $('#delete_lesson_id').val(angi);
        $('#deletebody').html('"' + $('#f1-' + angi).text() + '" хичээлийг утгахдаа итгэлтэй байна уу?');
    }
</script>
<?php
require ROOT . "/pages/end.php";
}
    else echo "noAuth";
}
else echo "tokenExpired";
?>