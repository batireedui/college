<?php
if (isset($_SESSION['user_id'])) {
    if (isset($_POST['teacherAdd_btime'])) {
        $success = _exec(
            "INSERT INTO btime_user (user_id, tailbar, year, month, credit, ajil_id, dun) VALUES (?, ?, ?, ?, ?, ?, ?)",
            'isiisii',
            [$_SESSION['user_id'], $_POST['tailbar'], $thison, $thismonth, 0, $_POST['id'], 0],
            $count
        );
        redirect('current');
    } else if (isset($_GET['deleteid'])) {
        $success = _exec(
            "DELETE FROM btime_user WHERE id=? and user_id=? and credit='0'",
            'ii',
            [$_GET['deleteid'], $_SESSION['user_id']],
            $count
        );
        redirect('current');
    } else if (isset($_POST['teacherEdit_btime'])) {
        $success = _exec(
            "UPDATE btime_user SET tailbar=? WHERE id=? and user_id=?",
            'sii',
            [$_POST['tailbar'], $_POST['id'], $_SESSION['user_id']],
            $count
        );
        redirect('current');
    }
?>
<?php
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
