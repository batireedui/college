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
$h_jil = $_SESSION['jil'];
$sql = "";
if($user_role == "najiltan"){
    $sql = " WHERE schools.id = $school_id";
}
_selectNoParam(
    $stmt,
    $count,
    "SELECT schools.id, school_name, (SELECT COUNT(students.id) FROM students WHERE students.tuluv = 0 and students.school_id = schools.id), (SELECT COUNT(DISTINCT student_id) FROM sudalgaas INNER JOIN students ON sudalgaas.student_id = students.id WHERE jil = '$h_jil' and students.tuluv = 0 and students.school_id = schools.id) FROM `schools` $sql",
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
            </div>
            <div id="barChart"></div>
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
                                <td><a href="/statistics/stschool-detial?id=<?= $sch[0] ?>"><?= $sch[1] ?></a></td>
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
                    series: [{
                            name: 'Судалгаанд хамрагдсан <?= $yes_too ?>',
                            data: [
                                <?php foreach ($schools as $sch) {
                                    echo $sch[3] . ", ";
                                } ?>
                            ]
                        },
                        {
                            name: 'Судалгаанд хамрагдаагүй <?= $no_too ?>',
                            data: [
                                <?php foreach ($schools as $sch) {
                                    echo (int)$sch[2] - (int)$sch[3] . ", ";
                                } ?>
                            ]
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 350,
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                        zoom: {
                            enabled: true
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            legend: {
                                position: 'bottom',
                                offsetX: -10,
                                offsetY: 0
                            }
                        }
                    }],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 10
                        },
                    },
                    xaxis: {
                        type: 'string',
                        categories: [<?php foreach ($schools as $sch) {
                                            echo "'$sch[1]', ";
                                        } ?>],
                    },
                    legend: {
                        position: 'right',
                        offsetY: 40
                    },
                    fill: {
                        opacity: 1
                    },
                    title: {
                        text: "СУДАЛГАА БҮРТГЭСЭН БАЙДАЛ - (<?=$h_jil?>)",
                        align: 'center',
                        style: {
                            fontSize: '18px',
                            fontWeight: 'bold',
                            color: '#263238'
                        },
                    }
                };

                var chart = new ApexCharts(document.querySelector("#barChart"), options);
                chart.render();
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>