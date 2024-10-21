<?php require ROOT . "/pages/start.php"; ?>
<style>
    .itemtest {
        BACKGROUND-COLOR: #f9f9f9;
        padding: 15px;
        border-radius: 15px;
        margin: 10px;
        border: solid 1px;
    }

    .itemded {
        padding: 10px;
        background: rgb(235, 231, 255);
        border-radius: 10px;
    }
</style>
<?php
require ROOT . "/pages/header.php";

$student_id = $_GET["id"];
$angi = $_GET["angi"];
$type = $_GET["type"];
_selectRowNoParam(
    "SELECT class.sname, students.fname, students.lname FROM students INNER JOIN class ON students.class = class.id WHERE students.id = '$student_id'",
    $angi, $fname, $lname
);
$jil = $this_on;
?>
        <?php if (1 == 1) :

            _selectNoParam(
                $e_stmt,
                $e_count,
                "SELECT value, shalguur_id, shalguurded_id FROM `s_sudalgaas` WHERE student_id = '$student_id' and jil = '$jil'",
                $e_value,
                $e_shalguur_id,
                $e_shalguurded_id
            );
            $e_sudalgaa = array();
            if ($e_count > 0) {
                while (_fetch($e_stmt)) {
                    array_push($e_sudalgaa, ["value" => $e_value, "e_shalguur_id" => $e_shalguur_id, "e_shalguurded_id" => $e_shalguurded_id]);
                }
            }
            //print_r($e_sudalgaa);

            _selectNoParam(
                $stmt,
                $count,
                "SELECT id, name FROM s_shalguurbuleg WHERE s_shalguurbuleg.tuluv = 1 ORDER BY s_shalguurbuleg.id",
                $buleg_id,
                $buleg_name
            );

        ?>
            <div class="card gy-3" style="position: sticky;top: 0px;z-index: 1000000;">
                <div class="row">
                    <div class="col" style="padding: 10px;">
                        <span style='font-size: 24px;font-weight: bold;padding: 10px;margin-left: 15px; color:#0013f3'><?= $fname ?> <span style='text-transform: uppercase'><?= $lname ?></span><span style='text-transform: uppercase'>
                    </div>
                </div>
            </div>
            <div class="card" style="padding: 20px;margin-top: 1rem;">
                <div class="row gy-3">
                    <form action="/sudalgaa/actionsudalgaa" method="POST" onsubmit='disableButton()' id='myForm'>
                        <input type="text" value="<?= $student_id ?>" name="student_id" style="display: none;" readonly="" />
                        <?php 
                        $dugaar = 1;
                        while (_fetch($stmt)) :
                            _selectNoParam(
                                $qstmt,
                                $qcount,
                                "SELECT s_shalguurs.id, s_shalguurs.name, s_shalguurs.ded, s_shalguurs.hariulttype, s_shalguurs.turul FROM `s_shalguurs` INNER JOIN s_activeshes ON s_shalguurs.id = s_activeshes.shalguur_id WHERE s_activeshes.turul = '0' AND buleg_id = '$buleg_id' AND s_shalguurs.tuluv = 1 ORDER BY  s_shalguurs.id;",
                                $shalguur_id,
                                $shalguur_name,
                                $shalguur_ded,
                                $hariulttype,
                                $shalguurs_turul
                            ); ?>
                            <div>
                                <h3><?= $buleg_name ?></h3>
                                <?php while (_fetch($qstmt)) {
                                    //Засах утга авах эсэх
                                    $eval = "-1";
                                    $display = "none";
                                    for ($i = 0; $i < count($e_sudalgaa); $i++) {
                                        if ($e_sudalgaa[$i]["e_shalguur_id"] == $shalguur_id) {
                                            $eval = $e_sudalgaa[$i]["value"];
                                        }
                                    }
                                    //Засах утга авах эсэх дууссан
                                    echo "<div class='itemtest'";
                                    if ($shalguur_id == 23 or $shalguur_id == 72 or $shalguur_id == 42 or $shalguur_id == 36) echo " style='color: red' ";
                                    echo "><div style='font-weight: bold;'>$dugaar). $shalguur_name</div>";
                                    if ($shalguurs_turul == '0') {
                                        if ($shalguur_ded == '1') {
                                            echo "<div class='form-check'><input class='form-check-input' type='radio' id='id$shalguur_id' name='hariult$shalguur_id' value='1***' onclick=\"HideShow($shalguur_id, 1)\"";
                                            echo $eval == "1" ? " checked" : null;
                                            echo " required /><label class='form-check-label' for='id$shalguur_id'>Тийм</label></div>";

                                            _selectNoParam(
                                                $dstmt,
                                                $dcount,
                                                "SELECT id, name, turul FROM `s_shalguurdeds` WHERE shalguur_id = '$shalguur_id' AND tuluv = 1",
                                                $ded_id,
                                                $ded_name,
                                                $ded_turul
                                            );
                                            echo "<div class='itemded'";
                                            echo $eval == "1" ? null : " style='display: none'";
                                            echo " id='deddiv$shalguur_id'><strong>Доорх сонголтоос сонголт хийнэ</strong>";

                                            if ($hariulttype == '0') {
                                                while (_fetch($dstmt)) {
                                                    echo "<div class='form-check'>
                                                        <input data-dedradio='dedradio$shalguur_id' class='form-check-input' type='radio' id='idc$shalguur_id-$ded_id' name='hariult$shalguur_id-1' value='$ded_id'";
                                                    for ($i = 0; $i < count($e_sudalgaa); $i++) {
                                                        if ($e_sudalgaa[$i]["e_shalguur_id"] == $shalguur_id && $e_sudalgaa[$i]["e_shalguurded_id"] == $ded_id) {
                                                            echo " checked";
                                                        }
                                                    }
                                                    echo "/><label class='form-check-label' for='idc$shalguur_id-$ded_id'>$ded_name</label>
                                                    </div>";
                                                }
                                            } else if ($hariulttype == '1') {
                                                while (_fetch($dstmt)) {
                                                    echo "<div class='form-check'>
                                                        <input data-dedradio='dedradio$shalguur_id' class='form-check-input' type='checkbox' id='dedid$shalguur_id-$ded_id' onclick=checkHandle(\"dedmulti$shalguur_id-[]\") name='dedmulti$shalguur_id-[]' value='$ded_id'";
                                                    for ($i = 0; $i < count($e_sudalgaa); $i++) {
                                                        if ($e_sudalgaa[$i]["e_shalguur_id"] == $shalguur_id && $e_sudalgaa[$i]["e_shalguurded_id"] == $ded_id) {
                                                            echo " checked";
                                                        }
                                                    }
                                                    echo "/><label class='form-check-label' for='dedid$shalguur_id-$ded_id'>$ded_name</label></div>";
                                                }
                                            }
                                            echo "</div>";
                                        } else {
                                            echo "<div class='form-check'><input class='form-check-input' type='radio' id='ido$shalguur_id' name='hariult$shalguur_id' value='1' onclick=\"HideShow($shalguur_id, 1)\"";
                                            echo $eval == "1" ? " checked" : "";
                                            echo "/><label class='form-check-label' for='ido$shalguur_id'>Тийм</label></div>";
                                        }
                                        echo "<div class='form-check'>
                                                <input class='form-check-input' type='radio' id='idn$shalguur_id' name='hariult$shalguur_id' value='0' onclick=\"HideShow($shalguur_id, 0)\"";
                                        echo $eval == "0" ? " checked" : "";
                                        echo "/><label class='form-check-label' for='idn$shalguur_id'>Үгүй</label></div>";
                                    } else if ($shalguurs_turul == '1') {
                                        $qtype = "radio";
                                        if ($hariulttype == '1') $qtype = "checkbox";
                                        _selectNoParam(
                                            $dstmt,
                                            $dcount,
                                            "SELECT id, name, turul FROM `shalguurdeds` WHERE shalguur_id = '$shalguur_id' AND tuluv = 1",
                                            $ded_id,
                                            $ded_name,
                                            $ded_turul
                                        );
                                        echo "<div style='padding: 10px'><div class='checkbox-group required'>";
                                        while (_fetch($dstmt)) {
                                            echo "<div class='form-check'>
                                            <input class='form-check-input' type='$qtype' name='olon$shalguur_id-[]' onclick=checkHandle(\"olon$shalguur_id-[]\") value='$ded_id' required";
                                            echo "><label class='form-check-label'>$ded_name</label>
                                        </div>";
                                        }
                                        echo "</div></div>";
                                    }
                                    $dugaar++;
                                    echo "</div>";
                                } ?>
                            </div>
                        <?php endwhile; ?>
                        <?php if($type < 2) { ?>
                        <input type="submit" id="sudalgaa_add" class="btn btn-primary" value="ХАДГАЛАХ" name="sudalgaa_add" />
                        <?php } ?>
                    </form>
                </div>
            </div>
        <?php endif; ?>
        <?php require ROOT . "/pages/footer.php"; ?>
        <script type="text/javascript">
            function disableButton() {
                var btn = document.getElementById('sudalgaa_add');
                btn.disabled = true;
                btn.value = 'Түр хүлээнэ үү...'
            }

            function checkHandle(v) {
                let matches = document.querySelectorAll("[name='" + v + "']");
                let checkBool = false;
                for (let i = 0; i < matches.length; i++) {
                    if (matches[i].checked === true) {
                        checkBool = true;
                        break;
                    }
                }
                if (checkBool === false) {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].setAttribute('required', '')
                    }
                } else {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].removeAttribute('required')
                    }
                }
            };

            function HideShow(v, t) {
                let matches = document.querySelectorAll("[data-dedradio='dedradio" + v + "']");

                if (t) {
                    $('#deddiv' + v).css("display", "");
                    if (matches.length > 0)
                        matches[0].setAttribute('required', '');
                } else {
                    for (let i = 0; i < matches.length; i++) {
                        matches[i].checked = false;
                    }
                    $('#deddiv' + v).css("display", "none");
                    if (matches.length > 0)
                        matches[0].removeAttribute('required')
                }
            }
        </script>
        <?php require ROOT . "/pages/end.php"; ?>