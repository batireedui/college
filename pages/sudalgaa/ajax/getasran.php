<?php
if (isset($_SESSION['user_id'])) {
    $val = "no";
    if ($_POST["type"] == "getasran") {
        $pid = $_POST["id"];
        _selectRowNoParam(
            "SELECT ovog, ner, bolovsrol, ajil, hbe, sohe, mun, utas, eovog, ener, ebolovsrol, eajil, ehbe, esohe, emun, eutas FROM `asran` WHERE student_id='$pid'",
            $as_ovog,
            $as_ner,
            $as_bol,
            $as_ajil,
            $as_hbe,
            $as_sohe,
            $as_mun,
            $as_utas,
            $as_eovog,
            $as_ener,
            $as_ebol,
            $as_eajil,
            $as_ehbe,
            $as_esohe,
            $as_emun,
            $as_eutas
        );
        $stu = new stdClass;
        $stu->as_ovog = $as_ovog;
        $stu->as_ner = $as_ner;
        $stu->as_bol = $as_bol;
        $stu->as_ajil = $as_ajil;
        $stu->as_hbe = $as_hbe;
        $stu->as_sohe = $as_sohe;
        $stu->as_mun = $as_mun;
        $stu->as_utas = $as_utas;

        $stu->as_eovog = $as_eovog;
        $stu->as_ener = $as_ener;
        $stu->as_ebol = $as_ebol;
        $stu->as_eajil = $as_eajil;
        $stu->as_ehbe = $as_ehbe;
        $stu->as_esohe = $as_esohe;
        $stu->as_emun = $as_emun;
        $stu->as_eutas = $as_eutas;

        $val = json_encode($stu);
        echo $val;
    }
}
