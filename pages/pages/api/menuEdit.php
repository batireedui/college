<?php
header('Content-type: application/json');
if (isset($_POST['id'])) {
    $menuDetial = new stdClass();

    _selectRow(
        "SELECT name, menuid, medeelel, imgurl FROM submenu WHERE id =?",
        "i",
        [post("id", 15)],
        $title,
        $menuid,
        $body,
        $imgurl
    );

    $menuDetial->title = $title;
    $menuDetial->menuid = $menuid;
    $menuDetial->body = $body;
    $menuDetial->imgurl = $imgurl;
    $myJSON = json_encode($menuDetial);

    echo $myJSON;
}
