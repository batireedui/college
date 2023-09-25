<?php
if (isset($_SESSION['user_id'])) {
    $attid = @$_POST['attid'];
    $sedev = @$_POST['sedev'];
    $success = _exec(
        "UPDATE att SET sedev=? WHERE id = ?",
        'si',
        [$sedev, $attid],
        $count
    );
}
