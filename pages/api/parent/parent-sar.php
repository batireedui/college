<?php
if (isset($_POST['classid'])) {
    $classid = $_POST['classid'];
    $student_id = $_POST['student_id'];

    _selectRowNoParam(
        "SELECT teacher.fname, teacher.lname, teacher.phone FROM `class` INNER JOIN teacher ON class.teacherid = teacher.id WHERE class.id ='$classid'", 
        $fname, $lname, $phone
        );

    _selectNoParam(
        $cstmt,
        $ccount,
        "SELECT YEAR(ognoo), MONTH(ognoo) FROM `att` WHERE classid = $classid GROUP BY MONTH(ognoo), YEAR(ognoo) ORDER BY ognoo DESC",
        $YEAR,
        $MONTH
    );
    ?>
    <div class="alert alert-info">Багш: <?=substr($fname, 0, 2)?>.<?=$lname?> (Утас: <?=$phone?>)</div>
    <?php
    while (_fetch($cstmt)) : ?>
            <input type="radio" class="btn-check" name="primary-outlined" id="sar<?php echo $student_id .$YEAR.$MONTH; ?>" onchange="detial(<?= $student_id ?>, <?= $YEAR ?>, <?= $MONTH ?>)" autocomplete="off">
            <label class="btn btn-outline-primary btn-sm m-1" for="sar<?php echo $student_id .$YEAR.$MONTH; ?>"><?= $YEAR ?>-<?= $MONTH ?></label>
    <?php endwhile; ?>
<?php } ?>