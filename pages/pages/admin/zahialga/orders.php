<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php'; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ТӨЛБӨР ТӨЛӨГДСӨН</h4>
                <div class="row">
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1)" placeholder="Захиалгын дугаараар ...">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(2)" placeholder="Нэрээр хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(7)" placeholder="Утасны дугаараар ...">
                            </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Дугаар</th>
                                        <th>Хэрэглэгч</th>
                                        <th>Огноо</th>
                                        <th>Төлбөр</th>
                                        <th>Төлсөн</th>
                                        <th>Утас</th>
                                        <th>Ангилал</th>
                                        <th>Үйлдэл</th>
                                        <th>Qpay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $t = 1;
                                    if ($countOrders > 0) {
                                        while (_fetch($stmtOrders)) {
                                            echo "<tr>
                                                    <td>$t</td>
                                                    <td>
                                                      <a href='/admin/zahialga/order-print?id=$payid' target='_blank'>
                                                        <div  class='btn btn-info btn-sm' onclick='printOrder(\"$payid\")'>
                                                            $payid
                                                        </div>
                                                      </a>
                                                    </td>
                                                    <td>$onameOrders</td>
                                                    <td>$oognooOrders</td>
                                                    <td>" . formatMoney($ototalOrders) . "₮</td>
                                                    <td>$tulsunOrders</td>
                                                    <td>$ophoneOrders</td><td>";
                                            _select(
                                                $stmtOrdersc,
                                                $countOrdersc,
                                                'SELECT DISTINCT category.name FROM `zproducts` INNER JOIN products ON zproducts.productid = products.id INNER JOIN category ON products.cateid = category.id WHERE zproducts.orderid = ?',
                                                "i",
                                                [$oidOrders],
                                                $cname
                                            );
                                            while (_fetch($stmtOrdersc)) {
                                                echo "<label class='badge badge-warning' style='margin-top: 3px'>$cname</label><br>";
                                            }
                                            echo "</td>
                                                    <td>
                                                    <a href='/admin/zahialga/cancelorder?id=$oidOrders' onclick='return confirm(\"$payid дугаартай захиалга цуцлах уу?\")'>
                                                      <button class='btn btn-danger btn-sm'>Цуцлах</button>
                                                      </a>
                                                    </td>
                                                    <td>$batalOrders</td>
                                                </tr>";
                                            $t++;
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require ROOT . '/pages/admin/footer.php'; ?>
    <script>
        function tablefilter(val) {
            var input, filter, table, tr, td, i;
            if (val === 1) {
                input = document.getElementById("filterInput");
            } else if (val === 2) {
                input = document.getElementById("filterName");
            } else {
                input = document.getElementById("filterPhone");
            }
            filter = input.value.toUpperCase();
            table = document.getElementById("order-listing");
            tr = table.getElementsByTagName("tr");
            var show = true;
            var spannedRows = 0;
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[val];
                if (spannedRows > 0) {
                    if (show)
                        tr[i].style.display = "";
                    else
                        tr[i].style.display = "none";
                    spannedRows--;
                } else if (td) {
                    if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                    let rs = td.getAttribute("rowspan");
                    console.log("rs = " + rs);
                    if (rs && rs > 1) {
                        show = td.innerHTML.toUpperCase().indexOf(filter) > -1;
                        spannedRows = rs - 1;
                    }
                }
            }
        }
    </script>