<?php require ROOT . "/pages/start.php"; ?>
<link rel="stylesheet" type="text/css" href="/css/dataTable.css">
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<?php
require ROOT . "/pages/header.php";
_selectNoParam(
    $stmt,
    $count,
    "SELECT class.id, class.sname, class.name, COUNT(students.id) FROM students 
    INNER JOIN class ON students.class = class.id 
    WHERE class.tuluv = 1 and students.tuluv = '1' GROUP BY class.id",
    $angi_id,
    $angi_name,
    $angi_buleg,
    $st_too
);
$schools = array();

$h_jil = $this_on;
/*
while (_fetch($stmt)) {
    array_push($schools, [$angi_id, $angi_name, $st_too]);
}
*/?>
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4">Судалгаанд хамрагдсан статистик ангиудаар</h4>
                </div>
            </div>
            <div id="barChart"></div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Ангийн нэр</th>
                            <th>Судалгаанд хамрагдсан</th>
                            <th>Нийт</th>
                            <th>Хувь</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $too = 0;
                        while (_fetch($stmt)) : $too++;
                            _selectRowNoParam(
                                "SELECT COUNT(DISTINCT s_sudalgaas.student_id) FROM s_sudalgaas INNER JOIN students ON s_sudalgaas.student_id = students.id WHERE jil = '$h_jil' and students.class = '$angi_id'",
                                $i_too
                            );
                        ?>
                            <tr>
                                <td><?= $too ?></td>
                                <td><a href="stschool-detialitem?id=<?= $angi_id ?>"><?= $angi_name. " " . $angi_buleg ?></a></td>
                                <td><?= $i_too ?></td>
                                <td><?= $st_too  ?></td>
                                <td><?= round(($i_too/$st_too) * 100, 2) ?>%</td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <?php require ROOT . "/pages/end.php"; ?>