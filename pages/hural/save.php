<?php
if (isset($_POST['savesanal'])) {
    $success = _exec(
        "INSERT INTO sanal (title, body, userid) VALUES(?, ?, ?)",
        'ssi',
        ["Стратеги төлөвлөгөө санал", $_POST['body'], 0],
        $count
    );
    redirect('sanal');
} else if (isset($_POST['updateSanal'])) {

    $ajilid = $_POST['ajilid'];
    $userid = $_POST['userid'];

    _selectRowNoParam(
        "SELECT count(id) FROM strategy_sanal WHERE ajil_id=$ajilid and userid=$userid",
        $too
    );
    if ($too > 0) {
        $success = _exec(
            "UPDATE strategy_sanal SET sanal=? WHERE ajil_id=? and userid=?",
            'sii',
            [$_POST['body'], $ajilid, $userid],
            $count
        );
    } else {
        $success = _exec(
            "INSERT INTO strategy_sanal (ajil_id, sanal, userid) VALUES(?, ?, ?)",
            'isi',
            [$ajilid, $_POST['body'], $userid],
            $count
        );
    }
    echo "Амжилттай";
}
