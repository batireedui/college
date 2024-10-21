<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];
    if ($mode == 1) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $users = $_POST['users'];
        $success = _exec(
            "INSERT INTO noti (title, body, ognoo, userid) VALUES(?, ?, ?, ?)",
            'sssi',
            [$title, $body, ognoo(), $_SESSION['user_id']],
            $lastid
        );
        foreach($users as $user){
            $success = _exec(
            "INSERT INTO noti_user (noti_id, user_id) VALUES(?, ?)",
            'ii',
            [$lastid, $user],
            $ok
        );
        echo "Амжилттай";
        }
    }
    if ($mode == 2) {
        _selectNoParam(
                $st, 
                $ct,
                "SELECT teacher.fname, teacher.lname, see FROM `noti_user` INNER JOIN teacher ON noti_user.user_id = teacher.id WHERE noti_id=" . $_POST['id'],
                $fname, $lname, $see
        ); ?>
        <table class="table table-bordered">
            <tr>
                <th></th>
                <th>Овог</th>
                <th>Нэр</th>
                <th>Харсан</th>
            </tr>
            <?php
            $k = 1;
            $s = 0;
            while(_fetch($st)){
            if($see != null) $s++;
            ?> 
            <tr>
                <td><?=$k?></td>
                <td><?=$fname?></td>
                <td><?=$lname?></td>
                <td><?=$see?></td>
            </tr>
            <?php $k++; } ?>
        </table>
<?php echo "Нийт зарлал уншсан: $s";
  }
}