<?php
$zid = $_GET['id'];
if ($zid != "") {
            $sqlaa = "UPDATE orders SET tuluv = '3' WHERE id = '$zid'";
            if ($con->query($sqlaa)) {
            } else {
            }
}
redirect("/admin/zahialga/orders");
