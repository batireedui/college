<?php
if (isset($_SESSION['user_id'])) {
    if (isset($_POST["addAlba"])) {
        $m = 0;
        if (isset($_POST['emanager'])) {
            $m = $_POST['emanager'];
        }
        $success = _exec(
            "INSERT INTO office (name, manager_id, tuluv ) VALUES (?, ?, ?)",
            'sii',
            [$_POST['office_name'], $m, 1],
            $count
        );
        redirect('/setting/alba');
    } else if (isset($_POST['addAtushaal'])) {
        $success = _exec(
            "INSERT INTO at (name, tuluv ) VALUES (?, ?)",
            'si',
            [$_POST['atname'], 1],
            $count
        );
        redirect('/setting/at');
    } else if (isset($_POST['turul'])) {
        if ($_POST['turul'] == 'cagEdit') {
            $f = $_POST['f'];
            $val = $_POST['val'];
            $id = $_POST['id'];
            $success = _exec(
                "UPDATE att_time SET $f = ? WHERE id = ?",
                'si',
                [$val, $id],
                $count
            );
            echo "Амжилттай";
        }
        if ($_POST['turul'] == 'esehCag') {
            $id = $_POST['id'];
            $success = _exec(
                "UPDATE att_time SET eseh = 1 WHERE id = ?",
                'i',
                [$id],
                $count
            );
            $success = _exec(
                "UPDATE att_time SET eseh = 0 WHERE id <> ?",
                'i',
                [$id],
                $count
            );
            echo "Амжилттай";
        }
    } else if (isset($_POST['addHuvaari'])) {
        $success = _exec(
            "INSERT INTO att_time (c1, c2, c3, c4, eseh ) VALUES (?, ?, ?, ?, ?)",
            'sssss',
            [$_POST['c1'], $_POST['c4'], $_POST['c3'], $_POST['c4'], 0],
            $count
        );
        redirect('/setting/cag');
    } else if (isset($_POST["editAtushaal"])) {
        if ($_POST['at_id'] > 4) {
            $success = _exec(
                "UPDATE at SET name=? WHERE id = ?",
                'si',
                [$_POST['atname'], $_POST['at_id']],
                $count
            );
        }
        redirect('/setting/at');
    } else if (isset($_POST["addCag"])) {
        $success = _exec(
            "INSERT INTO cag (name, inter, tuluv ) VALUES (?, ?, ?)",
            'ssi',
            [$_POST['cname'], $_POST['cinter'], 1],
            $count
        );
        redirect('/setting/lesson_att');
    } else if (isset($_POST["addLocation"])) {
        $success = _exec(
            "INSERT INTO location (lon, lat, zai, tai ) VALUES (?, ?, ?, ?)",
            'ssis',
            [$_POST['lon'], $_POST['lat'], $_POST['zai'], $_POST['tai']],
            $count
        );
        redirect('/setting/cag');
    } else if (isset($_POST["locationEdit"])) {
        $success = _exec(
            "UPDATE location SET lon=?, lat=?, zai=?, tai=? WHERE id=?",
            'ssisi',
            [$_POST['elon'], $_POST['elat'], $_POST['ezai'], $_POST['etai'], $_POST['eid']],
            $count
        );
        redirect('/setting/cag');
    } else if (isset($_POST["editCag"])) {
        $success = _exec(
            "UPDATE cag SET name=?, inter=? WHERE id = ?",
            'ssi',
            [$_POST['cname'], $_POST['cinter'], $_POST['cag_id']],
            $count
        );
        redirect('/setting/lesson_att');
    } else if (isset($_POST["addZereg"])) {
        $success = _exec(
            "INSERT INTO tzereg (name, money, anorm, bnorm, tuluv) VALUES (?, ?, ?, ?, ?)",
            'siddi',
            [$_POST['zname'], $_POST['money'], $_POST['anorm'], $_POST['bnorm'], 1],
            $count
        );
        redirect('/setting/teacher_normal');
    } else if (isset($_POST["editZereg"])) {
        $success = _exec(
            "UPDATE tzereg SET name=?, money=?, anorm=?, bnorm=? WHERE id=?",
            'siddi',
            [$_POST['zname'], $_POST['money'], $_POST['anorm'], $_POST['bnorm'], $_POST['zereg_id']],
            $count
        );
        redirect('/setting/teacher_normal');
    } else if (isset($_POST["editAlba"])) {
        $m = 0;
        if (isset($_POST['emanager'])) {
            $m = $_POST['emanager'];
        }
        $success = _exec(
            "UPDATE office SET name=?, manager_id=? WHERE id = ?",
            'sii',
            [$_POST['eoffice_name'], $m, $_POST['alba_id']],
            $count
        );
        redirect('/setting/alba');
    } else if (isset($_POST["editHeltes"])) {
        $m = 0;
        $o = 0;
        if (isset($_POST['eoffice_id'])) {
            $o = $_POST['eoffice_id'];
        }
        if (isset($_POST['ed_manager'])) {
            $m = $_POST['ed_manager'];
        }
        $success = _exec(
            "UPDATE department SET name=?, manager_id=?, office_id=? WHERE id = ?",
            'siii',
            [$_POST['ed_name'], $m, $o, $_POST['heltes_id']],
            $count
        );
        redirect('/setting/alba');
    } else if (isset($_POST["addHeltes"])) {
        $success = _exec(
            "INSERT INTO department (name, manager_id, tuluv, office_id ) VALUES (?, ?, ?, ?)",
            'siii',
            [$_POST['d_name'], $_POST['d_manager'], 1, $_POST['office_id']],
            $count
        );
        redirect('/setting/alba');
    } else if (isset($_POST["mode"])) {

        if ($_POST["mode"] == "office_tuluv") {
            $tuluv = $_POST['tuluv'];
            $t = 1;
            $tuluv == "true" ? $t = 1 : $t = 0;
            $success = _exec(
                "UPDATE office SET tuluv = ? WHERE id = ?",
                'ii',
                [$t, $_POST['id']],
                $count
            );
            echo "Амжилттай";
        } else if ($_POST["mode"] == "cag_tuluv") {
            $tuluv = $_POST['tuluv'];
            $t = 1;
            $tuluv == "true" ? $t = 1 : $t = 0;
            $success = _exec(
                "UPDATE cag SET tuluv = ? WHERE id = ?",
                'ii',
                [$t, $_POST['id']],
                $count
            );
            echo "Амжилттай";
        } else if ($_POST["mode"] == "department") {
            $tuluv = $_POST['tuluv'];
            $t = 1;
            $tuluv == "true" ? $t = 1 : $t = 0;
            $success = _exec(
                "UPDATE department SET tuluv = ? WHERE id = ?",
                'ii',
                [$t, $_POST['id']],
                $count
            );
            echo "Амжилттай";
        } else if ($_POST["mode"] == "at_tuluv") {
            $tuluv = $_POST['tuluv'];
            $t = 1;
            $tuluv == "true" ? $t = 1 : $t = 0;
            $success = _exec(
                "UPDATE at SET tuluv = ? WHERE id = ?",
                'ii',
                [$t, $_POST['id']],
                $count
            );
            echo "Амжилттай";
        } else if ($_POST["mode"] == "erhchange") {
            $tuluv = $_POST['tuluv'];
            if ($tuluv == "true") {
                $success = _exec(
                    "INSERT INTO at_tax (erh, at_id) VALUES(?, ?)",
                    'ii',
                    [$_POST['erhid'], $_POST['atid']],
                    $count
                );
                echo "Амжилттай";
            } else {
                if ($_POST['atid'] == 4) {
                    echo "Албан хаагчийн эрхийг цуцлах эрхгүй байна";
                } else {
                    $success = _exec(
                        "DELETE FROM at_tax WHERE erh=? and at_id=?",
                        'ii',
                        [$_POST['erhid'], $_POST['atid']],
                        $count
                    );
                    echo "Амжилттай";
                }
            }
        } else if ($_POST["mode"] == "delete_office") {
            _selectRowNoParam(
                "SELECT count(id) FROM teacher WHERE office_id=" . $_POST['id'],
                $too
            );
            if ($too > 0) {
                echo "Тус албанд ажилтан бүртгэлтэй байна";
            } else {
                _selectRowNoParam(
                    "SELECT count(id) FROM department WHERE office_id=" . $_POST['id'],
                    $dtoo
                );
                if ($dtoo > 0) {
                    echo "Тухайн албанд хэлтэс, тэнхим бүртгэлтэй байна";
                } else {
                    $success = _exec(
                        "DELETE FROM office WHERE id = ?",
                        'i',
                        [$_POST['id']],
                        $count
                    );
                    echo "Амжилттай";
                }
            }
        } else if ($_POST["mode"] == "delete_department") {
            _selectRowNoParam(
                "SELECT count(id) FROM teacher WHERE department_id=" . $_POST['id'],
                $too
            );
            if ($too > 0) {
                echo "Тус хэлтэс, тэнхимд ажилтан бүртгэлтэй байна";
            } else {
                $success = _exec(
                    "DELETE FROM department WHERE id = ?",
                    'i',
                    [$_POST['id']],
                    $count
                );
                echo "Амжилттай";
            }
        } else if ($_POST["mode"] == "cag_Delete") {
            _selectRowNoParam(
                "SELECT COUNT(id) FROM `att` WHERE cagid = " . $_POST['id'],
                $too
            );
            if ($too > 0) {
                echo "Тус цаг дээр ирцийн бүртгэл хийгдсэн байна.";
            } else {
                $success = _exec(
                    "DELETE FROM cag WHERE id = ?",
                    'i',
                    [$_POST['id']],
                    $count
                );
                echo "Амжилттай";
            }
        } else if ($_POST["mode"] == "zereg_Delete") {
            _selectRowNoParam(
                "SELECT COUNT(id) FROM `teacher` WHERE zereg = " . $_POST['id'],
                $too
            );
            if ($too > 0) {
                echo "Тухайн зэргийг сонгосон багш бүртгэгдсэн байна.";
            } else {
                $success = _exec(
                    "DELETE FROM tzereg WHERE id = ?",
                    'i',
                    [$_POST['id']],
                    $count
                );
                echo "Амжилттай";
            }
        } else if ($_POST["mode"] == "at_Delete") {
            if ($_POST['at_id'] > 4) {
                _selectRowNoParam(
                    "SELECT COUNT(id) FROM `teacher` WHERE user_role = " . $_POST['id'],
                    $too
                );
                if ($too > 0) {
                    echo "Тухайн албан тушаалд бүртгэл хийгдсэн байна.";
                } else {
                    $success = _exec(
                        "DELETE FROM at WHERE id = ?",
                        'i',
                        [$_POST['id']],
                        $count
                    );
                    echo "Амжилттай";
                }
            } else echo "Хандах эрхгүй";
        } else if ($_POST["mode"] == "jilUpdate") {
            $success = _exec(
                "UPDATE jil SET this_on=?",
                's',
                [$_POST['jil']],
                $count
            );
            echo "Амжилттай";
        } else if ($_POST["mode"] == "location_Delete") {
            $success = _exec(
                "DELETE FROM location WHERE id=?",
                'i',
                [$_POST['id']],
                $count
            );
            echo "Амжилттай";
        }
    }
} else "Холболт салсан байна. Дахин нэвтэрч орно уу!";
