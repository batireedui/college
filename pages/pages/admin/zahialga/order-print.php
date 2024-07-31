<?php
$el = "";
if (isset($_GET["id"])) {
    
_select(
                                    $cstmt,
                                    $ccount,
                                    "SELECT id, total, tulsun, ognoo, tuluv, info, payid FROM `orders` WHERE payid=?",
                                    "i",
                                    [$_GET["id"]],
                                    $oid,
                                    $ototal,
                                    $otulsun,
                                    $oognoo,
                                    $otuluv,
                                    $oinfo,
                                    $payid
                                );    

}

?>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .wid {
            display: inline-block;
            width: 56mm;
            background-color: #fff0ff;
            margin: auto;
        }

        .tit {
            text-align: center;
            font-weight: bold;
        }

        .lis {
            margin-top: 10px;
        }

        .lis span {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="parea">
        <div class="wid">
            <?php
            if ($ccount > 0) {
                                    while (_fetch($cstmt)) {
                                        $val = "";
                                        $tuluv = "<span class='btn btn-outline-danger btn-round' style='padding: 0px 5px 0px 5px !important;'>Төлбөр төлөгдөөгүй</span><br><a href='/front/action/deleteOrder?id=$oid' onclick='return confirm(\"Захиалга устгахдаа итгэлтэй байна уу?\")'><span class='btn btn-danger btn-round' style='padding: 1px !important;'>Устгах</span></a>";
                                        if ($otuluv == 1)
                                            $tuluv = "<span class='btn btn-outline-success btn-round' style='padding: 0px 5px 0px 5px !important;'>Төлбөр төлөгдсөн</span>";
                                        else if ($otuluv == 2)
                                            $tuluv = "<span class='btn btn-warning btn-round' style='padding: 0px 5px 0px 5px !important;'>Биелэсэн</span>";
                                        else if ($otuluv == 3)
                                         {   $tuluv = "<span class='btn btn-dark btn-round' style='padding: 0px 5px 0px 5px !important;'>Цуцлагдсан</span><br><a href='/front/action/deleteOrder?id=$oid' onclick='return confirm(\"Захиалга устгахдаа итгэлтэй байна уу?\")'><span class='btn btn-danger btn-round' style='padding: 1px !important;'>Устгах</span></a>";
                                         
                                         }
                                        _select(
                                            $zstmt,
                                            $zcount,
                                            "SELECT zproducts.id, zproducts.too, zproducts.price, products.name, products.cateid FROM `zproducts` INNER JOIN products ON zproducts.productid = products.id WHERE zproducts.orderid=?",
                                            "i",
                                            [$oid],
                                            $zid,
                                            $ztoo,
                                            $zprice,
                                            $zname,
                                            $pcateid
                                        );
                                        echo "<div style='margin-bottom: 8px'>Захиалгын дугаар: <span style='font-size: 25px;color: #e22b2b;'>$payid</span></div><div style='margin-bottom: 8px'>Огноо: $oognoo</div>";
                                        $val .= "<div><span style='font-weight: bold; font-size: 18px;'>Захиалга</span></div>";
                                        while (_fetch($zstmt)) {
                                            $val .= "<div style='font-weight: bold; margin-top: 5px'>- $zname -  $ztoo x " . formatMoney($zprice) . "₮</div>";
                                            if($pcateid == 11){
                                                _selectRowNoParam("SELECT boner, huselt FROM `itemgal` WHERE zproductid='$zid'", $boner, $huselt);
                                                $val .= "Хэнд: $boner <br>Аврал/хүсэлт: $huselt<br><br>";
                                            }
                                            if($pcateid == 13){
                                                _selectRowNoParam("SELECT huzurcag.hezee, link FROM `itemhuzur` INNER JOIN huzurcag on itemhuzur.huzurcagid = huzurcag.id WHERE zproductid='$zid'", $heze, $flink);
                                                $val .= "Таны авсан цаг: <span style='font-weight: bold; color: red'>$heze</span> <br><br> Зөвлөгөө авах төрөл: <span style='color: red'>$flink </span><br><br>";
                                                if($flink != "Танхим")
                                                {
                                                    $val .= "<span style='font-weight: 500; color: #5556CA'>Анхааруулга: Та <b style='color: red'>$flink</b> хаягт холбогдон <b style='color: red'>$payid</b> кодыг заавал илгээнэ үү.</span>";
                                                }
                                            }
                                            if($pcateid == 9){
                                                _selectRowNoParam("SELECT hend FROM `itemdevter` WHERE zproductid='$zid'", $hend);
                                                $val .= "Хэнд: $hend <br>";
                                            }
                                            if($pcateid == 12){
                                                _selectRowNoParam("SELECT ovog, ner, kod FROM `itemzamd` WHERE zproductid='$zid'", $ovog, $ner, $kod);
                                                $val .= "Овог: $ovog, Нэр: $ner, Код: $kod <br>";
                                            }
                                            if($pcateid == 5){
                                                _selectRowNoParam("SELECT tovogner, husel FROM `itemtenger` WHERE zproductid='$zid'", $tovogner, $husel);
                                                $val .= "Тахиулах хүний нэр: $tovogner, Хүсэлт/Суварга: $husel <br>";
                                            }
                                            if($pcateid == 3){
                                                _selectRowNoParam("SELECT zner, hend FROM `itemdeedes` WHERE zproductid='$zid'", $zner, $hend);
                                                $val .= "Хандив өргөсөн: $zner, Тахиулах хүний нэр: $hend <br>";
                                            }
                                            
                                        }
                                        $val .= "<div style='font-weight: bold;text-align: center; margin-top: 8px'>ДҮН: " . formatMoney($ototal) . " ₮</div><div style='text-align: center;'>$tuluv</div><div style='text-align: center; font-style: italic; margin-top: 5px'>Танд баярлалаа. <br> ТЭНДОҮ ТӨВ-70128882</div><div style='margin-top:10px;text-align: center;'>...</div>";
                                        echo $val;
                                    }
                                } else {
                                    echo "<p>Танд захиалга байхгүй байна.</p>";
                                }
                                ?>
        </div>
    </div>
    <script>
        window.onload = function() {
            printDiv();
        }
        window.onafterprint = function(e) {
            window.onfocus = function() {
                window.close();
            }
        };

        function closePrintView() {

        }

        async function printDiv() {
            var divElements = document.getElementById("parea").innerHTML;
            var oldPage = document.body.innerHTML;
            document.body.innerHTML =
                "<html><head></head><body>" +
                divElements + "</body>";

            await window.print();

        }
    </script>
</body>

</html>