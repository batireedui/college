<?php require ROOT . "/pages/start.php"; ?>
<link rel="stylesheet" type="text/css" href="/assets/css/dataTable.css">
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
    "SELECT schools.id, school_name, (SELECT COUNT(students.id) FROM students WHERE students.tuluv = 0 and students.school_id = schools.id), (SELECT COUNT(DISTINCT student_id) FROM sudalgaas INNER JOIN students ON sudalgaas.student_id = students.id WHERE students.tuluv = 0 and students.school_id = schools.id) FROM `schools`",
    $school_id,
    $school_name,
    $students_too,
    $ch_too
);
$schools = array();
$yes_too = 0;
$no_too = 0;
while (_fetch($stmt)) {
    $yes_too += $ch_too;
    $no_too += $students_too;
    array_push($schools, [$school_id, $school_name, $students_too, $ch_too]);
}
$no_too = $no_too - $yes_too;
?>

<div class="layout-page">
    <!-- Navbar -->
    <?php require ROOT . "/pages/navbar.php";
    ?>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-6 col-sm-12">
                    <div class="col-sm-6:eq(0)"></div>
                    <h4 class="fw-bold py-3 mb-4">Сургууль</h4>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNew">
                        Сурагч бүртгэх
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-lg-6 col-xl-6 order-0 mb-4">
                    <div id="barChart"></div>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-12 order-0 mb-4">
                    <div id="barChart">sdfsdf</div>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Сургуулийн нэр</th>
                            <th>Судалгаанд хамрагдаагүй</th>
                            <th>Судалгаанд хамрагдсан</th>
                            <th>Хувь</th>
                            <th>Нийт</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php $too = 0;
                        foreach ($schools as $sch) : $too++ ?>
                            <tr>
                                <td><?= $too ?></td>
                                <td><?= $sch[1] ?></td>
                                <td><?= (int)$sch[2] - (int)$sch[3] ?></td>
                                <td><?= $sch[3] ?></td>
                                <td><?= @round(($sch[3] / $sch[2]) * 100, 2) ?>%</td>
                                <td><?= $sch[2] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            chart();

            function chart() {
                var options = {
                    series: [44, 55, 13, 43, 22],
                    chart: {
                        width: 380,
                        type: 'pie',
                    },
                    labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#barChart"), options);
                chart.render();
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>