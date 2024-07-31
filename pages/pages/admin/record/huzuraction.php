<?php

if (isset($_POST['teacheradd'])) {
    $name = post('name', 200);
    $utas = post('utas', 200);
    try {
        $success = _exec(
            "insert into huzurteacher(name, utas, dtuluv) VALUES(?, ?, ?)",
            'ssi',
            [$name, $utas, '0'],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect('/admin/huzur/teacher');
}
else if (isset($_POST['huzurtypeadd'])) {
    $hname = post('hname', 200);
    $hprice = post('hprice', 200);
    $hpricet = post('hpricet', 200);
    try {
        $success = _exec(
            "insert into huzurtype(name, price, pricet) VALUES(?, ?, ?)",
            'ssi',
            [$hname, $hprice, $hpricet],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect('/admin/huzur/teacher');
}
else if (isset($_POST['huzurteachsetadd'])) {
    $teachid = post('teachid', 200);
    $huzurid = post('huzurid', 200);
    try {
        $success = _exec(
            "insert into huzurteachset(teachid, huzurid) VALUES(?, ?)",
            'ii',
            [$teachid, $huzurid],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect('/admin/huzur/teacher');
}
?>