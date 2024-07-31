<?php
if (isset($_POST['submenuadd'])) {
    $menid = post('menuid', 10);
    $name = post('menuname', 50);
    $medeelel = post('medeelel', 5000);
    $imgurl = post('imgurl', 500);
    if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    try {
        $success = _exec(
            "insert into submenu(menuid, name, medeelel, imgurl, tuluv) VALUES(?, ?, ?, ?, ?)",
            'isssi',
            [$menid, $name, $medeelel, $imgurl, $tuluv],
            $count
        );

        $_SESSION['messages'] = ["\"$name\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    redirect('/admin/menu');
}
else if (isset($_POST['submenuupdate'])) {
    $id = post('MenuIDedit', 10);
    $menid = post('menuid', 10);
    $name = post('menuname', 50);
    $medeelel = post('medeelel', 5000);
    $imgurl = post('imgurl', 500);
    if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    try {
        $success = _exec(
            "update submenu set menuid=?, name=?, medeelel=?, imgurl=?, tuluv=? WHERE id =?",
            'isssii',
            [$menid, $name, $medeelel, $imgurl, $tuluv, $id],
            $count
        );

        $_SESSION['messages'] = ["\"$name\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    redirect('/admin/menu');
}
else if (isset($_POST['menuadd'])) {
    $name = post('menuname', 50);
    if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    try {
        $success = _exec(
            "insert into menu(name, `desc`, tuluv) VALUES(?, '', ?)",
            'ss',
            [$name, $tuluv],
            $count
        );

        $_SESSION['messages'] = ["\"$name\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    redirect('/admin/menu');
}
else if (isset($_POST['menuedit'])) {
    $id = post('menuidedit', 10);
    $name = post('menutitleedit', 200);
        if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    try {
        $success = _exec(
            "update menu set name=?, tuluv=? WHERE id=?",
            'sii',
            [$name,$tuluv,$id],
            $count
        );

        $_SESSION['messages'] = ["\"$name\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
     redirect('/admin/menu');
}
else if (isset($_POST['categoryadd'])) {
    $cname = post('cname', 150);
    $medeelel = post('medeelel', 6000);
    $imgurl = post('imgurl', 500);
    $tuluv = "1";
    $dtuluv = "0";
    $daraa = "";
    if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    
    if(isset($_POST['dtuluv']))
    {
        if(post('dtuluv', 5)=="on"){
             $dtuluv = "1";
             $daraa = $_POST['meeting-time'];
        }
        else $dtuluv = "0";
    }
    else
    {
        $dtuluv = "0";
    }

    try {
        $success = _exec(
            "insert into category(name, medeelel, imgurl, tuluv, dtuluv, daraa) VALUES(?, ?, ?, ?, ?, ?)",
            'sssiis',
            [$cname, $medeelel, $imgurl, $tuluv, $dtuluv, $daraa],
            $count
        );

        $_SESSION['messages'] = ["\"$cname\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    redirect('/admin/category');
}
else if (isset($_POST['categoryupdate'])) {
    $id = post('cIDedit', 10);
    $cname = post('cname', 150);
    $medeelel = post('medeelel', 6000);
    $imgurl = post('imgurl', 500);
    $tuluv = "1";
    $dtuluv = "0";
    $daraa = "";
    if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    
    if(isset($_POST['dtuluv']))
    {
        if(post('dtuluv', 5)=="on"){
             $dtuluv = "1";
             $daraa = $_POST['meeting-time'];
        }
        else $dtuluv = "0";
    }
    else
    {
        $dtuluv = "0";
    }
    
    try {
        $success = _exec(
            "update category set name=?, medeelel=?, imgurl=?, tuluv=?, dtuluv=?, daraa=? WHERE id=?",
            'sssiisi',
            [$cname,$medeelel,$imgurl,$tuluv, $dtuluv, $daraa, $id],
            $count
        );

        $_SESSION['messages'] = ["\"$cname\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    redirect('/admin/category');
}
else if (isset($_POST['productadd'])) {
    $name = post('proname', 100);
    $namejpn = post('pronamejpn', 150);
    $cateid = post('cateid', 10);
    $price = post('proprice', 10);
    $too = post('protoo', 10);
    $medeelel = post('medeelel', 5000);
    $imgurl = post('imgurl', 500);
    $suvargahuselttile = post('suvargahuselttile', 500);
    $tuluv = "1";
    $uldtuluv = "1";
    $aturul = "0";
    if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    if(isset($_POST['uldtuluv']))
    {
        if(post('uldtuluv', 5)=="on")
             $uldtuluv = "1";
        else $uldtuluv = "0";
    }
    else
    {
        $uldtuluv = "0";
    }
    if(isset($_POST['aturul']))
    {
        $aturul = $_POST['aturul'];
    }
    try {
        $success = _exec(
            "insert into products(name, price, too, uld, imgurl, medeelel, cateid, tuluv, turul, jpname, productsub) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            'siiissiisss',
            [$name, $price, $too, $uldtuluv, $imgurl, $medeelel, $cateid, $tuluv, $aturul, $namejpn, $suvargahuselttile],
            $count
        );

        $_SESSION['messages'] = ["\"$name\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    redirect('/admin/product');
}
else if (isset($_POST['productupdate'])) {
    $id = post('proIDedit', 10);
    $name = post('proname', 150);
    $namejpn = post('pronamejpn', 150);
    $cateid = post('cateid', 10);
    $price = post('proprice', 10);
    $too = post('protoo', 10);
    $medeelel = post('medeelel', 5000);
    $imgurl = post('imgurl', 500);
    $suvargahuselttile = post('suvargahuselttile', 500);
    $tuluv = "1";
    $uldtuluv = "1";
    $aturul = "a";
    if(isset($_POST['uldtuluv']))
    {
        if(post('uldtuluv', 5)=="on")
             $uldtuluv = "1";
        else $uldtuluv = "0";
    }
    else
    {
        $uldtuluv = "0";
    }
    if(isset($_POST['ctuluv']))
    {
        if(post('ctuluv', 5)=="on")
             $tuluv = "1";
        else $tuluv = "0";
    }
    else
    {
        $tuluv = "0";
    }
    if(isset($_POST['aturul']))
    {
        $aturul = $_POST['aturul'];
    }
    
    try {
        $success = _exec(
            "update products set name=?, price=?, too=?, uld=?, imgurl=?, medeelel=?, cateid=?, tuluv=?, turul=?, jpname=?, productsub=? WHERE id=?",
            'siiissiisssi',
            [$name, $price, $too, $uldtuluv, $imgurl, $medeelel, $cateid, $tuluv, $aturul, $namejpn, $suvargahuselttile, $id],
            $count
        );

        $_SESSION['messages'] = ["\"$name\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }
    redirect('/admin/product');
}
else if (isset($_POST['zamdogooadd'])) {

    $ognoo = post('ognoo', 150);
    try {
        $success = _exec(
            "INSERT INTO zamdognoo(hezee) VALUES(?)",
            's',
            [$ognoo],
            $count
        );

        $_SESSION['messages'] = ["\"$ognoo\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    $sql = "SELECT id, hezee FROM zamdognoo";
    $result = $con->query($sql);
    $cartcount = $result->num_rows;
    if ( $cartcount> 0)
    {
        while ($row[] = $result->fetch_assoc())
        {
            $item = $row;
            $json = json_encode($item);
        }
        echo $json;
    }
    else
    {
        echo json_encode($sql);
    }
    $con->close();
    
}
else if (isset($_POST['zamdogoodelete'])) {

    $id = post('id', 150);
    try {
        $success = _exec(
            "DELETE FROM zamdognoo WHERE id = ?",
            's',
            [$id],
            $count
        );

        $_SESSION['messages'] = ["\"$id\" утгатай гүйлгээг амжилттай үүсгэлээ. "];
    } catch (Exception $e) {
        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
         echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
    } finally {
        if (isset($e)) {
            logError($e);
        }
    }

    mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_INDEX);
    $sql = "SELECT id, hezee FROM zamdognoo";
    $result = $con->query($sql);
    $cartcount = $result->num_rows;
    if ( $cartcount> 0)
    {
        while ($row[] = $result->fetch_assoc())
        {
            $item = $row;
            $json = json_encode($item);
        }
        echo $json;
    }
    else
    {
        echo "nodata";
    }
    $con->close();
    
}