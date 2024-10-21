<?php
if ($_POST['type'] == "shalguurdeds") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='" . $value . "'";
    $sqlaa = "UPDATE s_shalguurdeds SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok" . $sqlaa;
    } else {
    }
}
