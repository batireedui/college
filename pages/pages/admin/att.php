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
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto 15% 15%;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        color: #000;
        float: right !important;
        font-size: 28px;
        font-weight: bold;
        text-align: end;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .modalsm {
        width: 40%;
        margin: 15% auto 15% 35%;
    }
</style>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">ГИШҮҮДИЙН ИРЦ БҮРТГЭХ</h4>
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
                                        <th>Нэр</th>
                                        <th>Утас</th>
                                        <th>Email</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    _selectNoParam(
                                        $cstmt,
                                        $ccount,
                                        'SELECT id, display_name, user_phone, user_email, user_pass FROM wp_users',
                                        $users_id,
                                        $display_name,
                                        $user_phone,
                                        $user_email,
                                        $user_pass
                                    );
                                    if ($ccount > 0) {
                                        $dd = 1;
                                        while (_fetch($cstmt)) {
                                            echo "<tr>
                                                    <td>$dd</td>
                                                    <td id='v1$users_id'>$display_name</td>
                                                    <td id='v2$users_id'>$user_phone</td>
                                                    <td id='v3$users_id'>$user_email</td>
                                                    <td role='button' onclick='showData($users_id)'>
                                                      <div class='btn btn-success btn-sm'>ИРЦ БҮРТГЭХ</div>
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
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];

        function insertAtt() {
            $.ajax({
                url: "att-user",
                type: "POST",
                data: {
                    mode: "add",
                    userid: $('#att_userid').val(),
                    hezee: $('#att_hezee').val(),
                    turul: $('#att_id').val(),
                    henturul: 'admin'
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#modal-text").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $('#modal-text').html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    showData($('#att_userid').val());
                },
                async: true
            });
        }

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
                        $("#modal-text").html("Алдаа гарлаа !");
                    },
                    beforeSend: function() {
                        $('#modal-text').html("Түр хүлээнэ үү ...");
                    },
                    success: function(data) {
                        showData($('#att_userid').val());
                    },
                    async: true
                });
            }
        }

        function showData(userid) {
            let name = $('#v1' + userid).html() + ", " + $('#v2' + userid).html() + ", " + $('#v3' + userid).html();
            $('#att_name').html(name);
            $('#att_userid').val(userid);

            modal.style.display = "block";
            $.ajax({
                url: "att-user",
                type: "POST",
                data: {
                    mode: "get",
                    userid: userid
                },
                error: function(xhr, textStatus, errorThrown) {
                    $("#modal-text").html("Алдаа гарлаа !");
                },
                beforeSend: function() {
                    $('#modal-text').html("Түр хүлээнэ үү ...");
                },
                success: function(data) {
                    $('#modal-text').html(data);
                },
                async: true
            });
        }

        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>