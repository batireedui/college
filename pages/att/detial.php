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
?>
    <div class="badge badge-secondary mb-3"><?= $ognoo ?> <?= $cag ?> (<?= $inter ?>)</div>
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
                <th>Утас</th>
                <th>Хүйс</th>
                <th>РД</th>
                <th>Анги</th>
                <th></th>
            </tr>
        </thead>
    </table>
<?php

}
?>