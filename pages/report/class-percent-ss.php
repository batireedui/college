<?php
if (isset($_SESSION['user_id'])) {
    $start = @$_POST['sdate'];
    $last = @$_POST['ldate'];

    _selectNoParam(
        $cstmt,
        $ccount,
        "SELECT COUNT(att.id), classid, class.sname, class.name FROM `att` INNER JOIN class ON att.classid = class.id  
                        WHERE class.tuluv = 1 and ognoo BETWEEN '$start' and '$last' GROUP BY classid ORDER BY COUNT(att.id) DESC, sname ASC",
        $cag,
        $classid,
        $sname,
        $name
    );
?>
    <h3 style='text-align: center;'>ИРЦИЙН ГҮЙЦЭТГЭЛ</h3>
    <div style="display: flex;justify-content: space-between;">
        <div>Хугацаа: <?= $start ?> өдрөөс <?= $last ?></div>
        <div>Хэвлэсэн: <?= date("Y.m.d H:i") ?></div>
    </div>

    <table class="table table-bordered table-hover" id="datalist">
        <tdead style="position: sticky; top: 0; background-color: #dddfff;z-index: 1000;">
            <tr>
                <td>№</td>
                <td>АНГИ</td>
                <td style='text-align: center'>ХИЧЭЭЛ ОРСОН ЦАГ</td>
            </tr>
        </tdead>
        <tbody>
            <?php
            $k = 0;
            while (_fetch($cstmt)) {
                $k++; ?>
                <tr class="table_rows" data-mdb-toggle="modal" data-mdb-target="#detialmain" role="button" id="trow-<?= $classid ?>" onclick="detial(<?= $classid ?>)">
                    <td><?= $k ?></td>
                    <td><?= $sname ?> <?= $name ?></td>
                    <td style='text-align: center'><span class='alert alert-primary'><?= $cag * 2 ?> цаг</span></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
<?php

}
