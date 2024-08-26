<?php
if ($_POST['type'] == "zamdsms") {
    $id = $_POST['id'];
    _selectRowNoParam("SELECT kod, utas FROM `itemzamd` WHERE id = '$id'", $kod, $utas);
    if (isset($utas)) {
        $sms = "Sain baina uu? Tanii zamd oroh ysloliin code: $kod Tendou tuv.";
        $num = $utas;
        if (strlen($num) == 8 && strlen($kod) > 1) {
            $tok = "879c040741e622207ab5e0eb20812adc69ce436e";
            $sendsms = "http://web2sms.skytel.mn/apiSend?token=" . $tok . "&sendto=" . $num . "&message=" . rawurlencode($sms);
            $ch    = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sendsms);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            _exec("insert into response(vv, og) VALUES(?, ?)", 'ss', ['zamdcode-Utas:' . $num . $response . $sendsms, ognoo()], $lastid);
            _exec("UPDATE itemzamd SET sms = sms+1 WHERE id = ?", 'i', [$id], $lastid);
            echo "$utas ЗОЁ-н $kod код илгээгдлээ.";
        }
        else echo "Утасны дугаар эсвэл ЗОЁ-н код олдсонгүй.";
    }
    else echo "Утасны дугаар олдсонгүй.";
}
