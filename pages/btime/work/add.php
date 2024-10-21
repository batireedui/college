<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

_selectNoParam(
    $ast,
    $acc,
    "SELECT id, name FROM `at`",
    $at_id,
    $at_name
);

$atArray = array();
while (_fetch($ast)) {
    $item = new stdClass();
    $item->at_id = $at_id;
    $item->at_name = $at_name;
    array_push($atArray, $item);
}

?>
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<div class="row">
    <div class="col-md-4 border border-success rounded p-3 m-3">
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            <h3>Багшийн зэрэг, норм</h3>
        </div>
        <div class="mb-4">
            <label class="form-label" for="addajil" style="margin-left: 0px;">Ажил үйлчилгээ</label>
            <textarea class="form form-control" id="addajil"></textarea>
        </div>
        <div class="mb-4">
            <label class="form-label" for="addnotol" style="margin-left: 0px;">Тайлбар/Бүрдүүлэх нотолгоо</label>
            <textarea class="form form-control" id="addnotol"></textarea>
        </div>
        <div class="mb-4">
            <label class="form-label" for="addcr" style="margin-left: 0px;">Тооцох кредит</label>
            <textarea class="form form-control" id="addcr"></textarea>
        </div>
        <div class="mb-4">
            <label class="form-label" for="addat" style="margin-left: 0px;">Тооцох албан тушаалтан</label>
            <select class="form form-control" id="addat">
                <option value="0">Сонгоно уу!</option>
                <?php
                foreach ($atArray as $el) {
                    echo "<option value='$el->at_id'>$el->at_name</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-4">
            <input type="submit" class="btn btn-success" onclick="addbtime()" value='БҮРТГЭХ' />
        </div>
    </div>
    <div class="col-md-7 border border-success rounded p-3 m-3">
        <div id="table">

        </div>
    </div>

    <div class="modal fade" id="changeCag" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLabel">Тэнхим/Хэлтсийн мэдээлэл засах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
                        <h3>Багшийн зэрэг, норм</h3>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="editajil" style="margin-left: 0px;">Ажил үйлчилгээ</label>
                        <textarea class="form form-control" id="editajil"></textarea>
                        <input type="text" value="0" class="d-none" id="editid" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="editnotol" style="margin-left: 0px;">Тайлбар/Бүрдүүлэх нотолгоо</label>
                        <textarea class="form form-control" id="editnotol"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="editcr" style="margin-left: 0px;">Тооцох кредит</label>
                        <textarea class="form form-control" id="editcr"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="editat" style="margin-left: 0px;">Тооцох албан тушаалтан</label>
                        <select class="form form-control" id="editat">
                            <option value="0">Сонгоно уу!</option>
                            <?php
                            foreach ($atArray as $el) {
                                echo "<option value='$el->at_id'>$el->at_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" onclick="editbtime()" class="btn btn-primary">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    require ROOT . "/pages/footer.php"; ?>
    <script>
        function addbtime() {
            if ($('#addajil').val() == '') {
                alert('Ажил үйлчилгээ талбарт утга оруулна уу!');
            } else if ($('#addnotol').val() == '') {
                alert('Тайлбар/Бүрдүүлэх нотолгоо талбарт утга оруулна уу!');
            } else if ($('#addcr').val() == '') {
                alert('Тооцох кредит талбарт утга оруулна уу!');
            } else if ($('#addat').val() == '0') {
                alert('Тооцох албан тушаалтан сонгоно уу!');
            } else {
                $.ajax({
                    url: "ajax",
                    type: "POST",
                    data: {
                        mode: "addbtime",
                        ajil: $('#addajil').val(),
                        addnotol: $('#addnotol').val(),
                        addcr: $('#addcr').val(),
                        addat: $('#addat').val()
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        //$('#table').html("Алдаа гарлаа!");
                    },
                    beforeSend: function() {
                        //$('#table').html("Түр хүлээнэ үү!");
                    },
                    success: function(data) {
                        alert('Амжилттай');
                        get();
                        $('#addajil').val('');
                        $('#addnotol').val('');
                        $('#addcr').val('');
                        $('#addat').val('');
                    },
                    async: true
                });
            }
        }
        function editbtime() {
            if ($('#editajil').val() == '') {
                alert('Ажил үйлчилгээ талбарт утга оруулна уу!');
            } else if ($('#editnotol').val() == '') {
                alert('Тайлбар/Бүрдүүлэх нотолгоо талбарт утга оруулна уу!');
            } else if ($('#editcr').val() == '') {
                alert('Тооцох кредит талбарт утга оруулна уу!');
            } else if ($('#editat').val() == '0') {
                alert('Тооцох албан тушаалтан сонгоно уу!');
            } else {
                $.ajax({
                    url: "ajax",
                    type: "POST",
                    data: {
                        mode: "editbtime",
                        ajil: $('#editajil').val(),
                        addnotol: $('#editnotol').val(),
                        addcr: $('#editcr').val(),
                        addat: $('#editat').val(),
                        editid: $('#editid').val()
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        //$('#table').html("Алдаа гарлаа!");
                    },
                    beforeSend: function() {
                        //$('#table').html("Түр хүлээнэ үү!");
                    },
                    success: function(data) {
                        alert('Амжилттай');
                        window.location.reload();
                    },
                    async: true
                });
            }
        }

        function get() {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: "get"
                },
                error: function(xhr, textStatus, errorThrown) {
                    $('#table').html("Алдаа гарлаа!");
                },
                beforeSend: function() {
                    $('#table').html("Түр хүлээнэ үү!");
                },
                success: function(data) {
                    $('#table').html(data);
                },
                async: true
            });
        }
        get();

        function change(id, tuluv, vmode) {
            console.log(tuluv.checked);

            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: vmode,
                    id: id,
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

        function editBtn(id, at_id) {
            $('#editajil').val($('#' + id + '-ajil').html());
            $('#editnotol').val($('#' + id + '-tailbar').html());
            $('#editcr').val($('#' + id + '-credit').html());
            $('#editat').val(at_id);
            $('#editid').val(id);
        }

        function tshow() {
            var toastElList = [].slice.call(document.querySelectorAll('.toast'))
            var toastList = toastElList.map(function(toastEl) {
                return new bootstrap.Toast(toastEl)
            })
            toastList.forEach(toast => toast.show())
        }

        function deleteBtn(id) {
            let result = confirm("Та устгахдаа итгэлтэй байна уу?");
            if (result === true) {
                $.ajax({
                    url: "ajax",
                    type: "POST",
                    data: {
                        mode: "btimeajilDelete",
                        id: id
                    },
                    error: function(xhr, textStatus, errorThrown) {},
                    beforeSend: function() {},
                    success: function(data) {
                        if (data == "Амжилттай") {
                            window.location.reload();
                        } else {
                            $('#toastbody').html(data);
                            tshow();
                        }
                    },
                    async: true
                });
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <?php
    require ROOT . "/pages/end.php";
    ?>