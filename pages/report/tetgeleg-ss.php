<?php
if (isset($_SESSION['user_id'])) {
        $class = @$_POST['class'];
        $on = @$_POST['on'];
        $sar = @$_POST['sar'];
        
        $last = date("Y-m-t", strtotime("$on-$sar-1"));
        $start = date("Y-m-d", strtotime("$on-$sar-1"));
        
        _selectNoParam(
            $cstmt,
            $ccount,
            "SELECT att.id, att.ognoo, cag.name, att.irc FROM `att` 
                INNER JOIN cag ON att.cagid = cag.id 
                        WHERE att.classid = '$class' and ognoo BETWEEN '$start' and '$last' ORDER BY att.ognoo, att.cagid",
            $attid,
            $ognoo,
            $cag,
            $irc
        );
        $data = [];
        while (_fetch($cstmt)) {
            $item = new stdClass();
            $item->attid = $attid;
            $item->ognoo = $ognoo;
            $item->cag = $cag;
            $item->irc = $irc;
            array_push($data, $item);
        }
        
        $sname="";
        $class_name="";
        $tfname="";
        $tlname="";
        
        _selectRowNoParam(
            "SELECT sname, name, fname, lname FROM class INNER JOIN teacher ON class.teacherid = teacher.id WHERE class.id='$class'",
            $sname,
            $class_name,
            $tfname,
            $tlname
        );
        $batal = 0;
        
        _selectRowNoParam(
            "SELECT id FROM batal WHERE class='$class' and year='$on' and sar='$sar'",
            $batal
        );
        ?>
<h3 style='text-align: center;'>ИРЦИЙН ТАЙЛАН</h3>
<p style='text-align: center;' id="class_name"><?php echo "$sname $class_name"; ?></p>
<div style="display: flex;justify-content: space-between;margin-bottom: 10px;">
    <div style="display: flex;align-items:center;">
        <?php if($_SESSION['user_role'] > 1) {
            if($batal == 0 ){?>
                <div style="margin-right: 10px">
                    <button class="btn btn-danger"  data-mdb-toggle="modal" data-mdb-target="#batal" onclick="batalClick()">БАТАЛГААЖУУЛАХ</button>
                </div>
        <?php } else {?>
                <div style="margin-right: 10px">
                    <button class="btn btn-danger"  data-mdb-toggle="modal" data-mdb-target="#cancel" onclick="cancelClick()">БАТАЛГААЖУУЛАЛТ ЦУЦЛАХ</button>
                </div>
        <?php }} ?>
        <div>
            Хугацаа: <?=$on?> оны <?=$sar?>-р сар
        </div>
    </div>
    <div>Хэвлэсэн: <?=date("Y.m.d H:i")?></div>
</div>

                <table class="table table-bordered table-hover">
                    <tdead style="position: sticky; top: 0; background-color: #dddfff;z-index: 1000;">
                        <tr>
                            <td rowspan='2'>№</td>
                            <td rowspan='2'>Овог, нэр</td>
                            <?php
                            $old = "";
                            $str1 = "";
                            $str2 = "";
                            $col = 0;
                            $k=0;
                            $montd = "";
                            foreach($data as $el){
                                $k++;
                                $timestamp = strtotime($el->ognoo);
                                $day = date('d', $timestamp);
                                $montd = date('m', $timestamp);
                                
                                if($k == 1) $old = $day;
                                
                                if($day <> $old){
                                    $str1 .= "<td style='text-align: center' colspan='$col'>$montd.$old</td>";
                                    $col=1;
                                }
                                else {
                                    $col++;
                                }
                                $old = $day;
                                $str2 .= "<td style='text-align: center'>". cagtoRoma($el->cag) . "</td>";
                            }
                            echo "$str1<td style='text-align: center' colspan='$col'>$montd.$old</td>";
                            ?>
                            <td colspan='6' style='text-align: center'>ДҮН</td>
                        </tr>
                        <tr>
                        <?php echo "$str2";?>
                            <td style='text-align: center'>Ө</td>
                            <td style='text-align: center'>Ч</td>
                            <td style='text-align: center'>Т</td>
                            <td style='text-align: center'>СУУХ</td>
                            <td style='text-align: center'><i class="fa-solid fa-circle-check text-success"></i></td>
                            <td style='text-align: center'>ХУВЬ</td>
                        </tr>
                    </tdead>
                    <tbody>
                        <?php
                         _selectNoParam(
                            $stmt,
                            $count,
                            "SELECT id, fname, lname FROM `students` 
                                        WHERE class = '$class' and tuluv=1 ORDER BY lname",
                            $sid,
                            $fname,
                            $lname
                        );
                        $k=0;
                        while (_fetch($stmt)) { $k++;?>
                        <tr class="table_rows" data-mdb-toggle="modal" data-mdb-target="#detial" role="button" id="trow-<?= $sid ?>" onclick="detial(<?= $sid ?>)">
                            <td><?=$k?></td>
                            <td><?=$fname?> <span style='text-transform: uppercase;'><?=$lname?></span></td>
                            <?php
                            $v1 = 0;
                            $v2 = 0;
                            $v3 = 0;
                            $v4 = 0;
                            foreach ($data as $el) {
                                $eseh = 1;
                                $oldirc = json_decode($el->irc);
                                if($oldirc != null) {
                                    foreach ($oldirc as $key => $eli) {
                                        if ($eli->id == $sid){
                                            $eseh = $eli->val;
                                            if ($eseh == 1)
                                                $v1++;
                                            if ($eseh == 2)
                                                $v2++;
                                            if ($eseh == 3)
                                                $v3++;
                                            if ($eseh == 4)
                                                $v4++;
                                        }
                                    }
                                }
                                
                                if ($eseh > 1)
                                    echo "<td style='text-align: center'>" . $tuluvIrcShort[$eseh] . "</td>";
                                else echo "<td></td>";
                            }
                            $niit = $v3 + $v4 + $v2;
                            $shuvi = $v3 + $v4 + $v2 + $v1;
                            if ($v4 == 0)
                                $huvi = "100";
                            else $huvi = round(($shuvi - $v4) / $shuvi * 100);

                            ?>
                            <td><?=$v2*2?></td>
                            <td><?=$v3*2?></td>
                            <td><?=$v4*2?></td>
                            <td><?=$ccount*2?></td>
                            <td><?=$ccount*2-$niit*2?></td>
                            <td><?=$huvi?>%</td>
                        </tr>
                        <?php }
                        ?>
                    </tbody>
        </table>
        <p style='text-align: center;'>Анги удирдсан багш .......................... <?php echo substr($tfname, 0, 2). ".$tlname"; ?></p>
<?php
    
}
