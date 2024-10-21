<?php
if (isset($_POST['shangilaladd'])) {
    $angilal = post('angilal', 300);
    try {
        $success = _exec(
            "INSERT INTO s_shalguurbuleg(name, tuluv) VALUES (?, '0')",
            's',
            [$angilal],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/sudalgaa/shalguurlist");
} else if (isset($_POST['shangilaledit'])) {
    $angilal = post('eangilal', 300);
    $id = post('eid', 10);
    try {
        $success = _exec(
            "UPDATE s_shalguurbuleg SET name=? WHERE id=?",
            'si',
            [$angilal, $id],
            $count
        );
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/sudalgaa/shalguurlist");
} else if (isset($_POST['shalguuradd'])) {
    $buleg = $_POST['buleg'];
    $shner = $_POST['shner'];
    $hariult = $_POST['hariult'];
    $expand = 0;
    $tuluv = 0;
    $dedturul = 0;
    if (!empty($_POST['expand']) && $_POST['expand'] == "on") {
        $expand = 1;
    }
    if (!empty($_POST['tuluv']) && $_POST['tuluv'] == "on") {
        $tuluv = 1;
    }
    if (!empty($_POST['dedturul']) && $_POST['dedturul'] == "on") {
        $dedturul = 1;
    }
    try {
        $success = _exec(
            "INSERT INTO s_shalguurs(buleg_id, name, ded, turul, tuluv, created_at, updated_at, hariulttype) VALUES (?, ?, ?, ?, ?, ?, ?, ?)",
            'isiiissi',
            [$buleg, $shner, $expand, $hariult, $tuluv, ognoo(), ognoo(), $dedturul],
            $count
        );
        $_SESSION['action'] = "Бүлэг устгагдлаа!";
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/sudalgaa/shalguurlist");
} else if (isset($_POST['shalguuredit'])) {
    $id = $_POST['id'];
    $buleg = $_POST['buleg'];
    $shner = $_POST['shner'];
    $hariult = $_POST['hariult'];
    $expand = 0;
    $tuluv = 0;
    $dedturul = 0;
    if (isset($_POST['expand']) == "on") {
        $expand = 1;
    }
    if (isset($_POST['tuluv']) == "on") {
        $tuluv = 1;
    }
    if (isset($_POST['dedturul']) == "on") {
        $dedturul = 1;
    }
    $success = _exec(
        "UPDATE s_shalguurs SET buleg_id=?, name=?, ded=?, turul=?, tuluv=?, updated_at=?, hariulttype=? WHERE id = ?",
        'isiiisii',
        [$buleg, $shner, $expand, $hariult, $tuluv, ognoo(), $dedturul, $id],
        $count
    );
    redirect("/sudalgaa/shalguurlist");
} else if (isset($_POST['bulegdelete'])) {
    $dbuleg_id = post('dbuleg_id', 300);
    try {
        $success = _exec(
            "DELETE FROM s_shalguurbuleg WHERE id=?",
            'i',
            [$dbuleg_id],
            $count
        );
        $_SESSION['action'] = "Бүлэг устгагдлаа!";
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/sudalgaa/shalguurlist");
} else if (isset($_POST['shalguurdelete'])) {
    $dbuleg_id = post('dangi_id', 300);
    try {
        $success = _exec(
            "DELETE FROM s_shalguurs WHERE id=?",
            'i',
            [$dbuleg_id],
            $count
        );
        $_SESSION['action'] = "Шалгуур устгагдлаа!";
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect("/sudalgaa/shalguurlist");
}