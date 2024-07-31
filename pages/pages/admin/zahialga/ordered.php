<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php'; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ЗАХИАЛГА ХҮРГЭГДСЭН</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="row" style="margin-top: 10px">
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterInput" class="form-control" onkeyup="tablefilter(1)" placeholder="Захиалгын дугаараар хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterName" class="form-control" onkeyup="tablefilter(2)" placeholder="Захиалагчийн нэрээр хайх">
                            </div>
                            <div class="col-sm-3" style="display: flex; justify-content: flex-end;">
                                <input type="text" id="filterPhone" class="form-control" onkeyup="tablefilter(5)" placeholder="Утасны дугаараар хайх">
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="order-listing" class="table">
                                <thead>
                                    <tr>
                                        <th>Захиалга #</th>
                                        <th>Хэрэглэгч</th>
                                        <th>Огноо</th>
                                        <th>Хүргэлт</th>
                                        <th>Төлбөр</th>
                                        <th>Төлсөн төрбөр</th>
                                        <th>Төрөл</th>
                                        <th>Үйлдэл</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    _select(
                                        $cstmt,
                                        $ccount,
                                        'SELECT orders.id, concat(wp_users.firstname, " ", wp_users.lastname), wp_users.user_phone, orders.ognoo, orders.total, shipping FROM `orders` INNER JOIN wp_users ON orders.userid = wp_users.ID WHERE tuluv = ?',
                                        "i",
                                        ['2'],
                                        $oid,
                                        $oname,
                                        $ophone,
                                        $oognoo,
                                        $ototal,
                                        $shipping
                                    );
                                    if ($ccount > 0) {
                                        while (_fetch($cstmt)) {
                                            echo "<tr>
                                                    <td>1</td>
                                                    <td>$oname</td>
                                                    <td>$oognoo</td>
                                                    <td>$shipping</td>
                                                    <td>" . formatMoney($ototal) . "₮</td>
                                                    <td>3200</td>
                                                    <td>
                                                      <label class='badge badge-info'>Хүслийн дэвтэр</label>
                                                    </td>
                                                    <td>
                                                      <button class='btn btn-outline-primary'>Дэлгэрэнгүй</button>
                                                    </td>
                                                </tr>";
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