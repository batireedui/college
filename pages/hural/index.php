<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $pageTitle ?> </title>
    <link rel="icon" type="image/x-icon" href="<?= $favi ?>" />
    <meta name="description" content='Өвөрхангай ПК' />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.css" rel="stylesheet" />
    <meta http-equiv="refresh" content="60" />
</head>

<body>
    <div class="container-md" style="margin-top: 30px;">
        <h5 style="text-align: center; color: #032c94">
            <img src="https://surgalt.uvcollege.edu.mn/images/logo.jpg" height="100" loading="lazy"><br><br>
            ӨВӨРХАНГАЙ АЙМАГ ДАХЬ ПОЛИТЕХНИК КОЛЛЕЖ
        </h5>
        <h5 style="text-align: center; color: #032c94">
           “Чанартай боловсрол-Нээлттэй түншлэл VI” аймгийн зөвлөгөөн (2024.05.22)
        </h5>
        <?php
        _selectNoParam(
            $stmt,
            $count,
            "SELECT huralusers.id, fname, lname FROM `huralusers` INNER JOIN hural ON huralusers.id = hural.teacherid",
            $id,
            $fname,
            $lname
        );
        ?>
        <div style="color: #006e2e; margin: auto; width: 50%; padding: 10px;">
            <marquee direction="up" height="500px">
                <?php while (_fetch($stmt)) : ?>
                    <h3><?= $fname ?> <span style="text-transform: uppercase;"><?= $lname ?></span></h3>
                <?php endwhile; ?>
            </marquee>
        </div>
    </div>
</body>

</html>