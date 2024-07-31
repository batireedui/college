<?php require ROOT . '/pages/admin/start.php'; ?>
<?php require ROOT . '/pages/admin/header.php';
$tuluv = ""; ?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <p class="card-title">МЭДЭГДЭЛ ИЛГЭЭХ</p>
                        <div class="col-md-4">
                            <label for="name">Мэдээллийн гарчиг</label>
                            <input type="text" class="form-control" name="namet" id="namet" onkeyup="countChar(this)" placeholder="Гарчиг аа энд бичнэ" required />
                            <div id="charNum" style="text-align: right;color: #ae0303;font-size: 14px;">20</div>
                        </div>

                        <div class="col-md-4">
                            <label for="message">Мэдээлэл</label><br>

                            <textarea rows="10" name="message" id="message" placeholder="Агуулга" onkeyup="countChars(this)" class="form-control" required></textarea>
                            <div id="charNums" style="text-align: right;color: #ae0303;font-size: 14px;">200</div>
                        </div>
                        <div class="mb-6">
                            <input type="button" class="btn btn-primary" id="subbtn" onclick="sendNoti()" value="Илгээх" />
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    <table id="datalist" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Гарчиг</th>
                                <th>Мэдээлэл</th>
                                <th>Хэзээ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            _selectNoParam(
                                $cstmt,
                                $ccount,
                                'SELECT title, body, hezee FROM `faq` WHERE turul = 4',
                                $title,
                                $body,
                                $hezee
                            );
                            if ($ccount > 0) {
                                $dd = 1;
                                while (_fetch($cstmt)) {
                                    echo "<tr role='button'>
                                                    <td>$dd</td>
                                                    <td>$title</td>
                                                    <td>$body</td>
                                                    <td>$hezee</td>
                                                </tr>";
                                    $dd++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php require ROOT . '/pages/admin/footer.php'; ?>
            <script>
                function countChar(val) {
                    var len = val.value.length;
                    if (len >= 65) {
                        val.value = val.value.substring(0, 65);
                    } else {
                        $('#charNum').text(65 - len);
                    }
                };

                function countChars(val) {
                    var len = val.value.length;
                    if (len >= 240) {
                        val.value = val.value.substring(0, 240);
                    } else {
                        $('#charNums').text(240 - len);
                    }
                };

                function sendNoti(id) {
                    var namet = document.getElementById('namet').value;
                    var message = document.getElementById('message').value;
                    $.ajax({
                        url: '/admin/noti/sendnoti',
                        type: 'POST',
                        data: jQuery.param({
                            namet: namet,
                            message: message
                        }),
                        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                        error: function(xhr, textStatus, errorThrown) {
                            //$("#modal-text").html("Алдаа гарлаа !");
                        },
                        beforeSend: function() {
                            $('#subbtn').prop('disabled', true);
                            $('#subbtn').val("Илгээж байна ...");
                        },
                        success: function(detialres) {
                            location.reload();
                        }
                    });
                }
            </script>
            <?php require ROOT . '/pages/admin/dataTablefooter.php'; ?>