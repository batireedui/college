<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

_select(
    $stmt,
    $count,
    "SELECT id, name, hugacaa, tuluv, teacherid FROM class WHERE class.tuluv=?",
    "i",
    ['1'],
    $id,
    $name,
    $hugacaa,
    $tuluv,
    $teacherid
);
?>

<div>
    АНги
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Ангийн нэр</th>
                <th>Хугацаа</th>
                <th>Ангийн багш</th>
                <th>Төлөв</th>
                <th>Үйлдэл</th>
            </tr>
        </thead>
        <?php if ($count > 0) : ?>
            <?php $too = 0;
            while (_fetch($stmt)) :
                $t_id = 0;
                $t_fname = "";
                $t_lname = "";
                _selectRowNoParam(
                    "SELECT id, fname, lname FROM teacher WHERE id='$teacherid'",
                    $t_id,
                    $t_fname,
                    $t_lname
                );
                $too++ ?>
                <tr>
                    <td><?= $too ?></td>
                    <td id="f1-<?= $id ?>"><?= $name ?></td>
                    <td id="f2-<?= $id ?>"><?= $hugacaa ?></td>
                    <td id="f4-<?= $id ?>">
                        <span onclick="setTeacher(<?= $id ?>)" class="badge badge-success" type="button" data-mdb-toggle="modal" data-mdb-target="#change">
                            <?php
                            echo  $t_id == 0 ? "Багшгүй" : $t_fname . " <span class='text-uppercase'>" . $t_lname . "</span>";
                            ?>
                        </span>
                    </td>
                    <td>
                    </td>
                    <th>
                        <i class="fas fa-trash m-1" type="button" data-mdb-toggle="modal" data-mdb-target="#delete"></i>
                        <i class="fas fa-pen-to-square" type="button" data-mdb-toggle="modal" data-mdb-target="#edit"></i>
                    </th>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>

    <div class="modal fade" id="change" tabindex="-1" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeLabel">Ангийн багш солих</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="changebody">
                    <select class="select2" name="state">
                        <option value="AL">Alabama</option>
                        <option value="WY">Wyoming</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Анги засах</h5>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary">Хадгалах</button>
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
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Хаах</button>
                    <button type="button" class="btn btn-primary">Хадгалах</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    function setTeacher(id) {
        console.log(id);
        /*
        $.ajax({
            url: "ajax",
            type: "POST",
            data: {
                mtype_id: 2
            },
            error: function(xhr, textStatus, errorThrown) {
                $("#changebody").html("Алдаа гарлаа !");
            },
            beforeSend: function() {
                $("#changebody").html("Түр хүлээнэ үү ...");
            },
            success: function(data) {
                $("#changebody").html(data);
            },
            async: true
        });*/
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>