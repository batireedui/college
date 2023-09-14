<?php
if (isset($_SESSION['user_id'])) {
    $id = $_POST['id'];
    $son = @$_POST['son'];
    $ssar = @$_POST['ssar'];
    $lon = @$_POST['lon'];
    $lsar = @$_POST['lsar'];

    $last = date("Y-m-t", strtotime("$lon-$lsar-1"));
    $start = date("Y-m-d", strtotime("$son-$ssar-1"));
    _selectRowNoParam(
        "SELECT students.id, students.code, students.fname, students.lname  
            FROM students WHERE students.id = '$id' and students.tuluv=1",
        $sid,
        $code,
        $sfname,
        $slname
    );

    _selectNoParam(
        $lstmt,
        $lcount,
        "SELECT ognoo, cagid, irc FROM att WHERE ognoo BETWEEN '$start' and '$last' and irc LIKE " . '\'%{"id": "' . $id . '"%\'',
        $ognoo,
        $cag,
        $irc
    );
?>
    <div class="mb-3"><?= $sfname ?> <?= $slname ?> (<?= $start ?> - <?= $last ?>)</div>
    <table class="table table-bordered" id="datalist">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Огноо</th>
                <th>Цаг</th>
                <th>Ирц</th>
            </tr>
        </thead>
        <tbody>
            <?php $too = 0;
            while (_fetch($lstmt)) :
                $irc = json_decode($irc);
                $too++ ?>
                <tr>
                    <td><?= $too ?></td>
                    <td id="tf1-<?= $sid ?>"><?= $ognoo ?></td>
                    <td id="tf2-<?= $sid ?>"><?= $cag ?></td>
                    <td id="tf3-<?= $sid ?>">
                        <?php
                        foreach ($irc as $key => $el) {
                            if ($el->id == $sid)
                                echo "<span class='alert alert-" .$tuluvColor[$el->val] . "'>" . $tuluvIrc[$el->val] . "</span";
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php

}
?>