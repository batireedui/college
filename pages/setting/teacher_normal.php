<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
_selectNoParam(
    $st,
    $cc,
    "SELECT id, name, money, anorm, bnorm, tuluv FROM tzereg",
    $z_id,
    $z_name,
    $z_money,
    $z_anorm,
    $z_bnorm,
    $z_tuluv
);

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
            <h3>Багшийн зэрэг, норм</h3>
        </div>
        <form action="/setting/ajax" method="post">
            <div class="mb-4">
                <label class="form-label" for="form2Example1" style="margin-left: 0px;">Нэр</label>
                <input type="text" name="zname" class="form-control" required="" placeholder="Заах аргач багш">
            </div>
            <div class="mb-4">
                <label class="form-label" for="money" style="margin-left: 0px;">Кредитын үнэлгээ</label>
                <input type="text" name="money" class="form-control" required="" placeholder="Зөвхөн тоо оруулна">
            </div>
            <div class="mb-4">
                <label class="form-label" for="anorm" style="margin-left: 0px;">Танхимын цаг норм</label>
                <input type="text" name="anorm" class="form-control" required="" placeholder="Зөвхөн тоо оруулна">
            </div>
            <div class="mb-4">
                <label class="form-label" for="bnorm" style="margin-left: 0px;">Танхимын бус цаг норм</label>
                <input type="text" name="bnorm" class="form-control" required="" placeholder="Зөвхөн тоо оруулна">
            </div>
            <div class="mb-4">
                <input type="submit" class="btn btn-success" name="addZereg" value='БҮРТГЭХ' />
            </div>
        </form>
    </div>
    <div class="col border border-success rounded p-3 m-3">
        <div id="table">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>№</th>
                        <th>Нэр</th>
                        <th>Кредитын үнэлгээ</th>
                        <th>Танхимын цаг норм</th>
                        <th>Танхимын бус цаг норм</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $d = 1;
                    while (_fetch($st)) { ?>
                        <tr>
                            <td><?= $d ?></td>
                            <td><?= $z_name ?></td>
                            <td><?= $z_money ?></td>
                            <td><?= $z_anorm ?></td>
                            <td><?= $z_bnorm ?></td>
                            <td>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $z_tuluv ?>, this, 'zereg_tuluv')" <?php echo $z_tuluv > 0 ? "checked" : "" ?> />
                                </div>
                            </td>
                            <td>
                                <i class="fas fa-trash m-1 fa-lg text-danger" type="button" onclick="deleteBtn(<?= $z_id ?>)"></i>
                                <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#changeCag" onclick="editBtn(<?= $z_id ?>, '<?= $z_name ?>', '<?= $z_money ?>', '<?= $z_anorm ?>', '<?= $z_bnorm ?>')"></i>
                            </td>
                        </tr>
                    <?php $d++;
                    } ?>
                </tbody>
            </table>
        </div>
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
                <form action="/setting/ajax" method="post">
                    <input type="text" value="0" id="zereg_id" name="zereg_id" readonly="" style="display: none;">
                    <div class="mb-4">
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">Нэр</label>
                        <input type="text" name="zname" id="zname" class="form-control" required="" placeholder="Заах аргач багш">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="money" style="margin-left: 0px;">Кредитын үнэлгээ</label>
                        <input type="text" name="money" id="money" class="form-control" required="" placeholder="Зөвхөн тоо оруулна">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="anorm" style="margin-left: 0px;">Танхимын цаг норм</label>
                        <input type="text" name="anorm" id="anorm" class="form-control" required="" placeholder="Зөвхөн тоо оруулна">
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="bnorm" style="margin-left: 0px;">Танхимын бус цаг норм</label>
                        <input type="text" name="bnorm" id="bnorm" class="form-control" required="" placeholder="Зөвхөн тоо оруулна">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                <button type="submit" name="editZereg" class="btn btn-primary">Хадгалах</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
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

    function editBtn(id, ner, money, anorm, bnorm) {
        $('#changeinfo').hide();
        $('#zereg_id').val(id);
        $('#zname').val(ner);
        $('#money').val(money);
        $('#anorm').val(anorm);
        $('#bnorm').val(bnorm);
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
                url: "/setting/ajax",
                type: "POST",
                data: {
                    mode: "zereg_Delete",
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