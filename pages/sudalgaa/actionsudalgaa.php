<?php
if (isset($_POST['student_id']) && isset($_SESSION['user_id'])) {
    $posts = $_POST;
    $student_id = $posts["student_id"];
    $user_role = $_SESSION['user_role'];
    $user_id = $_SESSION['user_id'];
    unset($posts["student_id"]);
    //print_r($posts);
    $too = count($posts);
    if ($too > 0) {
        $angi = 10;
        try {
            $success = _exec(
                "DELETE FROM s_sudalgaas WHERE student_id = ? and jil=? and created_at < ?",
                'iss',
                [$student_id, $this_on, ognoo()],
                $count
            );
        } catch (Exception $e) {
            // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
        } finally {
            if (isset($e)) {
                logError($e);
            }
        }
        foreach ($posts as $key => $value) {
            $ch = $value;
            if(is_array($value)) $ch = implode(" ",$value);
            
            if (@strpos($ch, "***") > -1) {
            } else {
                if (strpos($key, "hariult") > -1) {
                    $sh_id = substr($key, 7, strlen($key));
                    $dedval = 0;
                    $shval = $value;
                    if (strpos($sh_id, "-") > -1) {
                        $sh_id = substr($sh_id, 0, strpos($sh_id, "-"));
                        $shval = 1;
                        $dedval = $value;
                    }
                    //echo $sh_id . " " . $shval . " " . $dedval . "<br>";
                    try {
                        $success = _exec(
                            "INSERT INTO s_sudalgaas(student_id, teacher_id, user_type, value, shalguur_id, shalguurded_id, jil, created_at, angi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                            'iisiiissi',
                            [$student_id, $user_id, $user_role, $shval, $sh_id, $dedval, $this_on, ognoo(), $angi],
                            $count
                        );
                        $_SESSION['action'] = "Бүлэг устгагдлаа!";
                    } catch (Exception $e) {
                        $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
                        // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
                    } finally {
                        if (isset($e)) {
                            logError($e);
                        }
                    }
                } else if (strpos($key, "olon") > -1) {
                    $sh_id = substr($key, 4, strlen($key) - 5);
                    foreach ($value as $okey => $ovalue) {
                        //echo $sh_id . " - " . $ovalue . "<br>";
                        try {
                            $success = _exec(
                                "INSERT INTO s_sudalgaas(student_id, teacher_id, user_type, value, shalguur_id, shalguurded_id, jil, created_at, angi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                'iisiiissi',
                                [$student_id, $user_id, $user_role, "1", $sh_id, $ovalue, $this_on, ognoo(), $angi],
                                $count
                            );
                            $_SESSION['action'] = "Бүлэг устгагдлаа!";
                        } catch (Exception $e) {
                            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
                            // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
                        } finally {
                            if (isset($e)) {
                                logError($e);
                            }
                        }
                    }
                } else if (strpos($key, "dedmulti") > -1) {
                    $sh_id = substr($key, 8, strlen($key) - 9);
                    foreach ($value as $okey => $ovalue) {
                        //echo $sh_id . " - " . $ovalue . "<br>";
                        try {
                            $success = _exec(
                                "INSERT INTO s_sudalgaas(student_id, teacher_id, user_type, value, shalguur_id, shalguurded_id, jil, created_at, angi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                                'iisiiissi',
                                [$student_id, $user_id, $user_role, "1", $sh_id, $ovalue, $this_on, ognoo(), $angi],
                                $count
                            );
                            $_SESSION['action'] = "Бүлэг устгагдлаа!";
                        } catch (Exception $e) {
                            $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
                            // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
                        } finally {
                            if (isset($e)) {
                                logError($e);
                            }
                        }
                    }
                }
            }
        }
    }
    redirect("/");
}
