<?php
print_r($_POST); 
if ($_POST['type'] == "removeid"){
    try
        {
            $success = _exec("delete from productsubid where id = ?", 'i', [$_POST['id']], $count);
        }
        catch(Exception $e)
        {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        }
        finally
        {
            if (isset($e))
            {
                logError($e);
            }
        }
}
else if ($_POST['type'] == "addsubid"){
    try
        {
            $success = _exec("insert into productsubid(pid, subid) VALUES(?, ?)", 'ii', [$_POST['pid'], $_POST['subid']], $lastid);
        }
        catch(Exception $e)
        {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        }
        finally
        {
            if (isset($e))
            {
                logError($e);
            }
        }
}
else if ($_POST['type'] == "addproductsub"){
    echo "addproductsub";
    try
        {
            $success = _exec("insert into productsub(name, price, productid, cateid, info, turul, tuluv, jphname) VALUES(?, ?, ?, ?, ?, ?, ?, ?)", 'sisissis', [$_POST['name'], '', '', '11', $_POST['info'], $_POST['turul'], '1', $_POST['jpname']], $lastid);
        }
        catch(Exception $e)
        {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        }
        finally
        {
            if (isset($e))
            {
                logError($e);
            }
        }
}
?>