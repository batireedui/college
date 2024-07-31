<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php'; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Дэмжигчдийн холбооны гишүүд</h4>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="datalist" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Нэр</th>
                                        <th>Утас</th>
                                        <th>Email</th>
                                        <th>Идэвх</th>
                                        <th>ДХ оноо</th>
                                        <th>Бүртгэсэн</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    _selectNoParam(
                                        $cstmt,
                                        $ccount,
                                        'SELECT wp_users.id, display_name, user_phone, user_email, user_pass, zamd, zamdorson, hezee, onoo, demjigch.id FROM wp_users INNER JOIN demjigch ON wp_users.id = demjigch.userid',
                                        $users_id,
                                        $display_name,
                                        $user_phone,
                                        $user_email,
                                        $user_pass,
                                        $zamd,
                                        $zamdorson,
                                        $hezee,
                                        $onoo,
                                        $d_id
                                    );
                                    
                                    if ($ccount > 0) {
                                        $dd = 1;
                                        while (_fetch($cstmt)) { ?>
                                                <tr role='button'>
                                                    <td><div class='btn btn-primary btn-sm'><?=$dd?></div></td>
                                                    <td><?=$display_name?></td>
                                                    <td><?=$user_phone?></td>
                                                    <td><?=$user_email?></td>
                                                    <td>
                                                        <?php 
                                                        _selectRowNoParam(
                                                            "SELECT COUNT(zproducts.id) FROM `zproducts` INNER JOIN orders ON zproducts.orderid = orders.id WHERE orders.userid = '$users_id'", $order_onoo);
                                                        _selectRowNoParam(
                                                            "SELECT COUNT(id) FROM `faq` WHERE userid = '$users_id' and usertype = 'user'", $faq_onoo);
                                                        _selectRowNoParam(
                                                            "SELECT COUNT(id) FROM `att` WHERE userid = '$users_id'", $att_onoo);
                                                            echo $order_onoo + $faq_onoo + $att_onoo;
                                                        ?>
                                                    </td>
                                                    <td><div class='editcell' onblur='updateValue(this, "<?=$d_id?>", "onoo")' contenteditable><?=$onoo?></div></td>
                                                    <td><?=$hezee?></td>
                                                    <td>
                                                      <button class='btn btn-warning btn-sm' onclick='removeHolboo(<?=$users_id?>)'>Холбооноос хасах</button></a>
                                                    </td>
                                                </tr>
                                        <?php  $dd++;
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
    <?php require ROOT . '/pages/admin/dataTablefooter.php'; ?>
    <script>
        function removeHolboo(userid){
            let text = "Гишүүнийг дэмжигчдийн холбооноос хасахдаа итгэлтэй байна уу?";
            if (confirm(text) == true) {
                $.ajax({
                    url: "att-user",
                    type: "POST",
                    data: {
                        mode: "removeHolboo",
                        userid: userid
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        
                    },
                    beforeSend: function() {
                        
                    },
                    success: function(data) {
                        alert(data);
                        location.reload();
                    },
                    async: true
                });
            }
        }
        function updateValue(element, id, turul) {
            var value = element.innerText;
            $.ajax({
                url: '/admin/zahialga/updateval',
                type: 'post',
                data: {
                    type: "demjigchonoo",
                    turul: turul,
                    id: id,
                    value: value
                },
                success: function(php_result) {
                    console.log(php_result);
                }
            })
        }
    </script>