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
    <style>
        .blink {
            background-color: #0778db !important;
            min-width: 80% !important;
            font-size: medium !important;
        }
    </style>

    <?php
    if (isset($_GET['t'])) {
        $t = (int)$_GET['t'];
        if ($t == 1) {
            $sql = "SELECT id, name, utga FROM strategy_time WHERE id<5";
        } else $sql = "SELECT id, name, utga FROM strategy_time WHERE id>4";
        _selectNoParam(
            $st,
            $c,
            $sql,
            $id,
            $name,
            $utga
        );
    ?>
</head>

<body>
    <div class="container-md" style="margin-top: 30px;">
        <h5 style="text-align: center; color: #e00b0b">
            <img src="https://surgalt.uvcollege.edu.mn/images/logo.jpg" height="100" loading="lazy"><br><br>
            Санал, дүгнэлт өгөх
        </h5>
        <h5 style="text-align: center; color: #032c94">
            Өвөрхангай аймаг дахь Политехник коллеж 2024.10.03
        </h5>
        <div style="text-align: center;" class="mb-3">
            <a href="https://uvcollege.edu.mn/"><button class="btn btn-danger">НҮҮР ХУУДАС</button></a>
        </div>
        <div style="color: #006e2e; margin: auto; padding: 10px;" class="text-center">
            <?php
            while (_fetch($st)) {
            ?>
                <div class="mb-3">
                    <a class="blink btn text-white" data-mdb-ripple-init style="" href="https://surgalt.uvcollege.edu.mn/hural/time_click?t=<?= $id ?>" role="button">
                        <i class="fas fa-check me-2"></i>
                        <?= $name ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</html>
<?php } else { ?>

    </head>

    <body>
        <div class="container-md" style="margin-top: 30px;">
            <a href="https://uvcollege.edu.mn/">БУРУУ ХҮСЭЛТ БАЙНА! БУЦАХ</a>
        </div>
    </body>

    </html>

<?php }
?>