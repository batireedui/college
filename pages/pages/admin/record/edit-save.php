<?php
$id = get('id', 10);

$ognoo = post('ognoo', 10);
$utga = post('utga', 255);
$togtmol = post('togtmol', 2);
$turul = post('turul', 15);
$hariltsagch = post('hariltsagch', 100);
$mungu_usuh = post('mungu_usuh', 10);
$mungu_buurah = post('mungu_buurah', 10);
$hurungu_usuh = post('hurungu_usuh', 10);
$hurungu_buurah = post('hurungu_buurah', 10);
$baraa_usuh = post('baraa_usuh', 10);
$baraa_buurah = post('baraa_buurah', 10);
$avlaga_usuh = post('avlaga_usuh', 10);
$avlaga_buurah = post('avlaga_buurah', 10);
$ur_usuh = post('ur_usuh', 10);
$ur_buurah = post('ur_buurah', 10);
$orlogo = post('orlogo', 10);
$zardal = post('zardal', 10);

try {
    $success = _exec(
        "update transaction set
            ognoo=?,
            utga=?,
            togtmol=?,
            turul=?,
            hariltsagch=?,
            mungu_usuh=?,
            mungu_buurah=?,
            hurungu_usuh=?,
            hurungu_buurah=?,
            baraa_usuh=?,
            baraa_buurah=?,
            avlaga_usuh=?,
            avlaga_buurah=?,
            ur_usuh=?,
            ur_buurah=?,
            orlogo=?,
            zardal=?,
            update_user_id=?,
            update_time=now()
            where id=?
        ",
        'sssssiiiiiiiiiiiiii',
        [$ognoo, $utga, $togtmol, $turul, $hariltsagch, $mungu_usuh, $mungu_buurah, $hurungu_usuh, $hurungu_buurah, $baraa_usuh, $baraa_buurah, $avlaga_usuh, $avlaga_buurah, $ur_usuh, $ur_buurah, $orlogo, $zardal, $_SESSION['id'], $id],
        $count
    );

    $_SESSION['messages'] = ["\"$utga\" утгатай гүйлгээг амжилттай өөрчиллөө. "];
} catch (Exception $e) {
    $_SESSION['errors'] = ["Системийн алдаа гарлаа. Та дараа дахин оролдоно уу"];
    // echo "Алдаа: " . $e->getMessage() . ' : ' . $e->getFile() . ' : ' . $e->getLine() . ' : Code ' . $e->getCode();
} finally {
    if (isset($e)) {
        logError($e);
    }
}

redirect('/user/home');