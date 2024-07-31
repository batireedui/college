<?php
$ehnii = ognooday() . " 00:00:00";
$daraa = ognooday() . " 23:00:00";
_selectNoParam(
    $stmt,
    $count,
    "SELECT teachid FROM `huzurcag` INNER JOIN huzurteacher ON huzurcag.teachid = huzurteacher.id INNER JOIN itemhuzur ON huzurcag.id = itemhuzur.huzurcagid WHERE huzurcag.hezee between '$ehnii' and '$daraa' GROUP BY teachid",
    $teachid
);
//echo  "SELECT teachid FROM `huzurcag` INNER JOIN huzurteacher ON huzurcag.teachid = huzurteacher.id INNER JOIN itemhuzur ON huzurcag.id = itemhuzur.huzurcagid WHERE huzurcag.hezee between '$ehnii' and '$daraa' GROUP BY teachid ";
if($count > 0)
{
    while(_fetch($stmt))
    {
       $cag = "";
        _selectNoParam(
            $tstmt,
            $tcount,
            "SELECT SUBSTR(huzurcag.hezee, 12, 5) as hezee, huzurteacher.utas FROM `huzurcag` INNER JOIN huzurteacher ON huzurcag.teachid = huzurteacher.id INNER JOIN itemhuzur ON huzurcag.id = itemhuzur.huzurcagid WHERE huzurcag.hezee between '$ehnii' and '$daraa' and teachid='$teachid' and huzurcag.link = 'Танхим' GROUP BY huzurcag.hezee",
            $hezee,
            $utas
        );
        $t = 1;
        $num = "";
        while(_fetch($tstmt))
        {
            
            if($t== 1 ) $cag .= $hezee;
            else $cag .= ", ".$hezee;
            $num = trim($utas);
            $t++;
        }
        $sms = "Sain bna uu? Bagsh tand " . ognooday() . "-nii udriin " . $cag . " caguudad TANHIM-aar huzriin cag avsan baina.";
        echo $sms;
        if(strlen($num) == 8){
              $tok = "879c040741e622207ab5e0eb20812adc69ce436e";
              $sendsms = "http://web2sms.skytel.mn/apiSend?token=" . $tok . "&sendto=" . $num . "&message=" . rawurlencode($sms);
              $ch    = curl_init();
              curl_setopt($ch, CURLOPT_URL, $sendsms);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
              $response = curl_exec($ch);
              curl_close($ch);
              _exec("insert into response(vv, og) VALUES(?, ?)", 'ss', ['huzurtanhim-Utas:'.$num.$response . $sendsms, ognoo()], $lastid);
              echo $response;
        }
        _selectNoParam(
            $tostmt,
            $tocount,
            "SELECT huzurcag.hezee, itemhuzur.facebook, huzurteacher.utas, huzurcag.huzurtypeid FROM `huzurcag` INNER JOIN huzurteacher ON huzurcag.teachid = huzurteacher.id INNER JOIN itemhuzur ON huzurcag.id = itemhuzur.huzurcagid WHERE huzurcag.hezee between '$ehnii' and '$daraa' and teachid='$teachid' and huzurcag.link != 'Танхим' GROUP BY huzurcag.hezee",
            $ohezee,
            $ofacebook,
            $outas,
            $ohuzurtype
        );
        $t = 1;
        $num = "";
        $htype="";
        while(_fetch($tostmt))
        {
            if($ohuzurtype == "1") $htype = "Tavan mahbodiin";
            else if($ohuzurtype == "2") $htype = "Uvug deedsiin huzur";
            else if($ohuzurtype == "4") $htype = "Amidralin zuvluguunii";
            $sms = "Sain bna uu? Bagsh tand $ohezee cagt $htype cag avsan baina.";
            $num = trim($outas);
            if(strlen($num) == 8){
                  $tok = "879c040741e622207ab5e0eb20812adc69ce436e";
                  $sendsms = "http://web2sms.skytel.mn/apiSend?token=" . $tok . "&sendto=" . $num . "&message=" . rawurlencode($sms);
                  $ch    = curl_init();
                  curl_setopt($ch, CURLOPT_URL, $sendsms);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  $response = curl_exec($ch);
                  curl_close($ch);
                  _exec("insert into response(vv, og) VALUES(?, ?)", 'ss', ['huzurtanhim-Utas:'.$num.$response . $sendsms, ognoo()], $lastid);
                  echo $response;
            }
        }
    }
} else echo "nodara";