<?php
if (isset($_SESSION['user_id'])) {
    if (isset($_POST["id"])) {
        $id = $_POST["id"];
        try {
            $success = _exec(
                "UPDATE angis SET tuluv = 1 WHERE id = ?",
                "i",
                [$id],
                $count
            );

            $success = _exec(
                "UPDATE students SET tuluv = 2 WHERE angi_id = ?",
                "i",
                [$id],
                $count
            );
            echo "Амжилттай!";
        } catch (Exception $e) {
            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
            // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
    }
}
