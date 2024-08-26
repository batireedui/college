<?php
$zid = $_GET['id'];
$tulsun = $_GET['amount'];
$payid = $_GET['payid'];
if ($zid != "") {
            $sqlaa = "UPDATE orders SET tuluv = '1', tulsunognoo='" . ognoo() . "', batal='admin', tulsun='$tulsun' WHERE id = '$zid'";
            if ($con->query($sqlaa)) {
            } else {
            }
            _selectRowNoParam("SELECT user_phone FROM `orders` INNER JOIN wp_users ON orders.userid = wp_users.ID WHERE payid = '$payid'", $user_phone);
            if (isset($user_phone)) {
                if($user_phone == '70128882')
                {}
                else
                {
                $sms = "Sain baina uu? Tanii $payid dugaartai zahialga batalgaajlaa. Deed buynii uild negdsen tand bayarlalaa. Tendou tuv.";
                $num = $user_phone;
                if(strlen($num) == 8){
                    $tok = "879c040741e622207ab5e0eb20812adc69ce436e";
                    $sendsms = "http://web2sms.skytel.mn/apiSend?token=" . $tok . "&sendto=" . $num . "&message=" . rawurlencode($sms);
                    $ch    = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $sendsms);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    $response = curl_exec($ch);
                    curl_close($ch);
                     _exec("insert into response(vv, og) VALUES(?, ?)", 'ss', ['batal-Utas:'.$num.$response . $sendsms, ognoo()], $lastid);
                }
            }
}}
redirect("/admin/zahialga/nopay");
