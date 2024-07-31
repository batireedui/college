<?php
if (isset($_SESSION['user_id'])) {
    $mode = @$_POST['mode'];
    if ($mode == 1) {
        $class = @$_POST['class'];
        $son = @$_POST['son'];
        $ssar = @$_POST['ssar'];
        $lon = @$_POST['lon'];
        $lsar = @$_POST['lsar'];

        $stid = "0";
        $tid = @$_POST['tid'];;

        _selectNoParam(
            $cstmt,
            $ccount,
            "SELECT class.name, tclass.classid, sname FROM tclass INNER JOIN class ON tclass.classid = class.id WHERE tuluv=1 and tclass.tid = '$tid'",
            $class_name,
            $class_id,
            $sname
        );

        while (_fetch($cstmt)) {
            echo "<option value='$class_id'>$sname $class_name</option>";
        }
    } else if ($mode == 2) {
        $class = @$_POST['class'];
        $tid = @$_POST['tid'];;

        _selectNoParam(
            $cstmt,
            $ccount,
            "SELECT att.lessonid, tlesson.lessonName, tlesson.cag FROM `att` 
                INNER JOIN tlesson ON att.lessonid = tlesson.id 
                    WHERE tlesson.tuluv = 1 and att.tid = '$tid' and att.classid = '$class' GROUP BY lessonid",
            $id,
            $name,
            $cag
        );

        while (_fetch($cstmt)) {
            echo "<option value='$id'>($cag) $name</option>";
        }
    } else if ($mode == 3) {
        $class = @$_POST['class'];
        $tid = @$_POST['tid'];
        $lesson = @$_POST['lesson'];

        _selectNoParam(
            $cstmt,
            $ccount,
            "SELECT att.id, att.ognoo, cag.name, ltype.name, att.irc, sedev FROM `att` 
                INNER JOIN cag ON att.cagid = cag.id 
                    INNER JOIN ltype ON att.ltype = ltype.id 
                        WHERE att.tid = '$tid' and att.classid = '$class' and att.lessonid = '$lesson' ORDER BY ognoo",
            $attid,
            $ognoo,
            $cag,
            $ltype,
            $irc,
            $sedev
        );
        $data = [];
        while (_fetch($cstmt)) {
            $item = new stdClass();
            $item->attid = $attid;
            $item->ognoo = $ognoo;
            $item->cag = $cag;
            $item->ltype = $ltype;
            $item->irc = $irc;
            $item->sedev = $sedev;
            array_push($data, $item);
        } ?>
        <!-- Tabs navs -->
        <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="ex1-tab-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">ИРЦИЙН БҮРТГЭЛ</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="ex1-tab-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">СЭДЭВ</a>
            </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content" id="ex1-content">
            <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
                <table class="table table-bordered table-hover">
                    <thead style="position: sticky; top: 0; background-color: #182c5c;z-index: 1000;color:#fff">
                        <tr>
                            <td style='width: 30px'>№</td>
                            <td>Нэр</td>
                            <?php
                            foreach ($data as $el) {
                                $timestamp = strtotime($el->ognoo);
                                $day = date('d', $timestamp);
                                $month = date('m', $timestamp);
                                echo "<td style='text-align: center'>$month.$day</td>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        _selectNoParam(
                            $st,
                            $co,
                            "SELECT id, fname, lname FROM students WHERE class='$class' and tuluv=1 ORDER BY lname, fname",
                            $sid,
                            $fname,
                            $lname
                        );
                        $dd = 0;
                        while (_fetch($st)) {
                            $dd++;
                            echo "<tr><td>$dd</td>";
                            echo "<td>$lname <br><span style='font-size: 10px'>($fname)</span></td>";

                            foreach ($data as $el) {
                                $eseh = 1;
                                $oldirc = json_decode($el->irc);
                                foreach ($oldirc as $key => $eli) {
                                    if ($eli->id == $sid)
                                        $eseh = $eli->val;
                                }
                                if ($eseh > 1)
                                    echo "<td style='text-align: center'><span class='alert alert-" . $tuluvColor[$eseh] . "'> " . $tuluvIrcShort[$eseh] . "</span></td>";
                                else echo "<td></td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                        <tr>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
                <table class="table table-bordered table-hover">
                    <thead style="position: sticky; top: 0; background-color: #182c5c;z-index: 1000;color:#fff">
                        <tr>
                            <td style="width: 30px;">№</td>
                            <td style="width: 150px;">Огноо</td>
                            <td style="width: 70px;">Цаг</td>
                            <td style="width: 50px;">Төрөл</td>
                            <td>Сэдэв</td>
                        </tr>
                    </thead>
                    <?php
                    $dd = 1;
                    foreach ($data as $el) {
                        echo "<tr>
                        <td>$dd</td>
                        <td>". str_replace("-", ".", $el->ognoo) ."<span style='font-size: 10px'>($el->cag)</span></td>
                        <td>2 цаг</td>
                        <td>$el->ltype</td>
                        <td><div class='editcell' onblur='updateSedev(this, $el->attid)' contenteditable=''>$el->sedev</div></td>
                        </tr>";
                    $dd++;
                    }
                    ?>
            </div>
        </div>
<?php
    }
}
