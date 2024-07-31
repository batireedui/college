<?php
if ($_POST['type'] == "huuhedupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemhuuhed SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok".$sqlaa;
    } else {
    }
}
else if ($_POST['type'] == "huseltupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemgal SET $sqlval WHERE zproductid = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "tuluulunhuseltupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemtuluulun SET $sqlval WHERE zproductid = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "productsubupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE productsub SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "zamdupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemzamd SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "devterupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemdevter SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "deedesupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemdeedes SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "manalupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemmanal SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "aruinupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE zproducts SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "azupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemazjargal SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "suvargaupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemtenger SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "hushuuUpdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE itemhushh SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "tuluulunupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = $_POST['value'];
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE orders SET $sqlval WHERE payid = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "userszamdupdate") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = trim($_POST['value']);
    $value = !empty($value) ? $value : NULL;
    
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE wp_users SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}
else if ($_POST['type'] == "demjigchonoo") {
    $id = $_POST['id'];
    $turul = $_POST['turul'];
    $value = trim($_POST['value']);
    $value = !empty($value) ? $value : NULL;
    
    $sqlval = $turul . "='".$value."'";
    $sqlaa = "UPDATE demjigch SET $sqlval WHERE id = '$id'";
    if ($con->query($sqlaa)) {
        echo "ok";
    } else {
    }
}