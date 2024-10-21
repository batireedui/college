<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
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
            <h3>Хэрэглэгчдийн хандах эрх тохируулах</h3>
        </div>
        <div class="mb-4">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr class="table table-bordered">
                        <th>АЛБАН ТУШААЛ</th>
                        <?php foreach ($erh as $erhid => $erhname) { ?>
                            <th><?= $erhname ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($atID as $idat => $nameat) { ?>
                        <tr>
                            <td><?= $nameat ?></td>
                            <?php foreach ($erh as $erhid => $erhname) {
                                _selectRowNoParam(
                                    "SELECT count(id) FROM `at_tax` WHERE erh = $erhid and at_id=$idat",
                                    $eseh
                                )
                            ?>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $idat ?>, <?= $erhid ?>, this, 'erhchange')" <?php echo $eseh > 0 ? "checked" : "" ?> />
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php }
                    _selectNoParam(
                        $stm,
                        $count,
                        "SELECT id, name FROM `at` WHERE tuluv=1",
                        $id,
                        $name
                    );
                    while (_fetch($stm)) {
                    ?>
                        <tr>
                            <td><?= $name ?></td>
                            <?php foreach ($erh as $erhid => $erhname) {
                                _selectRowNoParam(
                                    "SELECT count(id) FROM `at_tax` WHERE erh = $erhid and at_id=$id",
                                    $eseh
                                )
                            ?>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $id ?>, <?= $erhid ?>, this, 'erhchange')" <?php echo $eseh > 0 ? "checked" : "" ?> />
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function change(atid, erhid, tuluv, vmode) {
        console.log(tuluv.checked);

        $.ajax({
            url: "/setting/ajax",
            type: "POST",
            data: {
                mode: vmode,
                atid: atid,
                erhid: erhid,
                tuluv: tuluv.checked
            },
            error: function(xhr, textStatus, errorThrown) {},
            beforeSend: function() {},
            success: function(data) {
                if (data == "Амжилттай") {
                    window.location.reload();
                } else {
                    alert(data);
                    window.location.reload();
                }
            },
            async: true
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<?php
require ROOT . "/pages/end.php";
?>