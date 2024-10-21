<?php
$h_jil = $_SESSION['jil'];
$angi_id = $_POST["id"];
_selectNoParam(
    $stmt,
    $count,
    "SELECT DISTINCT shalguurs.id, shalguurs.name, shalguurs.ded, shalguurs.hariulttype, shalguurs.turul FROM `shalguurs` WHERE shalguurs.tuluv = 1 ORDER BY  shalguurs.id;",
    $shalguur_id,
    $shalguur_name,
    $shalguur_ded,
    $hariulttype,
    $shalguurs_turul
);
$shalguurs = array();
while (_fetch($stmt)) {
    array_push($shalguurs, [$shalguur_id, $shalguur_name, $shalguur_ded, $hariulttype, $shalguurs_turul]);
}
?>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $d = 0;
            _selectNoParam(
                $st,
                $co,
                "SELECT shalguurs.name, shalguur_id, COUNT(DISTINCT student_id) FROM `sudalgaas` INNER JOIN students ON sudalgaas.student_id = students.id INNER JOIN shalguurs ON sudalgaas.shalguur_id = shalguurs.id WHERE students.angi_id='$angi_id' and sudalgaas.value = '1' GROUP by shalguur_id",
                $shalguur,
                $sh_id,
                $val_too
            );
            while (_fetch($st)) {
                $d++; ?>
                <tr>
                    <td style="text-align: left;"><?= $d ?>) <?= $shalguur ?></td>
                    <td><button class="btn btn-danger"><?= $val_too ?></button></td>
                <tr>
                <?php } ?>
        </tbody>
    </table>
</div>