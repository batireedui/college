<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php'; ?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ДЭМЖИГЧДИЙН ХОЛБООНД ЭЛСЭХЭЭР ИРСЭН ХҮСЭЛТҮҮД</h4>
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
                                        <th>Хүсэлт илгээсэн</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    _selectNoParam(
                                        $cstmt,
                                        $ccount,
                                        "SELECT wp_users.id, display_name, user_phone, user_email, demchigch_h.id, demchigch_h.hezee FROM wp_users INNER JOIN demchigch_h ON wp_users.id=demchigch_h.userid",
                                        $users_id,
                                        $display_name,
                                        $user_phone,
                                        $user_email,
                                        $d_id,
                                        $hezee
                                    );
                                    if ($ccount > 0) {
                                        $dd = 1;
                                        while (_fetch($cstmt)) {
                                            echo "<tr role='button'>
                                                    <td><div class='btn btn-primary btn-sm'>$dd</div></td>
                                                    <td>$display_name</td>
                                                    <td>$user_phone</td>
                                                    <td>$user_email</td>
                                                    <td>$hezee</td>
                                                    <td>
                                                        <button class='btn btn-success btn-sm' onclick='addDh(\"$users_id\", \"$d_id\")'>ДХ нэмэх</button>
                                                        <button class='btn btn-warning btn-sm' onclick='deleteHuselt(\"$d_id\")'>Хүсэлтийг цуцлах</button>
                                                    </td>
                                                </tr>";
                                            $dd++;
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
    
        function deleteHuselt(did) {
            let text = "Хүсэлтийг цуцлахдаа итгэлтэй байна уу?";
            if (confirm(text) == true) {
                $.ajax({
                    url: "att-user",
                    type: "POST",
                    data: {
                        mode: "delete-huselt",
                        did: did
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
        
        function addDh(userid, did) {
            let text = "Гишүүнийг дэмжигчдийн холбоонд нэмэхдээ итгэлтэй байна уу?";
            if (confirm(text) == true) {
                $.ajax({
                    url: "att-user",
                    type: "POST",
                    data: {
                        mode: "addDh-huselt",
                        userid: userid,
                        did: did
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

        function showPass(pas) {
            alert(pas);
        }

        function updateValue(element, id, turul) {
            var value = element.innerText;
            $.ajax({
                url: '/admin/zahialga/updateval',
                type: 'post',
                data: {
                    type: "userszamdupdate",
                    turul: turul,
                    id: id,
                    value: value
                },
                success: function(php_result) {
                    
                }
            })
        }
    </script>