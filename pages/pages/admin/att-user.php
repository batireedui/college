<?php
if (isset($_POST["mode"]) && isset($_SESSION['userid'])) {
    if ($_POST["mode"] == "get") {
        $userid = $_POST["userid"];
        _selectNoParam(
            $st,
            $co,
            "SELECT att.id, userid, hezee, att_turul.name, hen, whezee, att_turul.id FROM att INNER JOIN att_turul ON att.att_turul = att_turul.id WHERE userid = $userid ORDER BY hezee DESC",
            $id,
            $userid,
            $hezee,
            $name,
            $hen,
            $whezee,
            $att_turul
        ); ?>
        <?php
        if ($co > 0) { ?>
            <table class="table table-bordered">
                <thead>
                    <tr style="background-color: #ddd;font-weight: 800;text-align: center;">
                        <td>#</td>
                        <td>ИРЦИЙН ТӨРӨЛ</td>
                        <td>ХЭЗЭЭ</td>
                        <td>БҮРТГЭСЭН</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $d = 1;
                    while (_fetch($st)) { ?>
                        <tr>
                            <td><?= $d ?></td>
                            <td><?= $name ?></td>
                            <td><?= date_format(date_create($hezee), "Y.m.d") ?></td>
                            <td><?= $whezee ?></td>
                            <td>
                                <div class="btn btn-danger btn-sm" onclick="deleteAtt(<?= $id ?>)">УСТГАХ</div>
                            </td>
                        </tr>

                    <?php $d++;
                    }
                    ?>
                </tbody>
            </table>
    <?php
        } else
            echo "БҮРТГЭЛ ХИЙГДЭЭГҮЙ БАЙНА.";
    } else if ($_POST["mode"] == "add") {
        $userid = $_POST["userid"];
        $hezee = $_POST["hezee"];
        $turul = $_POST["turul"];
        $henturul = $_POST["henturul"];

        $success = _exec(
            "insert into att(userid, hezee, att_turul, hen, henturul, whezee) VALUES(?, ?, ?, ?, ?, ?)",
            'isiiss',
            [$userid, $hezee, $turul, $_SESSION['userid'], $henturul, ognoo()],
            $count
        );
        echo "Амжилттай";
    } else if ($_POST["mode"] == "delete") {
        $id = $_POST["id"];

        $success = _exec(
            "delete from att where id = ?",
            'i',
            [$id],
            $count
        );
        echo "Амжилттай";
    } else if ($_POST["mode"] == "addDh") {
        $userid = $_POST["userid"];
        $success = _exec(
            "insert into demjigch(userid, onoo, hezee) VALUES(?, ?, ?)",
            'iis',
            [$userid, 0, ognoo()],
            $count
        );
        echo "Амжилттай";
    } else if ($_POST["mode"] == "addDh-huselt") {
        $userid = $_POST["userid"];
        $did = $_POST["did"];
        $success = _exec(
            "insert into demjigch(userid, onoo, hezee) VALUES(?, ?, ?)",
            'iis',
            [$userid, 0, ognoo()],
            $count
        );
        $success = _exec(
            "DELETE FROM demchigch_h WHERE id=?",
            'i',
            [$did],
            $count
        );
        echo "Амжилттай";
    }
    else if ($_POST["mode"] == "delete-huselt") {
        $did = $_POST["did"];
        $success = _exec(
            "DELETE FROM demchigch_h WHERE id=?",
            'i',
            [$did],
            $count
        );
        echo "Амжилттай";
    } 
    else if ($_POST["mode"] == "removeHolboo") {
        $userid = $_POST["userid"];
        $success = _exec(
            "DELETE FROM demjigch WHERE userid=?",
            'i',
            [$userid],
            $count
        );
        echo "Амжилттай";
    }
    else echo "Буруу хүсэлт!";
} else echo "Нэвтэрч орно уу!";
?>