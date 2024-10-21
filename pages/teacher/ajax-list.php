<?php
if (isset($_SESSION['user_id'])) {
    _selectNoParam(
        $stmt,
        $count,
        "SELECT teacher.id, teacher.fname, teacher.lname, teacher.phone, teacher.email, teacher.at, teacher.pass, teacher.user_role, teacher.tuluv, teacher.office_id, teacher.department_id, at.name FROM teacher INNER JOIN at ON teacher.user_role = at.id ORDER BY lname",
        $id,
        $fname,
        $lname,
        $phone,
        $email,
        $at,
        $pass,
        $user_role,
        $tuluv,
        $office_id,
        $department_id,
        $user_type
    );
    
    _select(
        $ostmt,
        $ocount,
        "SELECT id, name FROM office WHERE tuluv=?",
        "i",
        [1],
        $oid,
        $oname
    );
    
    _select(
        $dstmt,
        $dcount,
        "SELECT id, name FROM department WHERE tuluv=?",
        "i",
        [1],
        $did,
        $dname
    );
    $oarray = array();
    $darray = array();
    while(_fetch($ostmt)) {
        $orow = new stdClass();
        $orow->oid = $oid;
        $orow->oname = $oname;
        array_push($oarray, $orow);
    }
    
    while(_fetch($dstmt)) {
        $orow = new stdClass();
        $orow->did = $did;
        $orow->dname = $dname;
        array_push($darray, $orow);
    }
?>
    <table class="table table-bordered table-hover" id="datalist">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th></th>
                <th>Эцэг/эхийн нэр</th>
                <th>Нэр</th>
                <th>Утас</th>
                <th>E-mail</th>
                <th>Төрөл</th>
                <th>Албан тушаал</th>
                <th>Алба</th>
                <th>Хэлтэс</th>
                <th style="display: none"></th>
                <th>Төлөв</th>
                <th></th>
                <th></th>
                <th></th>
                <?php if (checkErh(5, $_SESSION['user_role'], $_SESSION['user_id'])) {
                    echo "<th></th>";
                 }?>
            </tr>
        </thead>
        <?php if ($count > 0) : ?>
            <?php $too = 0;
            while (_fetch($stmt)) :
                $too++ ?>
                <tr>
                    <td><?= $too ?></td>
                    <td role="button" class="text-center" data-mdb-toggle="modal" data-mdb-target="#imagechange" onclick="imageBtn(<?= $id ?>)">
                        <?php if(file_exists(ROOT . "/www/images/users/$id-t.jpg")) { ?>
                            <img src="/images/users/<?=$id?>-t.jpg" id="imageList-<?= $id ?>" class="rounded-circle cover" height="30" loading="lazy" width="30">
                        <?php } else { ?>
                            <img src="/images/user.jpg" id="imageList-<?= $id ?>" class="rounded-circle cover" height="30" loading="lazy" width="30">
                        <?php } ?>
                    </td>
                    <td id="f1-<?= $id ?>"><?= $fname ?></td>
                    <td id="f2-<?= $id ?>"><?= $lname ?></td>
                    <td id="f3-<?= $id ?>"><?= $phone ?></td>
                    <td id="f4-<?= $id ?>"><?= $email ?></td>
                    <td id="f9-<?= $id ?>"><small class="badge badge-info"><?=$user_type?></td>
                    <td id="f5-<?= $id ?>"><?= $at ?> </small></td>
                    <td id="f8-<?= $id ?>"><?php
                        foreach ($oarray as $e) {
                             if($e->oid == $office_id)
                             {
                                 echo $e->oname;
                             }
                        }
                        ?>
                    </td>
                    <td id="f9-<?= $id ?>">
                        <?php
                        foreach ($darray as $e) {
                             if($e->did == $department_id)
                             {
                                 echo $e->dname;
                             }
                        }
                        ?>
                    </td>
                    <td id="f6-<?= $id ?>" style="display: none"><?= $user_role ?></td>
                    <td id="f7-<?= $id ?>"><span class="alert alert-<?= $tuluvColor[$tuluv] ?>"><?= $tuluv_Teacher[$tuluv] ?></span></td>
                    <?php if (checkErh(6, $_SESSION['user_role'], $_SESSION['user_id'])) { ?>
                    <td>
                        <i class="fas fa-key m-1 fa-lg text-danger" type="button" onclick="pass(<?= $id ?>, '<?=$fname?> <?=$lname?>')"></i>
                    </td>
                    <?php } ?>
                    <td>
                        <i class="fa-solid fa-image text-success" type="button" data-mdb-toggle="modal" data-mdb-target="#imagechange" onclick="imageBtn(<?= $id ?>)"></i>
                    </td>
                    <td>
                        <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#change" onclick="editBtn(<?= $id ?>, '<?= $tuluv ?>', '<?= $office_id ?>', '<?= $department_id ?>')"></i>
                    </td>
                    <td>
                        <i class="fas fa-trash m-1 fa-lg text-danger" type="button" data-mdb-toggle="modal" data-mdb-target="#delete" onclick="deleteBtn(<?= $id ?>)"></i>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php endif; ?>
    </table>
<?php
}
?>