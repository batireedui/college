<?php
if (isset($_SESSION['user_id'])) {
    _select(
        $stmt,
        $count,
        "SELECT id, fname, lname, phone, email, at, pass, user_role, tuluv FROM teacher WHERE tuluv=?",
        "i",
        [1],
        $id,
        $fname,
        $lname,
        $phone,
        $email,
        $at,
        $pass,
        $user_role,
        $tuluv
    );
?>
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Эцэг/эхийн нэр</th>
                <th>Нэр</th>
                <th>Утас</th>
                <th>E-mail</th>
                <th>Албан тушаал</th>
                <th></th>
            </tr>
        </thead>
        <?php if ($count > 0) : ?>
            <?php $too = 0;
            while (_fetch($stmt)) :
                $too++ ?>
                <tr>
                    <td><?= $too ?></td>
                    <td id="f1-<?= $id ?>"><?= $fname ?></td>
                    <td id="f2-<?= $id ?>"><?= $lname ?></td>
                    <td id="f3-<?= $id ?>"><?= $phone ?></td>
                    <td id="f4-<?= $id ?>"><?= $email ?></td>
                    <td id="f5-<?= $id ?>"><?= $at ?></td>
                    <td id="f6-<?= $id ?>" style="display: none"><?= $user_role ?></td>
                    <td id="f7-<?= $id ?>" style="display: none"><?= $tuluv ?></td>
                    <td>
                        <i class="fas fa-trash m-1" type="button" data-mdb-toggle="modal" data-mdb-target="#delete" onclick="deleteBtn(<?= $id ?>)"></i>
                        <i class="fas fa-pen-to-square" type="button" data-mdb-toggle="modal" data-mdb-target="#change" onclick="editBtn(<?= $id ?>)"></i>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>
<?php
}
?>