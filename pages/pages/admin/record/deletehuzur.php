<?php

$id = get('id', 10);

try {
    $success = _exec(
        "delete from huzurcag where id=?",
        'i',
        [$id],
        $count
    );

    $_SESSION['messages'] = ["\"$id\" утгатай гүйлгээг амжилттай устгалаа. "];
} catch (Exception $e) {
    $_SESSION['errors'] = ["$id утгатай гүйлгээг устгаж чадсангүй. Та дараа дахин оролдоно уу!"];
} finally {
    if (isset($e)) {
        logError($e);
    }
}

redirect('/admin/huzur/huzur');