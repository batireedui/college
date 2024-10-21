<?php
require ROOT . "/pages/start.php";
require ROOT . "/pages/header.php";
if ($user_role == 1)
    require ROOT . "/pages/home/teacher.php";
if (checkErh(7, $user_role, $user_id)) 
    require ROOT . "/pages/home/surgalt.php";
else if (checkErh(9, $user_role, $user_id) || checkErh(10, $user_role, $user_id)) 
    require ROOT . "/pages/home/surgalt.php";
else require ROOT . "/pages/home/ajiltan.php";
?>
<?php
require ROOT . "/pages/footer.php";

if ($user_role > 1 && $user_role < 5) { ?>
<script>
    get_student();
</script>
<?php
}
require ROOT . "/pages/end.php";
?>