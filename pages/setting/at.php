<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
_selectNoParam(
    $st,
    $cc,
    "SELECT id, name, tuluv FROM at",
    $at_id,
    $at_name,
    $at_tuluv
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
            <h3>Албан тушаал</h3>
        </div>
        <form action="/setting/ajax" method="post">
            <div class="mb-4">
                <label class="form-label" for="form2Example1" style="margin-left: 0px;">Нэр</label>
                <input type="text" name="atname" class="form-control" required="" placeholder="Багш">
            </div>
            <div class="mb-4">
                <input type="submit" class="btn btn-success" name="addAtushaal" value='БҮРТГЭХ' />
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
                        <th>Төлөв</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $d = 1;
                    while (_fetch($st)) { ?>
                        <tr>
                            <td><?= $d ?></td>
                            <td><?= $at_name ?></td>
                            <td>
                                <?php if ($at_id > 4) { ?>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $at_id ?>, this, 'at_tuluv')" <?php echo $at_tuluv > 0 ? "checked" : "" ?> />
                                    </div>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($at_id > 4) { ?>
                                    <i class="fas fa-trash m-1 fa-lg text-danger" type="button" onclick="deleteBtn(<?= $at_id ?>)"></i>
                                    <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#changeCag" onclick="editBtn(<?= $at_id ?>, '<?= $at_name ?>')"></i>
                                <?php } ?>
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
                <h5 class="modal-title" id="changeLabel">Албан тушаал засах</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/setting/ajax" method="post">
                    <input type="text" value="0" id="at_id" name="at_id" readonly="" style="display: none;">
                    <div class="mb-4">
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">Нэр</label>
                        <input type="text" name="atname" id="atname" class="form-control" required="" placeholder="1-р цаг">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                <button type="submit" name="editAtushaal" class="btn btn-primary">Хадгалах</button>
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

    function editBtn(id, ner, inter) {
        $('#changeinfo').hide();
        $('#at_id').val(id);
        $('#atname').val(ner);
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
                    mode: "at_Delete",
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