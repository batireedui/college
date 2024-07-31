<?php
if (isset($_POST['id'])) {
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
        "SELECT ognoo, name, irc, lessonName, lname, fname FROM att 
        INNER JOIN tlesson ON att.lessonid = tlesson.id 
        INNER JOIN teacher ON att.tid = teacher.id 
        INNER JOIN cag ON att.cagid = cag.id 
        WHERE ognoo BETWEEN '$start' and '$last' and irc LIKE " . '\'%{"id":"' . $id . '",%\''. " ORDER BY ognoo, cag.name",
        $ognoo,
        $cag,
        $irc,
        $lessonName,
        $lname,
        $fname
    );
?>
    <div class="mb-3"><?= str_replace("-", ".", $start) ?>-<?= str_replace("-", ".", $last) ?> (ИРЦИЙН ХУВЬ)</div>
    <div class="progress m-3" id="tas" style="height: 20px;">
      
    </div>
    <table class="table table-bordered" id="datalist">
        <thead class="table-light">
            <tr>
                <th>№</th>
                <th>Огноо</th>
                <th>Ирц</th>
            </tr>
        </thead>
        <tbody>
            <?php $too = 0; $tas = 0;
            while (_fetch($lstmt)) :
                $irc = json_decode($irc);
                $too++ ?>
                <tr>
                    <td><?= $too ?></td>
                    <td id="tf1-<?= $sid ?>"><?= str_replace("-", ".", $ognoo) ?>, <?= $cag ?> <br> <span style='font-size: 12px'>( <?=$lessonName?>, <?= substr($fname, 0, 2)?>.<?=$lname?>)</span></td>
                    <td id="tf3-<?= $sid ?>">
                        <?php
                        foreach ($irc as $key => $el) {
                            if ($el->id == $sid){
                                echo "<span style='font-size: 12px;' class='alert alert-" .$tuluvColor[$el->val] . "'>" . $tuluvIrc[$el->val] . "</span";
                                if($el->val == 4) $tas++;
                            }
                        }
                        ?>
                    </td>
                </tr>
            <?php endwhile; 
            $huvi = 100;
            if($too>0)
                $huvi = intval(($too - $tas)/$too*100);
            ?>
        </tbody>
    </table>
    <script>
        document.getElementById("tas").innerHTML = '<div class="progress-bar bg-danger" role="progressbar" style="width: <?=$huvi?>%;" aria-valuenow="<?=$huvi?>" aria-valuemin="0" aria-valuemax="100"><?=$huvi?>%</div>';
    </script>
<?php

}
?>