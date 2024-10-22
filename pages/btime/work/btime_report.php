<?php
require ROOT . "/pages/start.php"; ?>
<style>
    #upload_file {
        display: none;
    }
</style>
<?php
require ROOT . "/pages/header.php";
?>

<main id="main" class="main p-3">
    <section class="section">
        <div class="row">
            <div class="col">
                <h3>ТАНХИМЫН БУС ЦАГИЙН ТАЙЛАН ХЭВЛЭХ</h3>
            </div>
            <div class="col-md-2">
                <select class="form form-control mb-3" name="year">
                    <?php
                    $currenton = $thison;
                    while ($currenton >= $starton) { ?>
                        <option <?php echo $currenton == $thison ? "selected" : "" ?>><?= $currenton ?></option>
                    <?php $currenton--;
                    } ?>
                </select>
            </div>
            <div class="col-md-1">
                <select class="form form-control mb-3" name="month">
                    <?php
                    $sar = 1;
                    while ($sar <= 12) { ?>
                        <option <?php echo $sar == $thismonth ? "selected" : "" ?>><?= $sar ?></option>
                    <?php $sar++;
                    } ?>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-danger">ХАРАХ</button>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">

            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
require ROOT . "/pages/footer.php"; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script>
    function del(id, title, image) {
        var r = confirm(title + " мэдээг устгахдаа итгэлтэй байна уу!")
        if (r) {
            $.ajax({
                url: "ajax",
                type: "POST",
                data: {
                    mode: 5,
                    id: id,
                    image: image
                },
                error: function(xhr, textStatus, errorThrown) {
                    //console.log("Алдаа гарлаа");
                },
                beforeSend: function() {
                    //console.log("Түр хүлээнэ үү");
                },
                success: function(data) {
                    window.location.reload();
                },
                async: true
            });
        }
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>