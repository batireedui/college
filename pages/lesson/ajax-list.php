<?php
if (isset($_SESSION['user_id'])) {
    _select(
        $stmt,
        $count,
        "SELECT id, lessonName, cag, tuluv FROM tlesson WHERE tid=?",
        "i",
        [$_SESSION['user_id']],
        $id,
        $name,
        $cag,
        $tuluv
    );
?>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Хичээлийн нэр</th>
                <th>Цаг</th>
                <th>Төлөв</th>
                <th></th>
            </tr>
        </thead>
        <?php if ($count > 0) : ?>
            <?php $too = 0;
            while (_fetch($stmt)) :
                $too++ ?>
                <tr>
                    <td><?= $too ?></td>
                    <td id="f1-<?= $id ?>"><?= $name ?></td>
                    <td id="f2-<?= $id ?>"><?= $cag ?></td>
                    <td id="f3-<?= $id ?>">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $id ?>, this)" <?php echo $tuluv > 0 ? "checked" : "" ?> />
                        </div>
                    </td>
                    <td>
                        <!--<i class="fas fa-trash m-1 fa-lg text-danger" type="button" data-mdb-toggle="modal" data-mdb-target="#delete" onclick="deleteBtn(<?= $id ?>)"></i>-->
                        <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#change" onclick="editBtn(<?= $id ?>)"></i>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>
<?php
}
?>