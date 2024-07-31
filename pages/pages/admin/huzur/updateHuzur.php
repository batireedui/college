<?php
if ($_POST['type'] == "huzurtypeupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE huzurtype SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok".$sqlaa;
    } else {
    }
}
else if ($_POST['type'] == "teacherupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE huzurteacher SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok".$sqlaa;
    } else {
    }
}
else if ($_POST['type'] == "huzurtuluvupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemhuzur SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok".$sqlaa;
    } else {
    }
}
else if ($_POST['type'] == "huzurupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemhuzur SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok".$sqlaa;;
    } else {
    }
}
?>