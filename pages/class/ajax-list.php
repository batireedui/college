<?php
if (isset($_SESSION['user_id'])) {
    _select(
        $stmt,
        $count,
        "SELECT id, sname, name, hugacaa, tuluv, teacherid, last_on FROM class WHERE class.tuluv=? ORDER BY sname",
        "i",
        ['1'],
        $id,
        $sname,
        $name,
        $hugacaa,
        $tuluv,
        $teacherid,
        $last_on
    );
?>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Анги</th>
                <th>Мэргэжил</th>
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
                    <td id="f0-<?= $id ?>"><?= $sname ?></td>
                    <td id="f1-<?= $id ?>"><?= $name ?></td>
                    <td id="f2-<?= $id ?>"><?= $hugacaa ?></td>
                    <td id="f4-<?= $id ?>">
                        <span onclick="setTeacher(<?php echo  $t_id == 0 ? '0' : $t_id ?>, <?= $id ?>)" class="badge badge-success" type="button" data-mdb-toggle="modal" data-mdb-target="#change">
                            <?php
                            echo  $t_id == 0 ? "Багшгүй" : $t_fname . " <span class='text-uppercase'>" . $t_lname . "</span>";
                            ?>
                        </span>
                    </td>
                    <td>
                    </td>
                    <th>
                        <i class="fas fa-trash m-1 fa-lg text-danger" type="button" data-mdb-toggle="modal" data-mdb-target="#delete" onclick="deleteBtn(<?= $id ?>)"></i>
                        <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#change" onclick="setTeacher(<?php echo  $t_id == 0 ? '0' : $t_id ?>, <?= $id ?>)"></i>
                        <span class="alert alert-warning" role="button" onclick="grad(<?= $id ?>, '<?= $sname ?>, <?= $name ?>')">ТӨГСӨЛТ<?=$last_on?></span>
                    </th>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>
<?php
}
?>