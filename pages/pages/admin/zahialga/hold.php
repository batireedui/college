<?php
if (isset($_GET['galhold']) == 1) {
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemgal` INNER JOIN orders ON itemgal.orderid = orders.id WHERE orders.tuluv = ? and itemgal.tuluv = ?",
        "ii",
        ['1', '0'],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemgal SET tuluv = '1' WHERE orderid = '$oid'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-gal");
}
else if (isset($_GET['tuluulunhold']) == 1) {
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemtuluulun` INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = ? and itemtuluulun.tuluv = ?",
        "ii",
        ['1', '0'],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemtuluulun SET tuluv = '1' WHERE orderid = '$oid'";
        if ($con->query($sqlaa)) {
        }
    }
redirect("/admin/zahialga/order-tuluulun");
}
else if (isset($_POST['deedeshold'])) {
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemdeedes` INNER JOIN orders ON itemdeedes.orderid = orders.id WHERE itemdeedes.dtuluv=? and orders.tuluv = ? and itemdeedes.tuluvs = ? and itemdeedes.zognoo > ? and itemdeedes.zognoo < ?",
        "iiiss",
        ['2', '1', '0', $_POST['date1'], $_POST['date2']],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemdeedes SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='2'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-deedes");
}
else if (isset($_POST['suvargahold'])) {
    $d1 = $_POST['date1'] . " 00:00:00";
    $d2 = $_POST['date2'] . " 23:59:59";
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemtenger` INNER JOIN orders ON itemtenger.orderid = orders.id WHERE itemtenger.dtuluv=? and orders.tuluv = ? and itemtenger.tuluvs = ? and orders.ognoo > ? and orders.ognoo < ?",
        "iiiss",
        ['1', '1', '0', $d1, $d2],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemtenger SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='1'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-suvarga");
}
else if (isset($_POST['azhold'])) {
    $d1 = $_POST['date1'] . " 00:00:00";
    $d2 = $_POST['date2'] . " 23:59:59";
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemazjargal` INNER JOIN orders ON itemazjargal.orderid = orders.id WHERE itemazjargal.dtuluv=? and orders.tuluv = ? and itemazjargal.tuluvs = ? and orders.ognoo > ? and orders.ognoo < ?",
        "iiiss",
        ['2', '1', '0', $d1, $d2],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemazjargal SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='2'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-azjargal");
}
else if (isset($_POST['manalhold'])) {
    $d1 = $_POST['date1'] . " 00:00:00";
    $d2 = $_POST['date2'] . " 23:59:59";
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemmanal` INNER JOIN orders ON itemmanal.orderid = orders.id WHERE itemmanal.dtuluv=? and orders.tuluv = ? and itemmanal.tuluvs = ? and orders.ognoo > ? and orders.ognoo < ?",
        "iiiss",
        ['2', '1', '0', $d1, $d2],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemmanal SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='2'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-manal");
}
else if (isset($_POST['devterhold'])) {
    $d1 = $_POST['date1'] . " 00:00:00";
    $d2 = $_POST['date2'] . " 23:59:59";
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemdevter` INNER JOIN orders ON itemdevter.orderid = orders.id WHERE itemdevter.dtuluv=? and orders.tuluv = ? and itemdevter.tuluvs = ? and orders.ognoo > ? and orders.ognoo < ?",
        "iiiss",
        ['2', '1', '0', $d1, $d2],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemdevter SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='2'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-devter");
}
else if (isset($_POST['zamdhold'])) {
    $d1 = $_POST['date1'] . " 00:00:00";
    $d2 = $_POST['date2'] . " 23:59:59";
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemzamd` INNER JOIN orders ON itemzamd.orderid = orders.id WHERE itemzamd.dtuluv=? and orders.tuluv = ? and itemzamd.tuluvs = ? and orders.ognoo > ? and orders.ognoo < ?",
        "iiiss",
        ['1', '1', '0', $d1, $d2],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemzamd SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='1'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-zamd");
}
else if (isset($_POST['huuhedhold'])) {
    $d1 = $_POST['date1'] . " 00:00:00";
    $d2 = $_POST['date2'] . " 23:59:59";
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemhuuhed` INNER JOIN orders ON itemhuuhed.orderid = orders.id WHERE itemhuuhed.dtuluv=? and orders.tuluv = ? and itemhuuhed.tuluvs = ? and orders.ognoo > ? and orders.ognoo < ?",
        "iiiss",
        ['2', '1', '0', $d1, $d2],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemhuuhed SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='2'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-huuhed");
}
else if (isset($_POST['hushuuhold'])) {
    $d1 = $_POST['date1'] . " 00:00:00";
    $d2 = $_POST['date2'] . " 23:59:59";
    _select(
        $cstmt,
        $ccount,
        "SELECT orders.id FROM `itemhushh` INNER JOIN orders ON itemhuuhed.orderid = orders.id WHERE itemhuuhed.dtuluv=? and orders.tuluv = ? and itemhuuhed.tuluvs = ? and orders.ognoo > ? and orders.ognoo < ?",
        "iiiss",
        ['2', '1', '0', $d1, $d2],
        $oid
    );
    while (_fetch($cstmt)){
        $sqlaa = "UPDATE itemhushh SET tuluvs = '1' WHERE orderid = '$oid' and dtuluv='2'";
        if ($con->query($sqlaa)) {
        }
    }
    redirect("/admin/zahialga/order-hushuu");
}
else {
redirect("/");
}