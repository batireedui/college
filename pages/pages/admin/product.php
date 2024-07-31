<?php require 'start.php'; ?>
<?php require 'header.php'; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">БҮТЭЭГДЭХҮҮНИЙ ЖАГСААЛТ</p>
                        <div class="row" style="justify-content: flex-end;">
                            <div style="margin-left: 20px;">
                                <a href='/admin/addpage/productAdd'>
                                    <button type="button" class="btn btn-primary">
                                        БҮТЭЭГДЭХҮҮН НЭМЭХ
                                    </button>
                                </a>
                            </div>
                            <div style="margin-left: 20px;">
                                <a href='/admin/addpage/suvargaAdd'>
                                    <button type="button" class="btn btn-light">
                                        ДЭД СУВАРГА НЭМЭХ
                                    </button>
                                </a>
                            </div>
                        </div>
                        <?php
                        _selectNoParam(
                            $cstmt,
                            $ccount,
                            "SELECT products.id, products.name, products.price, products.too, products.imgurl, products.medeelel, category.name as cname, products.tuluv, products.uld FROM products INNER JOIN category ON products.cateid = category.id",
                            $id,
                            $name,
                            $price,
                            $too,
                            $imgurl,
                            $medeelel,
                            $cateid,
                            $tuluv,
                            $uld
                        ); ?>
                        <div class="table-responsive">
                            <table id="products_table" class='table table-striped table-borderless' style="width: 100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Нэр</th>
                                        <th>Үнэ</th>
                                        <th>Үлдэгдэл</th>
                                        <th>Ангилал</th>
                                        <th>Төлөв</th>
                                        <th colspan="2">Үйлдэл</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th><input type="text" id="filtername" class='form-control' onkeyup='filterv(1)' placeholder="Нэрээр хайх" /></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php
                                            _selectNoParam(
                                                $castmt,
                                                $cacount,
                                                "SELECT DISTINCT category.name FROM products INNER JOIN category ON products.cateid = category.id",
                                                $caname
                                            );
                                            if ($cacount > 0) {
                                                echo "<select id='filtercate' class='form-control' onchange='filterv(4)'><option value=''>Бүгд</option>";
                                                while (_fetch($castmt)) {
                                                    echo "<option>$caname</option>";
                                                }
                                                echo "</select>";
                                            }
                                            ?>
                                        </th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <?php
                                $ntoo = 1;
                                if ($ccount > 0) {
                                    while (_fetch($cstmt)) {
                                        echo "<tr>
                                            <td>$ntoo</td>
                                            <td>$name</td>
                                            <td>$price</td><td>";
                                        echo $uld ? "<span class='btn btn-success btn-sm'>$too</span>" : "<span class='btn btn-warning btn-sm'>$too</span>";
                                        echo "</td><td>$cateid</td>";
                                        echo $tuluv == "1" ?
                                                    "<td>
                                                <button type='button' class='btn btn-success btn-sm'>
                                                    Идэвхтэй
                                                </button>
                                            </td>" :
                                                    "<td>
                                                <button type='button' class='btn btn-dark btn-sm'>
                                                    Идэвхгүй
                                                </button>
                                            </td>";
                                        echo  "<td><a href='/admin/addpage/productAdd?id=$id'>
                                                <button type='button' class='btn btn-outline-info btn-icon-text btn-sm'>Засах
                                                    <i class='ti-file btn-icon-append'></i>                          
                                                </button></a></td>
                                            <!--<td><a href='#'>
                                                <button type='button' class='btn btn-outline-danger btn-icon-text btn-sm'>Устгах
                                                    <i class='ti-trash btn-icon-append'></i>                        
                                                </button></a></td>-->
                                        </tr>";
                                        $ntoo++;
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>Мэдээлэл байхгүй байна</td></tr>";
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php require 'footer.php'; ?>
            <script type="text/javascript">
                function filterv(val) {
                    var input, filter, table, tr, td, i, txtValue;
                    if (val === 4) {
                        input = document.getElementById("filtercate");
                    } else if (val === 1) {
                        input = document.getElementById("filtername");
                    }
                    
                    filter = input.value.toUpperCase();
                    console.log(filter);
                    table = document.getElementById("products_table");
                    tr = table.getElementsByTagName("tr");
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[val];
                        if (td) {
                            txtValue = td.textContent;
                            console.log(txtValue + " *******" + filter + " **** "  + txtValue.toUpperCase().indexOf(filter))
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }

                function editM(id, name) {
                    console.log("ok" + name);
                    document.querySelector('#menuidedit').value = id;
                    document.querySelector('#menutitleedit').value = name;
                }
                /*
                function editM(modalID) {

                    if (modalID) {
                        document.querySelector('#MenuIDedit').value = modalID;
                        $.ajax({
                            url: '/api/menuEdit',
                            type: "POST",
                            data: {
                                'id': modalID
                            },
                            error: function(request, error) {
                                console.log(request);
                                alert(" Can't do because: " + error);
                            },
                            success: function(data) {
                                $('#editTitle').val(data.title);
                                $('#editimgurl').val(data.imgurl);
                                const $selecte = document.querySelector('#editmenuid');
                                document.querySelector('#editmenuid').value = data.menuid;
                                EditEditor.setData(data.body);
                            }
                        });
                    } else {
                        console.log(modalID + " no");
                    }
                };*/
            </script>
            <?php require 'end.php'; ?>