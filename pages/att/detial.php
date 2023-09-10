<?php
if (isset($_SESSION['user_id'])) {
    $id = $_POST['id'];
    _selectRow(
        "SELECT classid, att.tid, lessonid, ognoo, cagid, irc, bich, sedev, niit, v1, v2, v3, v4, 
                att.tuluv, tlesson.lessonName, teacher.fname, teacher.lname, cag.name, cag.inter, tlesson.cag FROM att 
                INNER JOIN tlesson ON att.lessonid = tlesson.id 
                    INNER JOIN teacher ON att.tid = teacher.id
                        INNER JOIN cag ON att.cagid = cag.id
                             WHERE att.id=?",
        "i",
        [$id],
        $classid,
        $tid,
        $lessonid,
        $ognoo,
        $cagid,
        $irc,
        $bich,
        $sedev,
        $niit,
        $v1,
        $v2,
        $v3,
        $v4,
        $tuluv,
        $lessonName,
        $fname,
        $lname,
        $cag,
        $inter,
        $tlesson_cag
    );

    _select(
        $stmt,
        $count,
        "SELECT students.id, students.code, students.fname, students.lname, students.gender, students.tuluv  
            FROM students WHERE students.class = '$classid' and students.tuluv=?",
        "i",
        [1],
        $sid,
        $code,
        $sfname,
        $slname,
        $gender,
        $tuluv
    );

    $irc = json_decode($irc);
?>
    <div class="badge badge-secondary mb-3"><?= $ognoo ?>, <?= dayofweek($ognoo); ?>, <?= $cag ?> (<?= $inter ?>)</div>
    <div class="mb-3"><?= $fname ?> <?= $lname ?> (<?= $lessonName ?>, <?= $tlesson_cag ?> цаг)</div>
    <div class="mb-3">Сэдэв: <?= $sedev ?></div>
    <span class="badge badge-primary m-1">Нийт: <?= $niit ?></span>
    <span class="badge badge-success m-1">Ирсэн: <?= $v1 ?></span>
    <span class="badge badge-info m-1">Чөлөөтэй: <?= $v3 ?></span>
    <span class="badge badge-danger m-1">Тасалсан: <?= $v4 ?></span>
    <span class="badge badge-warning m-1">Өвчтэй: <?= $v2 ?></span>
    <table class="table table-bordered" id="datalist">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Эцэг/эхийн нэр</th>
                <th>Нэр</th>
                <th>Ирц</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($count > 0) : ?>
                <?php $too = 0;
                while (_fetch($stmt)) :
                    $sval = 0;
                    foreach ($irc as $key => $el) {
                        if ($el->id == $sid) {
                            $sval = $el->val;
                            break;
                        }
                    }
                    $too++ ?>
                    <tr>
                        <td><?= $too ?></td>
                        <td id="tf1-<?= $sid ?>"><?= $sfname ?></td>
                        <td id="tf2-<?= $sid ?>"><?= $slname ?></td>
                        <td id="tf3-<?= $sid ?>"><span class="badge badge-<?= @$tuluvColor[$sval]?>"><?= @$tuluvIrc[$sval] ?></span></td>
                    </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
<?php

}
?>