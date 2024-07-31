<?php
$id = $_GET['id'];

if ($id != ""){
    if (isset($_SESSION['adminid']))
    {
        try
        {
            
            /*mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
            $sqls = "SELECT productid, too from zproducts where orderid = '$id'";
            $resulta = $con->query($sqls);
            $cartcount = $resulta->num_rows;
            if ($cartcount > 0) {
                while ($row = $resulta->fetch_assoc()) {
                _selectRowNoParam(
                        "SELECT uld, too FROM `products` WHERE id='" . $row['productid'] . "'",
                        $puld,
                        $ptoo
                    );
                    if ($puld == "1") {
                        $uldegdel = (int)$ptoo + (int)$row['too'];
                        _exec("UPDATE products SET too=? WHERE id=?", 'ii', [$uldegdel, $row['productid']], $up);
                    }
            
                }
            }
            $success = _exec("delete from orders where id = ?", 'i', [$id], $count);
            $success = _exec("delete from zproducts where orderid = ?", 'i', [$id], $count);
            
            $success1 = _exec("delete from itemazjargal where orderid = ?", 'i', [$id], $count1);
            $success2 = _exec("delete from itemdevter where orderid = ?", 'i', [$id], $count2);
            $success3 = _exec("delete from itemhuuhed where orderid = ?", 'i', [$id], $count3);
            $success4 = _exec("delete from itemmanal where orderid = ?", 'i', [$id], $count4);
            $success5 = _exec("delete from itemtenger where orderid = ?", 'i', [$id], $count5);
            $success6 = _exec("delete from itemdeedes where orderid = ?", 'i', [$id], $count6);
            $success7 = _exec("delete from itemzamd where orderid = ?", 'i', [$id], $count7);
            $success9 = _exec("delete from itemgal where orderid = ?", 'i', [$id], $count9);*/
            _exec("UPDATE orders SET tuluv='5' where id = ?", 'i', [$id], $count);
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
}
redirect('/admin/zahialga/nopay');
?>