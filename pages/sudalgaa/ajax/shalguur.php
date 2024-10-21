<?php
if (isset($_SESSION['user_id'])) {
    if ($_POST["type"] == "addDed") {
        $shalguurid = $_POST["shalguurid"];
        $name = $_POST["name"];
        try {
            $success = _exec(
                "INSERT INTO shalguurdeds(name, shalguur_id, tuluv, turul, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?)",
                "siiiss",
                [$name, $shalguurid, 1, 0, ognoo(), ognoo()],
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
        _selectNoParam(
            $dstmt,
            $dcount,
            "SELECT id, name, shalguur_id, tuluv FROM shalguurdeds WHERE shalguur_id = $shalguurid and turul = '0'",
            $did,
            $dname,
            $dshalguur_id,
            $dtuluv
        );
        if ($dcount > 0) {
            echo "<table class='table table-bordered doc-table mt-3'>
        <thead>
            <tr>
                <th scope='col'>Class</th>
                <th scope='col'>Description</th>
            </tr>
        </thead>
        <tbody>";
            while (_fetch($dstmt)) {
                echo "<tr>
                    <td scope='row'>$dname</td>
                    <td>To set inherit line height</td>
                </tr>";
            };
            echo "
        </tbody>
    </table>";
        }
    } elseif ($_POST["type"] == "zaddDed") {
        $shalguurid = $_POST["zshalguurid"];
        $name = $_POST["zname"];
        try {
            $success = _exec(
                "INSERT INTO shalguurdeds(name, shalguur_id, tuluv, turul, created_at, updated_at) VALUES(?, ?, ?, ?, ?, ?)",
                "siiiss",
                [$name, $shalguurid, 1, 1, ognoo(), ognoo()],
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
        _selectNoParam(
            $dstmt,
            $dcount,
            "SELECT id, name, shalguur_id, tuluv FROM shalguurdeds WHERE shalguur_id = $shalguurid and turul = '1'",
            $did,
            $dname,
            $dshalguur_id,
            $dtuluv
        );
        if ($dcount > 0) {
            echo "<table class='table table-bordered doc-table mt-3'>
        <thead>
            <tr>
                <th scope='col'>Class</th>
                <th scope='col'>Description</th>
            </tr>
        </thead>
        <tbody>";
            while (_fetch($dstmt)) {
                echo "<tr>
                    <td scope='row'>$dname</td>
                    <td>To set inherit line height</td>
                </tr>";
            };
            echo "
        </tbody>
    </table>";
        }
    }
}
