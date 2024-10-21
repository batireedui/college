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
$sql = "";
$name = "";
$name1 = "";
$name = $_GET['name'];
$name1 = $_GET['name1'];
$id = $_GET['id'];
$id1 = $_GET['ids'];
$jil = $_GET['jil'];

$table = "s_sudalgaas";
$h_jil = $this_on;

if($jil != $h_jil){
    $table = $table . substr($jil, 0, 4);
}

_selectNoParam(
        $stmt,
        $count,
        "SELECT students.fname, students.lname, students.gender, concat(class.sname, class.name) FROM `$table` 
        INNER JOIN students ON $table.student_id = students.id
        INNER JOIN class on students.class = class.id 
        WHERE $table.shalguur_id='$id' AND $table.value=1 $sql AND student_id IN 
            (SELECT DISTINCT student_id FROM `$table` INNER JOIN students ON $table.student_id = students.id WHERE $table.shalguur_id='$id1' AND $table.value=1 $sql)",
        $fname,
        $lname,
        $gander,
        $angi
    );
$columnNumber = 9;
?>
        <!-- Basic Bootstrap Table -->
        <div class="card" style="padding: 20px;">
            <div class="row gy-3">
                <!-- Default Modal -->
                <div class="col-lg-12 col-sm-12">
                    <h5>Шалгуур-1: <?= $name1 ?> (<?= $count ?>)</h5>
                </div>
                <div class="col-lg-12 col-sm-12">
                    <h5>Шалгуур-2: <?= $name ?> (<?= $count ?>)</h5>
                </div>
                <div class="col-lg-6 col-sm-12" style="text-align: end">
            </div>
            <div class="table-responsive text-nowrap">
                <table class="display" id="datalist">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Эцэг/эх-ийн нэр</th>
                            <th>Нэр</th>
                            <th>Хүйс</th>
                            <th>Анги</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <?php if ($count > 0) : ?>
                            <?php $too = 0;
                            while (_fetch($stmt)) : $too++ ?>
                                <tr>
                                    <td><?= $too ?></td>
                                    <td id="f1-<?= $id ?>"><?= $fname ?></td>
                                    <td id="f2-<?= $id ?>"><?= $lname ?></td>
                                    <td id="f3-<?= $id ?>"><?= $gander ?></td>
                                    <td id="f4-<?= $id ?>"><?= $angi ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php require ROOT . "/pages/footer.php"; ?>
        <?php require ROOT . "/pages/dataTablefooter.php"; ?>
        <script type="text/javascript">

        </script>
        <?php require ROOT . "/pages/end.php"; ?>