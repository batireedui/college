<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
if ($user_role < 3)
    require ROOT . "/pages/home/teacher.php";
    else
    require ROOT . "/pages/home/surgalt.php";
?>
<?php
require ROOT . "/pages/footer.php"; ?>

<?php
require ROOT . "/pages/end.php";
?>