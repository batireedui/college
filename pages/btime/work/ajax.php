<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'] ?? 0;
    if ($mode == "get") {
        _selectNoParam(
            $st,
            $co,
            "SELECT btime_ajil.id, btime_ajil.ajil, btime_ajil.tailbar, btime_ajil.credit, btime_ajil.at_id, at.name, btime_ajil.tuluv FROM `btime_ajil` INNER JOIN `at` ON btime_ajil.at_id = at.id ORDER BY id DESC",
            $id,
            $ajil,
            $tailbar,
            $credit,
            $at_id,
            $at_name,
            $tuluv
        ); ?>
        <table class="table table-bordered hover w-100">
            <tr>
                <th>№</th>
                <th>Ажил үйлчилгээ</th>
                <th>Гүйцэтгэлийн шалгуур</th>
                <th>Кредит</th>
                <th>Тооцох</th>
                <th></th>
                <th></th>
                <th></th>
            </tr>
            <?php
            $dd = 1;
            while (_fetch($st)) { ?>
                <tr>
                    <td><?= $dd ?></td>
                    <td id="<?= $id ?>-ajil"><?= $ajil ?></td>
                    <td id="<?= $id ?>-tailbar"><?= $tailbar ?></td>
                    <td id="<?= $id ?>-credit"><?= $credit ?></td>
                    <td id="<?= $id ?>-at_name"><?= $at_name ?></td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" onclick="change(<?= $id ?>, this, 'btime_ajil_tuluv')" <?php echo $tuluv > 0 ? "checked" : "" ?> />
                        </div>
                    </td>
                    <td>
                        <i class="fas fa-pen-to-square fa-lg text-primary" type="button" data-mdb-toggle="modal" data-mdb-target="#changeCag" onclick="editBtn(<?= $id ?>, <?= $at_id ?>)"></i>
                    </td>
                    <td>
                        <i class="fas fa-trash m-1 fa-lg text-danger" type="button" onclick="deleteBtn(<?= $id ?>)"></i>
                    </td>
                </tr>
            <?php $dd++;
            }
            ?>
        </table>
<?php
    } else if ($mode == "addbtime") {
        $success = _exec(
            "INSERT INTO btime_ajil (ajil, tailbar, credit, at_id, user_id, tuluv) VALUES (?, ?, ?, ?, ?, ?)",
            'sssiii',
            [$_POST['ajil'], $_POST['addnotol'], $_POST['addcr'], $_POST['addat'], $_SESSION['user_id'], 1],
            $count
        );

        echo "Ажилттай!";
    } else if ($mode == "editbtime") {
        $success = _exec(
            "UPDATE btime_ajil SET ajil=?, tailbar=?, credit=?, at_id=?, user_id=? WHERE id = ?",
            'sssiii',
            [$_POST['ajil'], $_POST['addnotol'], $_POST['addcr'], $_POST['addat'], $_SESSION['user_id'], $_POST['editid']],
            $count
        );
    } else if ($mode == "btime_ajil_tuluv") {
        $tuluv = $_POST['tuluv'];
        $id = $_POST['id'];
        if ($tuluv == "true") {
            $success = _exec(
                "UPDATE btime_ajil SET tuluv = ? WHERE id = ?",
                'ii',
                ["1", $id],
                $count
            );
        } else {
            $success = _exec(
                "UPDATE btime_ajil SET tuluv = ? WHERE id = ?",
                'ii',
                ["0", $id],
                $count
            );
        }
        echo "Амжилттай!";
    } else if ($mode == "bodBtime") {
        if (is_numeric($_POST['credit'])) {
            $success = _exec(
                "UPDATE btime_user SET credit=?, dun=? WHERE id = ?",
                'sii',
                [$_POST['credit'], (double)$_POST['credit'] * (int)$_POST['money'], $_POST['btimeid']],
                $count
            );
        }
        echo "Амжилттай";
    }
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
