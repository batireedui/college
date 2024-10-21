<?php
if(isset($_POST["userid"]))
{
        $user_id = $_POST["userid"];
        if($_POST["mode"] == "my") {
            _selectRowNoParam(
                "SELECT lname, phone, email FROM parent WHERE id = $user_id",
                $lname,
                $phone,
                $email
            );
            ?>
                <div class="row mb-3">
                    <div class="col-md-2 mb-3">
                            <label class="form-label" for="mylname" style="margin-left: 0px;">Нэр</label>
                            <input type="text" name="mylname" id="mylname" class="form-control"  value="<?= $lname?>" required="">
                     </div>
                    <div class="col-md-2 mb-3">
                            <label class="form-label" for="myphone" style="margin-left: 0px;">Утас</label>
                            <input type="text" name="myphone" id="myphone" class="form-control"  value="<?= $phone ?>" required="">
                     </div>
                    <div class="col-md-2 mb-3">
                            <label class="form-label" for="myemail" style="margin-left: 0px;">E-mail</label>
                            <input type="text" name="myemail" id="myemail" class="form-control"  value="<?= $email ?>">
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type='button' class="btn btn-danger w-100" onclick="myinfo(<?=$user_id?>)" value='Хадгалах'/>
                    </div>
                </div>
        <?php } elseif($_POST["mode"] == "pass"){ ?>
                <div class="row mb-3">
                    <div class="col-md-2 mb-3">
                            <label class="form-label" for="pass" style="margin-left: 0px;">Хуучин нууц үг</label>
                            <input type="password" name="pass" id="pass" class="form-control"   required="">
                     </div>
                    <div class="col-md-2 mb-3">
                            <label class="form-label" for="newpass" style="margin-left: 0px;">Шинэ нууц үг</label>
                            <input type="password" name="newpass" id="newpass" class="form-control" required="">
                     </div>
                    <div class="col-md-2 mb-3">
                            <label class="form-label" for="newpasscheck" style="margin-left: 0px;">Шинэ нууц үг давтах</label>
                            <input type="password" name="newpasscheck" id="newpasscheck" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <input type='button' class="btn btn-warning w-100" id= "btnpass" onclick="mypass(<?=$user_id?>)" value='Хадгалах'/>
                    </div>
                </div>
    <?php  } else echo "Хандах эрхгүй байна!";
}
else echo "Хандах эрхгүй байна!";
?>