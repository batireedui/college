<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
_selectNoParam(
    $st,
    $cc,
    "SELECT id, name, manager_id, tuluv FROM office",
    $office_id,
    $office_name,
    $office_manager_id,
    $office_tuluv
);

$officeArr = array();
while (_fetch($st)) {
    $item = new stdClass();
    $item->office_id = $office_id;
    $item->office_name = $office_name;
    $item->office_manager_id = $office_manager_id;
    $item->office_tuluv = $office_tuluv;
    array_push($officeArr, $item);
}

_selectNoParam(
    $dst,
    $dcc,
    "SELECT id, name, manager_id, tuluv, office_id FROM department",
    $d_id,
    $d_name,
    $d_manager_id,
    $d_tuluv,
    $d_office
);

_select(
    $tstmt,
    $tcount,
    "SELECT id, fname, UPPER(lname) FROM teacher WHERE tuluv=? ORDER BY lname",
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
    $item->name = $lname . " (" . $fname . ")";

    array_push($teachers, $item);
}
?>
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<div class="row">
    <div class="col border border-success rounded p-3 m-3">
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            <h3>Алба</h3>
        </div>
        <form action="/setting/ajax" method="post">
            <div class="col mb-4">
                <label class="form-label" for="form2Example1" style="margin-left: 0px;">Нэр</label>
                <input type="text" name="office_name" class="form-control" required="">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="mana" style="margin-left: 0px;">Менежер</label>
                <select class="form form-control mb-3" id="mana" name="manager">
                    <option value="0"></option>
                    <?php foreach ($teachers as $el) : ?>
                        <option value="<?= $el->tid ?>"><?= $el->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col mb-4">
                <input type="submit" class="btn btn-success" name="addAlba" value='Хадгалах' />
            </div>
        </form>
        <div id="table">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>Нэр</th>
                        <th>Менежер</th>
                        <th>Төлөв</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $d = 1;
                    foreach ($officeArr as $el) { ?>
                        <tr>
                            <td><?= $d ?></td>
                            <td><?= $el->office_name ?></td>
                            <td>
                                <?php foreach ($teachers as $e) {
                                    if ($e->tid == $el->office_manager_id) {
                                        echo $e->name;
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $el->office_id ?>, this, 'office_tuluv')" <?php echo $el->office_tuluv > 0 ? "checked" : "" ?> />
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-trash m-1 fa-lg text-danger" type="button" onclick="deleteBtn(<?= $el->office_id ?>, 'delete_office')"></i>
                                <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#change" onclick="editBtn(<?= $el->office_id ?>, '<?= $el->office_name ?>', '<?= $el->office_manager_id ?>')"></i>
                            </td>
                        </tr>
                    <?php $d++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col border border-primary rounded p-3 m-3">
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            <h3>Тэнхим/Хэлтэс</h3>
        </div>
        <form action="/setting/ajax" method="post">
            <div class="col mb-4">
                <label class="form-label" for="office_id" style="margin-left: 0px;">Алба</label>
                <select class="form-control" id="office_id" name="office_id">
                    <option value="0"></option>
                    <?php $d = 1;
                    foreach ($officeArr as $el) { ?>
                        <option value="<?= $el->office_id ?>"><?= $el->office_name ?></option>
                    <?php $d++;
                    } ?>
                </select>
            </div>
            <div class="col mb-4">
                <label class="form-label" for="d_name" style="margin-left: 0px;">Тэнхим/Хэлтсийн нэр</label>
                <input type="text" name="d_name" class="form-control" required="">
            </div>
            <div class="col mb-4">
                <label class="form-label" for="d_manager" style="margin-left: 0px;">Эрхлэгч/Дарга</label>
                <select class="form form-control mb-3" id="d_manager" name="d_manager">
                    <option value="0"></option>
                    <?php foreach ($teachers as $el) : ?>
                        <option value="<?= $el->tid ?>"><?= $el->name ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col mb-4">
                <label></label>
                <input type="submit" class="btn btn-primary" name="addHeltes" value='Хадгалах' />
            </div>
        </form>
        <div id="table-d">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>Алба</th>
                        <th>Нэр</th>
                        <th>Эрхлэгч/Дарга</th>
                        <th>Төлөв</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $d = 1;
                    while (_fetch($dst)) { ?>
                        <tr>
                            <td><?= $d ?></td>
                            <td>
                                <?php foreach ($officeArr as $e) {
                                    if ($e->office_id == $d_office) {
                                        echo $e->office_name;
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $d_name ?></td>
                            <td>
                                <?php foreach ($teachers as $e) {
                                    if ($e->tid == $d_manager_id) {
                                        echo $e->name;
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $d_id ?>, this, 'department')" <?php echo $d_tuluv > 0 ? "checked" : "" ?> />
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-trash m-1 fa-lg text-danger" type="button" onclick="deleteBtn(<?= $d_id ?>, 'delete_department')"></i>
                                <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#changeHeltes" onclick="editBtnHeltes('<?= $d_id ?>', '<?= $d_name ?>', '<?= $d_office ?>', '<?= $d_manager_id ?>')"></i>
                            </td>
                        </tr>
                    <?php $d++;
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="change" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeLabel">Албаны мэдээлэл засах</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/setting/ajax" method="post">
                    <input type="text" value="0" id="alba_id" name="alba_id" readonly="" style="display: none;">
                    <div class="col mb-4">
                        <label class="form-label" for="eoffice_name" style="margin-left: 0px;">Нэр</label>
                        <input type="text" name="eoffice_name" id="eoffice_name" class="form-control" required="">
                    </div>
                    <div class="col mb-4">
                        <label class="form-label" for="emanager" style="margin-left: 0px;">Менежер</label>
                        <select class="form form-control mb-3" id="emanager" name="emanager">
                            <option value="0"></option>
                            <?php foreach ($teachers as $el) : ?>
                                <option value="<?= $el->tid ?>"><?= $el->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                <button type="submit" name="editAlba" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeHeltes" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeLabel">Тэнхим/Хэлтсийн мэдээлэл засах</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/setting/ajax" method="post">
                    <input type="text" value="0" id="heltes_id" name="heltes_id" readonly="" style="display: none;">
                    <div class="col mb-4">
                        <label class="form-label" for="eoffice_id" style="margin-left: 0px;">Алба</label>
                        <select class="form-control" id="eoffice_id" name="eoffice_id">
                            <option value="0"></option>
                            <?php $d = 1;
                            foreach ($officeArr as $el) { ?>
                                <option value="<?= $el->office_id ?>"><?= $el->office_name ?></option>
                            <?php $d++;
                            } ?>
                        </select>
                    </div>
                    <div class="col mb-4">
                        <label class="form-label" for="ed_name" style="margin-left: 0px;">Тэнхэм/Хэлтсийн нэр</label>
                        <input type="text" name="ed_name" id="ed_name" class="form-control" required="">
                    </div>
                    <div class="col mb-4">
                        <label class="form-label" for="ed_manager" style="margin-left: 0px;">Менежер</label>
                        <select class="form form-control mb-3" id="ed_manager" name="ed_manager">
                            <option value="0"></option>
                            <?php foreach ($teachers as $el) : ?>
                                <option value="<?= $el->tid ?>"><?= $el->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                <button type="submit" name="editHeltes" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function editBtn(id, ner, m) {
        $('#changeinfo').hide();
        $('#alba_id').val(id);
        $('#eoffice_name').val(ner);
        $('#emanager').val(m);
    }

    function editBtnHeltes(id, ner, oid, mid) {
        $('#changeinfo').hide();
        $('#heltes_id').val(id);
        $('#eoffice_id').val(oid);
        $('#ed_name').val(ner);
        $('#ed_manager').val(mid);
    }

    function tshow() {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        toastList.forEach(toast => toast.show())
    }

    function deleteBtn(id, vmode) {
        let result = confirm("Та устгахдаа итгэлтэй байна уу?");
        if (result === true) {
            $.ajax({
                url: "/setting/ajax",
                type: "POST",
                data: {
                    mode: vmode,
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

    function change(id, tuluv, vmode) {
        console.log(tuluv.checked);

        $.ajax({
            url: "/setting/ajax",
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<?php
require ROOT . "/pages/end.php";
?>