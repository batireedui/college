<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';

_selectNoParam(
    $sta,
    $coa,
    "SELECT id, name FROM att_turul WHERE tuluv = 1",
    $att_turulid,
    $att_turulname
);
?>
<style>
    .modalsm {
        width: 40%;
        margin: 15% auto 15% 35%;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ГИШҮҮДИЙН ИРЦ БҮРТГЭЛ</h4>
                <div class="row">
                    <div class="col-12">
                        <div id="myModal" class="modal">
                            <div class="modal-content modalsm">
                                <span class="close">&times;</span>
                                <div id="modal-dbody">
                                    <div id="att_name" style="margin-bottom: 15px;">

                                    </div>
                                    <div class="row" style="margin-bottom: 15px;">
                                        <div class="col">
                                            <select class="form-control" id="att_id">
                                                <?php while (_fetch($sta)) { ?>
                                                    <option value="<?= $att_turulid ?>"><?= $att_turulname ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col">
                                            <input type="date" class="form-control" id="att_hezee" value="<?php echo date('Y-m-d'); ?>" />
                                            <input type="text" id="att_userid" style="display: none;" />
                                        </div>
                                        <div class="col">
                                            <input type="button" class="btn btn-success" value="ХАДГАЛ" onclick="insertAtt()" />
                                        </div>
                                    </div>
                                    <div id="modal-text">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="datalist" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Ирцийн төрөл</th>
                                        <th>Хэзээ</th>
                                        <th>Нэр</th>
                                        <th>Утас</th>
                                        <th>Email</th>
                                        <th>Бүртгэсэн</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    _selectNoParam(
                                        $cstmt,
                                        $ccount,
                                        'SELECT wp_users.id, display_name, user_phone, user_email, hezee, whezee, name, att.id FROM wp_users INNER JOIN att ON wp_users.ID = att.userid INNER JOIN att_turul ON att.att_turul = att_turul.id;',
                                        $users_id,
                                        $display_name,
                                        $user_phone,
                                        $user_email,
                                        $hezee,
                                        $whezee,
                                        $turul,
                                        $attid
                                    );
                                    if ($ccount > 0) {
                                        $dd = 1;
                                        while (_fetch($cstmt)) {
                                            echo "<tr>
                                                    <td>$dd</td>
                                                    <td>$turul</td>
                                                    <td>".date_format(date_create($hezee),"Y.m.d")."</td>
                                                    <td id='v1$users_id'>$display_name</td>
                                                    <td id='v2$users_id'>$user_phone</td>
                                                    <td id='v3$users_id'>$user_email</td>
                                                    <td>$whezee</td>
                                                    <td><div class='btn btn-danger btn-sm' onclick='deleteAtt($attid)'>УСТГАХ</div></td>
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
        function deleteAtt(id) {
            let text = "Устгахдаа итгэлтэй байна уу!";
            if (confirm(text) == true) {
                $.ajax({
                    url: "att-user",
                    type: "POST",
                    data: {
                        mode: "delete",
                        id: id
                    },
                    error: function(xhr, textStatus, errorThrown) {
                       
                    },
                    beforeSend: function() {
                        
                    },
                    success: function(data) {
                        location.reload();
                    },
                    async: true
                });
            }
        }
    </script>