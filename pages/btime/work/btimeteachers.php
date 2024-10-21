<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'] ?? 0;
    if ($mode == "getteachers") {
        $year = $_POST['year'] ?? $thison;
        $month = $_POST['month'] ?? $thismonth;

        _selectNoParam(
            $st,
            $cc,
            "SELECT teacher.id, teacher.fname, teacher.lname, teacher.zereg, tzereg.bnorm FROM `teacher` INNER JOIN tzereg ON teacher.zereg = tzereg.id WHERE teacher.tuluv = '1' AND teacher.user_role = '1' ORDER BY lname",
            $t_id,
            $t_fname,
            $t_lname,
            $t_zereg,
            $t_bnorm
        ); ?>
        <table id="datalistnobtn" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 10px;">№</th>
                    <th>Нэр</th>
                    <th>КР</th>
                    <th>Норм</th>
                </tr>
            </thead>
            <?php
            $dd = 1;
            while (_fetch($st)) {
            ?>
                <tr role="button" class="table_rows" id="trow-<?= $t_id ?>" onclick="get(<?= $t_id ?>)">
                    <td><?= $dd ?></td>
                    <td id="<?= $t_id ?>-ner"><?= substr(trim($t_fname), 0, 2) ?>.<?= $t_lname ?></td>
                    <td id="<?= $t_id ?>-cr">
                        <?php
                        _selectRowNoParam(
                            "SELECT sum(credit) as kr FROM btime_user WHERE user_id='$t_id' AND year = '$year' AND month = '$month'",
                            $kr
                        );
                        echo $kr ?? 0;
                        ?>
                    </td>
                    <td id="<?= $t_id ?>-norm"><?= $t_bnorm ?></td>
                </tr>
            <?php $dd++;
            }
            ?>
        </table>
<?php
        require ROOT . "/pages/dataTableNobtn.php";
    }
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
