<?php
$id = $_GET['id'];

if ($id != ""){
    if (isset($_SESSION['adminid']))
    {
        try
        {
            $success = _exec("delete from wp_users where id = ?", 'i', [$id], $count);
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
redirect('/admin/users');
?>