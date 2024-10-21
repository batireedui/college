<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
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
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h3>Миний мэдээлэл</h3>
    </div>
    <form id='ajax'>
        <div class="row mb-3">
            <div class="col-md-2">
                <div class="form-outline mb-4">
                    <input type="text" name="fname" id="fname" class="form-control"  value="<?= $fname?>" required="">
                    <label class="form-label" for="fname" style="margin-left: 0px;">Овог</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-outline mb-4">
                    <input type="text" name="lname" id="lname" class="form-control"  value="<?= $lname?>" required="">
                    <label class="form-label" for="lname" style="margin-left: 0px;">Нэр</label>
                </div>
             </div>
            <div class="col-md-2">
                <div class="form-outline mb-4">
                    <input type="text" name="phone" id="phone" class="form-control"  value="<?= $phone ?>" required="">
                    <label class="form-label" for="phone" style="margin-left: 0px;">Утас</label>
                </div>
             </div>
            <div class="col-md-2">
                <div class="form-outline mb-4">
                    <input type="text" name="email" id="email" class="form-control"  value="<?= $email ?>" required>
                    <label class="form-label" for="email" style="margin-left: 0px;">E-mail</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-outline mb-4">
                    <input type="text" name="at" id="at" class="form-control"  value="<?= $at ?>" required="">
                    <label class="form-label" for="at" style="margin-left: 0px;">Албан тушаал</label>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form mb-4">
                    <select class="form-select" name="zereg">
                        <?php while(_fetch($stmtz)) { ?>
                            <option value="<?=$zid?>" <?php echo $zid == $zereg ? " selected" : "" ?> ><?=$zname?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <input type='submut' class="btn btn-warning w-100" onclick="check()" value='Хадгалах'/>
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
?>