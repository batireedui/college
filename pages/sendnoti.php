<?php
if (isset($_POST['newsAdd']))
{
    $titleT = 'ӨВПК';
    $msgT = 'Мэдэгдэл ирлээ';
    //$titleT = @$_POST['title'];
    $msgT = @$_POST['title'];
    
    $msgT = str_replace( "'", '', $msgT );
                
    $msgT = str_replace( '"', '', $msgT );
                
    $msgT = substr($msgT, 0, 200);
                
    $titleT = str_replace( "'", '', $titleT );
                
    $titleT = str_replace( '"', '', $titleT );
                
    $titleT = substr($titleT, 0, 60);
    
    $sum = 0;
    _selectRowNoParam(
            "SELECT count(id) FROM expo",
            $sum
        );
    if($sum > 0){

        $last = intdiv($sum, 100);
        $mo = fmod($sum, 100);
    
        if ($mo != 0) $last++;
        for ($f = 1;$f <= $last; $f++)
        {
            $fn = ($f - 1) * 100;

            _selectNoParam(
                $cstmt,
                $ccount,
                "SELECT token FROM expo WHERE token is not null LIMIT 100 OFFSET " . $fn,
                $expoToken
            );

            $strto = "";
            $too = 0;
            if ($ccount > 0)
            {
                while (_fetch($cstmt))
                {
                    $too++;
                    if ($too > 1) $strto = $strto . ", ";
                    $strto = $strto . '"' . $expoToken . '"';
                }
                $strto = "[" . $strto . "]";
                $pf = '{"to": '.$strto.', "title": "'.trim($titleT).'","body": "'.trim($msgT).'", "sound": "default" }';

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
    
                $response =curl_exec($curl);
                $err = curl_error($curl);
                curl_close($curl);
                //echo $response;
                //echo $err;
            }
    
        }
    }
}