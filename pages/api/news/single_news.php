<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <style>
            .alert {
                padding: 0.1rem 0.3rem;}
        </style>
    </head>
    <body>
        <?php
        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);
        $id = @$_GET["id"];
        if (!empty($id)) {
        _selectRowNoParam(
            "SELECT id, title, body, image FROM news WHERE id = $id",
            $id, $title, $body, $image
        );
        ?>
            <div class="container-fluid">
                <h5 style="text-align: center">
                    <?=$title?>
                </h5>
                <div style="text-align: center">
                    <img class="img-fluid" src="<?php echo "$cdn/images/image_news/$image.jpg"?>"/>
                </div>
                <div>
                    <?=$body?>
                </div>
            </div>
        <?php
        
        }
        ?>
    </body>
</html>