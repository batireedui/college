<?php
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['mode'])) {
        $lsar = 0;
        if (isset($_POST['lsar'])) {
            $lsar = $_POST['lsar'];
        }
        $offArr = [];
        if ($_POST['mode'] == '1' || $_POST['mode'] == '2' || $_POST['mode'] == '4') {
            _selectNoParam(
                $offstmt,
                $offcount,
                "SELECT userid, start_off, end_off FROM att_off WHERE MONTH(start_off) = '$lsar' or MONTH(end_off) = '$lsar'",
                $offid,
                $start_off,
                $end_off
            );
                
            while (_fetch($offstmt)) {
                $item = new stdClass();
                $item->offid = $offid;
                $item->start_off = $start_off;
                $item->end_off = $end_off;
                array_push($offArr, $item);
            }
        }
        if ($_POST['mode'] == '1') {
            $lon = $_POST['lon'];
            $lsar = $_POST['lsar'];
            $office_id = $_POST['office_id'];
            $department_id = $_POST['department_id'];
            
            $wh = '';
            if($office_id != '0') {
                $wh .= " and office_id = '$office_id'";
            }
            if($department_id != '0') {
                $wh .= " and department_id = '$department_id'";
            }
            
            $lday = date("t", strtotime("$lon-$lsar-10"));
            
            $ldate = date("Y-m-t", strtotime("$lon-$lsar-10"));
            $sdate = date("Y-m-d", strtotime("$lon-$lsar-01"));
            
            _selectNoParam(
                $stmt,
                $count,
                "SELECT id, teacher.fname, teacher.lname FROM teacher WHERE tuluv = 1 $wh ORDER BY teacher.lname",
                $id,
                $fname,
                $lname
            );
            
            _selectNoParam(
                $cstmt,
                $ccount,
                "SELECT id, hezee, tsag, userid FROM att_work WHERE hezee >= '$sdate' and hezee <= '$ldate' ORDER BY hezee, tsag",
                $id,
                $hezee,
                $tsag,
                $userid
            );
            
            $cagArr = [];
            
            while (_fetch($cstmt)) {
                $item = new stdClass();
                $item->id = $id;
                $item->hezee = $hezee;
                $item->tsag = $tsag;
                $item->userid = $userid;
                array_push($cagArr, $item);
            }
            ?>
                <div id="timetable">
                    <table class="table table-bordered hovercell" id="datalist">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">№</th>
                                <th rowspan="2">Багш/Ажилтан</th>
                                <th colspan="<?=$lday?>" style="text-align: center"><?php echo "$lon оны $lsar-р сар" ?></th>
                                <th rowspan="2">НИЙТ ЦАГ</th>
                                <th rowspan="2">ӨДӨР</th>
                            </tr>
                            <tr>
                                <?php
                                $i = 1;
                                while($lday >= $i) {
                                    $dayof = date("Y-m-d", strtotime("$lon-$lsar-$i"));
                                    $style = "";
                                    if(amralt($dayof)) $style = "style = 'background-color: #ffdb80'";
                                    echo "<th $style>$i</th>";
                                    $i++;
                                }
                                ?>
                            </tr>
                        </thead>
                        <?php
                        $k = 0;
                        while (_fetch($stmt)) { 
                            $udur = 0;
                            $k++; ?>
                            <tr>
                                <td style='text-align: center'><?= $k ?></td>
                                <td><?= $fname ?> <?= $lname ?></td>
                                <?php
                                $i = 1;
                                $tempArr = array();
                                $tempCag = array();
                                
                                while($lday >= $i) {
                                    
                                    $dayof = date("Y-m-d", strtotime("$lon-$lsar-$i"));
                                    $style = "";
                                    if(amralt($dayof)) $style = "style = 'background-color: #ffdb80'";
                                    echo "<td $style>";
                                    foreach ($cagArr as $index =>$cel) {
                                        if($id == $cel->userid && $dayof == $cel->hezee) {
                                            
                                            array_push($tempArr, $cel->tsag);
                                            
                                            //echo "<small class='badge badge-secondary'>$cel->tsag</small>";
                                            unset($cagArr[$index]);
                                            } 
                                    }
                                    foreach ($offArr as $celoff) {
                                        if($id == $celoff->offid) {
                                            if ($dayof >= $celoff->start_off && $dayof <= $celoff->end_off) {
                                                echo "<span class='alert alert-warning'>Ч</span>";
                                            }
                                        } 
                                    }
                                    $time = udurCag($tempArr, $dayof);
                                    array_push($tempCag, $time->cag);
                                    $udur = $udur + $time->udur;
                                    
                                    echo "<br><small class='badge badge-info'>".$time->utga."</small></td>";
                                    array_splice($tempArr, 0);
                                    $i++;
                                }
                                echo "<td><small class='badge badge-info'>".sumCag($tempCag)."</small></td>";
                                echo "<td><small class='badge badge-danger'>$udur өдөр</small></td>";
                                array_splice($tempCag, 0);
                                ?>
                            </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div>
        <?php
        }
        else if ($_POST['mode'] == '2') {
            $lon = $_POST['lon'];
            $lsar = $_POST['lsar'];
            $office_id = $_POST['office_id'];
            $department_id = $_POST['department_id'];
            
            $wh = '';
            if($office_id != '0') {
                $wh .= " and office_id = '$office_id'";
            }
            if($department_id != '0') {
                $wh .= " and department_id = '$department_id'";
            }
            
            $lday = date("t", strtotime("$lon-$lsar-10"));
            
            $ldate = date("Y-m-t", strtotime("$lon-$lsar-10"));
            $sdate = date("Y-m-d", strtotime("$lon-$lsar-01"));
            
            _selectNoParam(
                $stmt,
                $count,
                "SELECT id, teacher.fname, teacher.lname FROM teacher WHERE tuluv = 1 $wh ORDER BY teacher.lname",
                $id,
                $fname,
                $lname
            );
            
            _selectNoParam(
                $cstmt,
                $ccount,
                "SELECT id, hezee, tsag, userid FROM att_work WHERE hezee >= '$sdate' and hezee <= '$ldate' ORDER BY hezee, tsag",
                $id,
                $hezee,
                $tsag,
                $userid
            );
            
            $cagArr = [];
            
            while (_fetch($cstmt)) {
                $item = new stdClass();
                $item->id = $id;
                $item->hezee = $hezee;
                $item->tsag = $tsag;
                $item->userid = $userid;
                array_push($cagArr, $item);
            }
            ?>
                <div id="timetable">
                    <table class="table table-bordered hovercell" id="datalist">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">№</th>
                                <th rowspan="2">Багш/Ажилтан</th>
                                <th colspan="<?=$lday?>" style="text-align: center"><?php echo "$lon оны $lsar-р сар" ?></th>
                                <th rowspan="2">НИЙТ ЦАГ</th>
                                <th rowspan="2">ӨДӨР</th>
                            </tr>
                            <tr>
                                <?php
                                $i = 1;
                                while($lday >= $i) {
                                    $dayof = date("Y-m-d", strtotime("$lon-$lsar-$i"));
                                    $style = "";
                                    if(amralt($dayof)) $style = "style = 'background-color: #ffdb80'";
                                    echo "<th $style>$i</th>";
                                    $i++;
                                }
                                ?>
                            </tr>
                        </thead>
                        <?php
                        $k = 0;
                        while (_fetch($stmt)) { 
                            $udur = 0;
                            $k++; ?>
                            <tr>
                                <td style='text-align: center'><?= $k ?></td>
                                <td><?= $fname ?> <?= $lname ?></td>
                                <?php
                                $i = 1;
                                $tempArr = array();
                                $tempCag = array();
                                
                                while($lday >= $i) {
                                    
                                    $dayof = date("Y-m-d", strtotime("$lon-$lsar-$i"));
                                    $style = "";
                                    if(amralt($dayof)) $style = "style = 'background-color: #ffdb80'";
                                    echo "<td $style>";
                                    foreach ($cagArr as $index =>$cel) {
                                        if($id == $cel->userid && $dayof == $cel->hezee) {
                                            
                                            array_push($tempArr, $cel->tsag);
                                            
                                            echo "<small class='badge badge-secondary'>$cel->tsag</small>";
                                            unset($cagArr[$index]);
                                            } 
                                    }
                                    foreach ($offArr as $celoff) {
                                        if($id == $celoff->offid) {
                                            if ($dayof >= $celoff->start_off && $dayof <= $celoff->end_off) {
                                                echo "<span class='alert alert-warning'>Ч</span>";
                                            }
                                        } 
                                    }
                                    $time = udurCag($tempArr, $dayof);
                                    array_push($tempCag, $time->cag);
                                    array_splice($tempArr, 0);
                                    $i++;
                                }
                                echo "<td><small class='badge badge-info'>".sumCag($tempCag)."</small></td>";
                                echo "<td><small class='badge badge-danger'>$udur өдөр</small></td>";
                                array_splice($tempCag, 0);
                                ?>
                            </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div> <?php
        }
        else if($_POST['mode'] == '3') {
            if($_POST['office_id'] == '0') 
            $sql = "SELECT id, name FROM `department` WHERE tuluv = 1";
            else $sql = "SELECT id, name FROM `department` WHERE tuluv = 1 and office_id = '".$_POST['office_id']."'";
            _selectNoParam(
                $dstmt,
                $dcount,
                $sql,
                $did,
                $dname
            );
            echo '<option value="0">Бүгд</option>';
            while(_fetch($dstmt)){ ?>
                <option value="<?=$did?>"><?=$dname?></option>
            <?php } 
        } else if($_POST['mode'] == 'addtime') {
            $adduserid = $_POST['adduserid'];
            $addudur = $_POST['addudur'];
            $addcag = $_POST['addcag'];
            $addmin = $_POST['addmin'];
            
            $hezee = "$addcag:$addmin:00";
            
            _selectRowNoParam(
                "SELECT tsag FROM `att_work` WHERE userid='$adduserid' and hezee = '$addudur' ORDER by id DESC LIMIT 1",
                $tsag
            );
            $mins = 60;
            if(!empty($tsag)){
                $start = strtotime(date($hezee));
                $end = strtotime($tsag);
                $mins = ($end - $start) / 60;
            }
            if(abs($mins) > 10) {
                    $success = _exec(
                        "INSERT INTO att_work (hezee, tsag, userid, lon, lat, refer, turul) VALUES (?, ?, ?, ?, ?, ?, ?)",
                        'ssissii',
                        [$addudur, $hezee, $adduserid, '0', '0', $_SESSION['user_id'], 0],
                        $ct
                    );
                    echo "Амжилттай бүртгэгдлээ!";
            }
            else echo "Бүртгэгдсэн байна!";
        }
        else if($_POST['mode'] == 'offtime') {
            $offuserid = $_POST['offuserid'];
            $offstart = $_POST['offstart'];
            $offend = $_POST['offend'];
            
            $success = _exec(
                "INSERT INTO att_off (userid, start_off, end_off, refer) VALUES (?, ?, ?, ?)",
                'issi',
                [$offuserid, $offstart, $offend, $_SESSION['user_id']],
                $ct
            );
            echo "Амжилттай бүртгэгдлээ!";
        }
        else if($_POST['mode'] == '4') {
             $lon = $_POST['lon'];
            $lsar = $_POST['lsar'];
            $office_id = $_POST['office_id'];
            $department_id = $_POST['department_id'];
            
            $wh = '';
            if($office_id != '0') {
                $wh .= " and office_id = '$office_id'";
            }
            if($department_id != '0') {
                $wh .= " and department_id = '$department_id'";
            }
            
            $lday = date("t", strtotime("$lon-$lsar-10"));
            
            $ldate = date("Y-m-t", strtotime("$lon-$lsar-10"));
            $sdate = date("Y-m-d", strtotime("$lon-$lsar-01"));
            
            _selectNoParam(
                $stmt,
                $count,
                "SELECT id, teacher.fname, teacher.lname FROM teacher WHERE tuluv = 1 $wh ORDER BY teacher.lname",
                $id,
                $fname,
                $lname
            );
            
            _selectNoParam(
                $cstmt,
                $ccount,
                "SELECT id, hezee, tsag, userid FROM att_work WHERE hezee >= '$sdate' and hezee <= '$ldate' ORDER BY hezee, tsag",
                $id,
                $hezee,
                $tsag,
                $userid
            );
            
            $cagArr = [];
            
            while (_fetch($cstmt)) {
                $item = new stdClass();
                $item->id = $id;
                $item->hezee = $hezee;
                $item->tsag = $tsag;
                $item->userid = $userid;
                array_push($cagArr, $item);
            }
            _selectRowNoParam(
                "SELECT c1 FROM att_time WHERE eseh = 1",
                $c1
            );
            ?>
                <div id="timetable">
                    <table class="table table-bordered hovercell" id="datalist">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2">№</th>
                                <th rowspan="2">Багш/Ажилтан</th>
                                <th colspan="<?=$lday?>" style="text-align: center"><?php echo "$lon оны $lsar-р сар" ?></th>
                                <th rowspan="2">НИЙТ ЦАГ</th>
                            </tr>
                            <tr>
                                <?php
                                $i = 1;
                                while($lday >= $i) {
                                    $dayof = date("Y-m-d", strtotime("$lon-$lsar-$i"));
                                    $style = "";
                                    if(amralt($dayof)) $style = "style = 'background-color: #ffdb80'";
                                    echo "<th $style>$i</th>";
                                    $i++;
                                }
                                ?>
                            </tr>
                        </thead>
                        <?php
                        $k = 0;
                        while (_fetch($stmt)) { 
                            $sum = 0;
                            $k++; ?>
                            <tr>
                                <td style='text-align: center'><?= $k ?></td>
                                <td><?= $fname ?> <?= $lname ?></td>
                                <?php
                                $i = 1;
                                while($lday >= $i) {
                                    
                                    $dayof = date("Y-m-d", strtotime("$lon-$lsar-$i"));
                                    $style = "";
                                    if(amralt($dayof)) $style = "style = 'background-color: #ffdb80'";
                                    echo "<td $style>";
                                    foreach ($cagArr as $index =>$cel) {
                                        if($id == $cel->userid && $dayof == $cel->hezee) {
                                            $sum += hocroltOne($c1, $cel->tsag);
                                            echo "<small class='badge badge-danger'>" . hocrolt($c1, $cel->tsag) . "</small>";
                                            unset($cagArr[$index]);
                                            break;
                                        } 
                                    }
                                    $i++;
                                }
                                echo "<td><small class='badge badge-info'>".floor($sum / 60). "ц " . $sum % 60 . "мин</small></td>";
                                $sum = 0;
                                ?>
                            </tr>
                        <?php
                            }
                        ?>
                    </table>
                </div> <?php
        } else if($_POST['mode'] == 'oneteacher') {
            $lon = $_POST['lon'];
            $lsar = $_POST['lsar'];
            $user_id = $_POST['user_id'];
            
            $lday = date("t", strtotime("$lon-$lsar-10"));
            
            $ldate = date("Y-m-t", strtotime("$lon-$lsar-10"));
            $sdate = date("Y-m-d", strtotime("$lon-$lsar-01"));
            
            _selectRowNoParam(
                "SELECT id, teacher.fname, teacher.lname FROM teacher WHERE id = $user_id",
                $id,
                $fname,
                $lname
            );
            
            _selectNoParam(
                $cstmt,
                $ccount,
                "SELECT id, hezee, tsag, userid FROM att_work WHERE userid='$user_id' and hezee >= '$sdate' and hezee <= '$ldate' ORDER BY hezee, tsag",
                $id,
                $hezee,
                $tsag,
                $userid
            );
            
            $cagArr = [];
            
            while (_fetch($cstmt)) {
                $item = new stdClass();
                $item->id = $id;
                $item->hezee = $hezee;
                $item->tsag = $tsag;
                $item->userid = $userid;
                array_push($cagArr, $item);
            }
            _selectRowNoParam(
                "SELECT c1 FROM att_time WHERE eseh = 1",
                $c1
            );
            ?>
                <div id="timetable">
                    <h3><?=$fname?> <?=$lname?></h3>
                    <table class="table table-bordered hovercell" id="datalist">
                        <thead class="table-light">
                            <tr>
                                <th>№</th>
                                <th>ӨДӨР</th>
                                <th>ЦАГ</th>
                            </tr>
                        </thead>
                                <?php
                                $i = 1;
                                $d = 1;
                                while($lday >= $i) {
                                    $dayof = date("Y-m-d", strtotime("$lon-$lsar-$i"));
                                    $style = "";
                                    if(amralt($dayof)) $style = "style = 'background-color: #ffdb80'";?>
                                    <tr <?=$style?>>
                                        <td style='text-align: center'><?= $d ?></td>
                                        <td><?=$dayof?></td>
                                        <td>
                                        <?php 
                                        foreach ($cagArr as $index =>$cel) {
                                            if($dayof == $cel->hezee) {
                                                echo "<small class='badge badge-primary m-1'>" . $cel->tsag . "</small>";
                                                unset($cagArr[$index]);
                                            } 
                                        }
                                        $i++;
                                        $d++;
                                        echo '</td></tr>';
                                    }
                                    ?>
                    </table>
                </div>
            <?php }
        else echo "Буруу хүсэлт илгээсэн байна!";
    }
    else echo "Буруу хүсэлт!";
}
else echo "Холболт салсан байна. Дахин нэвтэрч орно уу!";