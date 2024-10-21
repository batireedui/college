<?php
$h_jil = $this_on;
$id = $_POST['id'];
$jil = $_POST['jil'];

$table = "s_sudalgaas";

if($jil != $h_jil){
    $table = $table . substr($jil, 0, 4);
}

$where = "";

_selectNoParam(
    $stmt,
    $count,
    "SELECT DISTINCT s_shalguurs.id, s_shalguurs.name, s_shalguurs.ded, s_shalguurs.hariulttype, s_shalguurs.turul FROM `s_shalguurs` WHERE s_shalguurs.tuluv = 1 ORDER BY  s_shalguurs.id;",
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

$schools = array();
    _selectNoParam(
        $stmts,
        $counst,
        "SELECT id, sname FROM `class` WHERE class.tuluv=1 ORDER BY sname",
        $s_id,
        $s_name
    );
    while (_fetch($stmts)) {
        array_push($schools, [$s_id, $s_name]);
    }

?>

<style>
    .rotate {
        padding: .5rem;
        position: relative;
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        white-space: nowrap;
        -webkit-writing-mode: vertical-rl;
        writing-mode: vertical-rl;
    }

    th {
        vertical-align: bottom;
        border: 1px solid #697a8d;
    }

    table td,
    table th {
        border: 1px solid #697a8d;
        padding: .5rem .75rem;
    }
</style>
<div class="table-responsive text-nowrap m-3">
    <table class="table-header-rotated">
        <thead class="table-light">
            <tr>
                <th></th>
                <?php $d = 0;
                foreach ($shalguurs as $key => $val) : $d++; ?>
                    <th colspan="2">
                        <div class="rotate"><?php echo $d . ") " . $val[1] ?></div>
                    </th>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody class="table-border-bottom-0">
            <?php 
                foreach ($schools as $skey => $sval) {
                ?>
                    <tr>
                        <td><?= $sval[1] ?></td>
                        <?php
                        foreach ($shalguurs as $key => $val) :
                            _selectRowNoParam(
                                "SELECT COUNT(DISTINCT $table.student_id) FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $table.value = '1' and $table.shalguur_id = $val[0] and students.class = $sval[0]",
                                $val_too
                            );
                            echo "<td colspan='2'>$val_too</td>";
                        ?>
                        <?php endforeach ?>
                    </tr>
            <?php }
         ?>
        </tbody>
    </table>
</div>