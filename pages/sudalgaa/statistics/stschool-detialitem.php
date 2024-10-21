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
$jil = $this_on;
$get_id = $_GET["id"];

_selectNoParam(
    $stmt,
    $count,
    "SELECT students.id, fname, lname, gender, class.sname, class.id FROM students INNER JOIN class ON students.class = class.id WHERE students.class = '$get_id' and students.tuluv=1 " . $sql,
    $id,
    $fname,
    $lname,
    $gender,
    $angi,
    $angi_id
);
$columnNumber = 9;
?>
<!-- Basic Bootstrap Table -->
<div class="card" style="padding: 20px;">
    <div class="row gy-3">
        <!-- Default Modal -->
        <div class="col-lg-6 col-sm-12">
            <div class="col-sm-6:eq(0)"></div>
            <h4 class="fw-bold py-3 mb-4">Судалгаа бүртгэх - Сурагчид (<?= $count ?>)</h4>
        </div>
    </div>
    <div></div>
    <div class="table-responsive text-nowrap">
        <table class="display" id="datalist">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Эцэг/эх-ийн нэр</th>
                    <th>Нэр</th>
                    <th>Хүйс</th>
                    <th>Анги</th>
                    <th></th>
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
                            <td id="f4-<?= $id ?>"><?= $gender ?></td>
                            <td id="f6-<?= $id ?>" data-aid="<?= $angi_id ?>"><?= $angi ?></td>
                            <td>
                                <?php
                                $count_sid = 0;
                                _selectRowNoParam(
                                    "SELECT DISTINCT(student_id) FROM `s_sudalgaas` WHERE student_id = '$id' and jil = '$jil'",
                                    $count_sid
                                );
                                if ($count_sid > 0) {
                                    echo "<a href='/sudalgaa/insertsudalgaa?id=$id&angi=$angi&type=1'>
                                                    <div class='btn btn-warning'>Засах</div>
                                                </a>";
                                } else {
                                    echo "<a href='/sudalgaa/insertsudalgaa?id=$id&angi=$angi&type=0'>
                                                    <div class='btn btn-primary'>Судалгаа бөглөх</div>
                                                </a>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require ROOT . "/pages/footer.php"; ?>
<?php require ROOT . "/pages/dataTablefooter.php"; ?>
<?php require ROOT . "/pages/end.php"; ?>