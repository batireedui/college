<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

_selectNoParam(
            $stmt,
            $count,
            "SELECT noti.id, title, body, ognoo FROM `noti` INNER JOIN teacher ON noti.userid = teacher.id
                         ORDER BY ognoo DESC",
            $id,
            $title,
            $body,
            $ognoo
        );
?>
<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h3>Мэдэгдлүүд</h3>
    </div>
            <?php if ($count > 0) : ?>
                <?php $too = 0;
                while (_fetch($stmt)) : ?>
                    <div role="button" onclick="showNoti(<?=$id?>)" data-mdb-toggle='modal' data-mdb-target='#detial' style="background-color: #fdfdfd;
                                padding: 10px;
                                border-radius: 10px;
                                border: solid #b3b3b3 1px;
                                margin-top: 10px;">
                        <div style="font-size: 16px; font-weight: bold"><?=$title?></div>
                        <div style="font-size: 14px;"><?=$body?></div>
                        <div style="font-size: 12px;"><?=$ognoo?></div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
    </div>
</div>
<div class="modal fade" id="detial" tabindex="-1" aria-labelledby="detialLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detialLabel">Мэдэгдэл</h5>
                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modal-body">

            </div>
        </div>
    </div>
</div>
<?php
$success = _exec(
            "UPDATE noti_user SET see=? WHERE user_id = '$user_id' and see is null",
            's',
            [ognoo()],
            $count
        );
?>
<?php
require ROOT . "/pages/footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showNoti(id) {
        $.ajax({
                                    url: "ajax",
                                    type: "POST",
                                    data: {
                                        mode: 2,
                                        id: id
                                    },
                                    error: function(xhr, textStatus, errorThrown) {
                                        $("#modal-body").html("Алдаа гарлаа !");
                                    },
                                    beforeSend: function() {
                                        $('#modal-body').html("Түр хүлээнэ үү ...");
                                    },
                                    success: function(data) {
                                         $('#modal-body').html(data);
                                    },
                                    async: true
                                });
    }
</script>
<?php
require ROOT . "/pages/end.php";
?>