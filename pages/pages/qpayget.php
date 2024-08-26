<?php
$zid = $_GET['payment_id'];

if ($zid != "") {
    echo $zid;
    $id = "";
    $tdate = ognoo();
    _selectRowNoParam(
        "SELECT qpayid, id FROM orders WHERE payid = '$zid'",
        $id, $orderid
    );
    if ($id !="") {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://merchant.qpay.mn/v2/auth/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_USERPWD => "TENDOU:W9OrvYCt",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $responsearr = explode(',', $response);
        $token = str_replace('"access_token":"', '', $responsearr[3]);
        $token = str_replace('"', '', $token);

        $authorization = "Authorization: Bearer " . $token;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://merchant.qpay.mn/v2/payment/check',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
         "object_type": "INVOICE",
         "object_id"  : "' . $id . '",
         "offset"     : {
             "page_number": 1,
             "page_limit" : 100
           }
        }',
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                $authorization
            ),
        ));

        $response = curl_exec($curl);
        print_r($response);
        $getjson = $response;

        $jsonArray = json_decode($getjson, true);
        $tamount = $jsonArray['paid_amount'];

        $key1 = "rows";
        $banks = $jsonArray[$key1];
        $payment_status = "";
        $payment_amount = "";
        foreach ($banks as $item) {
            $payment_status = $item['payment_status'];
            $payment_amount = $item['payment_amount'];
        }

        if ($payment_status === 'PAID') {
            echo $payment_amount . " " . $id;
            $sqla = "INSERT INTO checkers (id, niitdun, ognoo) VALUES ('$zid', '$tamount', '$tdate')";
            if ($con->query($sqla)) {
            }

            $sqlaa = "UPDATE orders SET tuluv = '1', batal='qpay', tulsun='$tamount', tulsunognoo='" . ognoo() . "' WHERE payid = '$zid'";
            if ($con->query($sqlaa)) {
            } else {
            }
            _selectRowNoParam("SELECT user_phone FROM `orders` INNER JOIN wp_users ON orders.userid = wp_users.ID WHERE payid = '$zid'", $user_phone);
            if (isset($user_phone)) {
                if($user_phone == '70128882')
                {}
                else
                {
                    $sms = "Tanii $zid dugaartai zahialga batalgaajlaa. Deed buynii uild negdsen tand bayarlalaa. Tendou tuv.";
                    $num = $user_phone;
                    if(strlen($num) == 8){
                        $tok = "879c040741e622207ab5e0eb20812adc69ce436e";
                        $sendsms = "http://web2sms.skytel.mn/apiSend?token=" . $tok . "&sendto=" . $num . "&message=" . rawurlencode($sms);
                        $ch    = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $sendsms);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        $response = curl_exec($ch);
                        curl_close($ch);
                         _exec("insert into response(vv, og) VALUES(?, ?)", 'ss', ['qpayget-Utas:'.$num.$response . $sendsms, ognoo()], $lastid);
                    }
                }
            }
            
            echo "YES";
        } else echo "no <br>";
    } else echo "noid";
} else echo "EMPTY";
