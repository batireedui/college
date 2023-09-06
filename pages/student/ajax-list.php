<?php
if (isset($_SESSION['user_id'])) {
    _select(
        $stmt,
        $count,
        "SELECT students.id, students.code, students.fname, students.lname, students.gender, students.phone, students.class, students.pass, students.tuluv, class.name  
            FROM students INNER JOIN class ON students.class = class.id WHERE students.tuluv=?",
        "i",
        [1],
        $id,
        $code,
        $fname,
        $lname,
        $gender,
        $phone,
        $class,
        $pass,
        $tuluv,
        $cname
    );
?>
    <table class="table table-bordered" id="datalist">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Эцэг/эхийн нэр</th>
                <th>Нэр</th>
                <th>Утас</th>
                <th>Хүйс</th>
                <th>РД</th>
                <th>Анги</th>
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
                    <td id="f4-<?= $id ?>"><?= $gender ?></td>
                    <td id="f5-<?= $id ?>"><?= $code ?></td>
                    <td id="f6-<?= $id ?>" style="font-size: 10px;"><?= $cname ?></td>
                    <td id="f7-<?= $id ?>" style="display: none"><?= $email ?></td>
                    <td id="f8-<?= $id ?>" style="display: none"><?= $user_role ?></td>
                    <td id="f9-<?= $id ?>" style="display: none"><?= $tuluv ?></td>
                    <td id="f10-<?= $id ?>" style="display: none"><?= $class ?></td>
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