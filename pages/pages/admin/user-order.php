<?php 
$userid = $_POST["userid"];
_selectNoParam(
    $st,
    $co,
    "SELECT zner, hend, itemdeedes.zognoo FROM `orders` INNER JOIN itemdeedes ON orders.id = itemdeedes.orderid WHERE tuluv = '1' and orders.userid = $userid",
    $zner, $hend, $ognoo
    );
?>
    <table class="table table-bordered">
        <thead>
            <td>ЗОЁ</td>
            <td>ӨДАЁ</td>
            <td>ГТЁ</td>
            <td>Тэнгэрийн суварга</td>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td><?php
                $d = 1;
                    while(_fetch($st)){
                       echo "$d) $zner, $hend, $ognoo <br>";
                       $d++;
                    }
                ?></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>
<?php 

?>