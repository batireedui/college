                            <table id="gal-listing" class="">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="fix">Дугаар</th>
                                        <th>Захиалагч</th>
                                        <th>Хэний нэр дээр</th>
                                        <th>Утас</th>
                                        <th>Хэрэглүүр</th>
                                        <th>Хэрэглүүр/Япон</th>
                                        <th>Хүсэлт</th>
                                        <th>Хүсэлт/Япон</th>
                                        <th>Хандив</th>
                                        <th>Төрсөн</th>
                                        <th>Төрөл</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 1;
                                    if ($ccount > 0) {
                                        while (_fetch($cstmt)) {
                                            _select(
                                                $cstmtc,
                                                $ccountc,
                                                "SELECT products.name, itemgal.huselt, zproducts.price, zproducts.id, jpname, jphuselt, ymar FROM itemgal INNER JOIN products ON itemgal.productid = products.id INNER JOIN zproducts ON itemgal.zproductid = zproducts.id WHERE itemgal.orderid = ? and boner =? $fsql",
                                                "is",
                                                [$oid, $bname],
                                                $cname,
                                                $chuselt,
                                                $zprice,
                                                $zid,
                                                $jpname,
                                                $jphuselt,
                                                $ymar
                                            );
                                            $rs = "";
                                            if ($ccountc > 1) {
                                                $rs = " rowspan=$ccountc";
                                            }
                                            echo "";
                                            $av = 1;
                                            while (_fetch($cstmtc)) {
                                                if ($av == 1) {
                                                    echo "<tr>
                                                            <td $rs>$t</td>
                                                            <td $rs class='fix'><div style=''>$payid</div></td>
                                                            <td $rs>$hname></td>
                                                            <td $rs>$bname</td>
                                                            <td $rs>$zphone</td>
                                                            <td>$cname</td>
                                                            <td>$jpname</td>
                                                            <td>$chuselt</td>
                                                            <td>$jphuselt</td>
                                                            <td>" . formatMoney($zprice) . "</td>
                                                            <td $rs><div class='editcell' onblur='updateValue(this, $zid, \"tursun\")' contenteditable='true'>$tursun</div></td>
                                                            <td>$ymar</td>
                                                        </tr>";
                                                } else echo "<tr><td>$cname</td><td>$jpname</td><td>$chuselt</td>
                                                            <td>$jphuselt</td><td>" . formatMoney($zprice) . "</td><td>$ymar</td></tr>";
                                                $av++;
                                            }
                                            $t++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>