<?php
require ROOT . '/pages/api/header.php';
require ROOT . '/pages/api/css.php';
if(isset($_GET["token"]))
{
    $userinfo = _teacherAuth($_GET["token"]);
    if(!empty($userinfo)){
        $user_id = $userinfo['id'];
        _selectRowNoParam(
            "SELECT fname, lname, phone, email, at, zereg FROM teacher WHERE id = $user_id",
            $fname,
            $lname,
            $phone,
            $email,
            $at,
            $zereg
        );
        
        _selectNoParam(
            $stmtz,
            $countz,
            "SELECT id, name FROM tzereg order by id desc",
            $zid,
            $zname
        );
        ?>
        <div>
            <form id='ajax'>
            <div class="row mb-3">
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <input type="text" name="fname" class="form-control"  value="<?= $fname?>" required="">
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">Овог</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <input type="text" name="lname" class="form-control"  value="<?= $lname?>" required="">
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">Нэр</label>
                    </div>
                 </div>
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <input type="text" name="phone" class="form-control"  value="<?= $phone ?>" required="">
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">Утас</label>
                    </div>
                 </div>
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <input type="text" name="email" class="form-control"  value="<?= $email ?>" required>
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">E-mail</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <input type="text" name="at" class="form-control"  value="<?= $at ?>" required="">
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">Албан тушаал</label>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-outline mb-4">
                        <select class="form-select" name="zereg">
                            <?php while(_fetch($stmtz)) { ?>
                                <option value="<?=$zid?>" <?php echo $zid == $zereg ? " selected" : "" ?>><?=$zname?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type='submut' class="btn btn-warning w-100" onclick="check()" value='Хадгалах'/>
                </div>
            </div>
            </div>
            </form>
            <div id="table">
        
            </div>
        </div>
        <?php
        require ROOT . "/pages/footer.php"; ?>
        <script>
            function check() {
                var form = $('#ajax');
                event.preventDefault();
        
                //SERIALIZE THE FORM DATA
                var formData = $(form).serialize();
                    $("#table").html("");
                    
                    $.ajax({
                        url: "/profile/ajax",
                        type: "POST",
                        data: formData,
                        error: function(xhr, textStatus, errorThrown) {
                            $("#table").html("Алдаа гарлаа !");
                        },
                        beforeSend: function() {
                            $("#table").html("Түр хүлээнэ үү ...");
                        },
                        success: function(data) {
                            $("#table").html(data);
                        },
                        async: true
                    });
                
            }
        </script>
<?php
require ROOT . "/pages/end.php";
}
    else echo "noAuth";
}
else echo "tokenExpired";
?>