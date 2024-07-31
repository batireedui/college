<?php
if (isset($_SESSION['userid'])) {
    if (isset($_POST['namet'])) {
        $titleT = $_POST['namet'];
        $msgT = $_POST['message'];


        try {
            $success = _exec(
                "insert into faq(title, body, turul, hezee, userid, usertype) VALUES(?, ?, ?, ?, ?, ?)",
                'ssisis',
                [$titleT, $msgT, 4, ognoo(), $_SESSION['userid'], 'admin'],
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

        $qr = "SELECT tokens FROM expo";
        $r = $con->query($qr);
        $sum = $r->num_rows;
        $last = intdiv($sum, 100);
        $mo = fmod($sum, 100);

        if ($mo != 0) $last++;
        for ($f = 1; $f <= $last; $f++) {
            $fn = ($f - 1) * 100 + 1;
            $sql = "SELECT tokens FROM expo LIMIT 100 OFFSET " . $fn;
            $result = $con->query($sql);
            $strto = "";
            $too = 0;
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $too++;
                    if ($too > 1) $strto = $strto . ", ";
                    $strto = $strto . '"' . $row["tokens"] . '"';
                }
                $strto = "[" . $strto . "]";
                $pf = '{"to": ' . $strto . ', "title": "' . trim($titleT) . '","body": "' . trim($msgT) . '", "sound": "default" }';
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://exp.host/--/api/v2/push/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => $pf,
                    CURLOPT_HTTPHEADER => array(
                        'Accept:  application/json',
                        'Accept-Encoding:  gzip, deflate',
                        'Content-Type:  application/json'
                    )
                ));

                $response = curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
            }
        }
        echo "ok";
    }
}
