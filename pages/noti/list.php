<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";

_selectNoParam(
            $stmt,
            $count,
            "SELECT noti_user.id, title, body, ognoo, see FROM `noti` INNER JOIN noti_user ON noti.id = noti_user.noti_id
                            WHERE noti_user.user_id = '$user_id' ORDER BY ognoo DESC",
            $id,
            $title,
            $body,
            $ognoo,
            $see
        );
?>
<div>
    <div class="p-3 bg-light d-flex justify-content-between align-items-center">
        <h3>Мэдэгдлүүд</h3>
    </div>
            <?php if ($count > 0) : ?>
                <?php $too = 0;
                while (_fetch($stmt)) : ?>
                    <div style="background-color: aliceblue;
                                padding: 10px;
                                border-radius: 10px;
                                border: solid #72a0b1 1px;
                                margin-top: 10px;">
                        <div style="font-size: 16px; <?php echo $see == null ? 'color: red' : ''?>"><?=$title?></div>
                        <div style="font-size: 14px;"><?=$body?></div>
                        <div style="font-size: 12px;"><?=$ognoo?></div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
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
<?php
require ROOT . "/pages/end.php";
?>