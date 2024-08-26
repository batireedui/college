<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
?>
<style>
    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>
<div class="row">
    <div class="col border border-success rounded p-3 m-3">
        <div class="p-3 bg-light d-flex justify-content-between align-items-center">
            <h3>Одоо тохируулсан байгаа хичээлийн жил (<?=$this_on?>)</h3>
        </div>
                <div class="mb-4">
                        <label class="form-label" for="form2Example1" style="margin-left: 0px;">Хичээлийн жил</label>
                        <input type="text" id="jil" class="form-control" required="" placeholder="2024-2025" value="<?=$this_on?>">
                </div>
                <div class="mb-4">
                        <input type="button" class="btn btn-success" value='ХАДГАЛАХ' onclick="change()"/>
                </div>
        </div>
</div>
<?php
require ROOT . "/pages/footer.php"; ?>
<script>
    function change() {
        const regex = /^\d{4}-\d{4}$/;
        let jil = $('#jil').val().trim();
        
        const result = regex.test(jil);
        
        if(result) {
            $.ajax({
                url: "/setting/ajax",
                type: "POST",
                data: {
                    mode: "jilUpdate",
                    jil: jil
                },
                error: function(xhr, textStatus, errorThrown) {},
                beforeSend: function() {},
                success: function(data) {
                    alert(data);
                    window.location.reload();
                },
                async: true
            });
        }
        else {
            alert("Бичигдэр формат буруу байна");
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<?php
require ROOT . "/pages/end.php";
?>