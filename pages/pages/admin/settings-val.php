<?php
if (isset($_POST['mode']) && isset($_SESSION['userid'])) {
    if($_POST['mode'] == "tsas"){
        $val = $_POST['val'];
        $value = 0;
        if($val == "true"){
           $value = 1; 
        }
        try {
            $success = _exec(
                "update `setting` set cas=?",
                'i',
                [$value],
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
        echo "Амжилттай";
    }
    else if($_POST['mode'] == "dans"){
        $dans = $_POST['dans'];
        $dansner = $_POST['dansner'];
        try {
            $success = _exec(
                "update `setting` set dans=?, dansner=?",
                'ss',
                [$dans, $dansner],
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
        echo "Амжилттай";
    }
    else if($_POST['mode'] == "passchange"){
        $pass = $_POST['pass'];
        $oldpass = $_POST['oldpass'];
        _selectRowNoParam(
            "SELECT id FROM adminusers WHERE passw='$oldpass' and id = " . $_SESSION['userid'],
            $dbpass
        );
        if(!empty($dbpass)){
            try {
                $success = _exec(
                    "update `adminusers` set passw=? WHERE id='$dbpass'",
                    's',
                    [$pass],
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
            echo "Амжилттай";
        }
        else echo "Хуучин нууц үг буруу байна";
    }
}