<?php
if (isset($_SESSION['user_id'])) {
    $mode = $_POST['mode'];

    if ($mode == 1) {
        $title = $_POST['title'];
        $fname = $_POST['fname'];

        $success = _exec(
            "INSERT INTO flashnews (title, image, ognoo, status) VALUES(?, ?, ?, ?)",
            'sssi',
            [$title, $fname, ognoo(), 1],
            $count
        );
        echo "Амжилттай!";
    }

    if ($mode == 2) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $fname = $_POST['fname'];
        $ognoo = $_POST['ognoo'];

        $success = _exec(
            "INSERT INTO news (title,  image,  ognoo,  body,  status,  userid) VALUES(?, ?, ?, ?, ?, ?)",
            'ssssii',
            [$title, $fname, $ognoo, $body, 1, $_SESSION['user_id']],
            $count
        );
        echo "Амжилттай!";
    }

    if ($mode == 3) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $fname = $_POST['fname'];
        $ognoo = $_POST['ognoo'];
        $id = $_POST['id'];

        $success = _exec(
            "UPDATE news SET title=?,  image=?,  ognoo=?,  body=?,  status=?,  userid=? WHERE id=?",
            'ssssiii',
            [$title, $fname, $ognoo, $body, 1, $_SESSION['user_id'], $id],
            $count
        );
        echo "Амжилттай!";
    }
    if ($mode == 4) {
        $title = $_POST['title'];
        $body = $_POST['body'];
        $fname = $_POST['fname'];
        $ognoo = $_POST['ognoo'];
        $id = $_POST['id'];

        $success = _exec(
            "UPDATE news SET title=?,  image=?,  ognoo=?,  body=?,  status=?,  userid=? WHERE id=?",
            'ssssiii',
            [$title, $fname, $ognoo, $body, 1, $_SESSION['user_id'], $id],
            $count
        );
        echo "Амжилттай!";
    }
    if ($mode == 5) {
        $id = $_POST['id'];
        $image = $_POST['image'];
        $success = _exec(
            "DELETE FROM news WHERE id=?",
            'i',
            [$id],
            $count
        );

        unlink("/images/image_news/<?=$image?>.jpg");
        echo "Амжилттай!";
    }
    if ($mode == 6) {
        $id = $_POST['id'];
        $image = $_POST['image'];
        $success = _exec(
            "DELETE FROM flashnews WHERE id=?",
            'i',
            [$id],
            $count
        );

        unlink("/images/app_flash/<?=$image?>.jpg");
        echo "Амжилттай!";
    }
}
