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
        .editcell {
            background-color: #dddddd;
            padding: 5px 10px 5px 10px;
            border-radius: 5px;
        }

        .table>:not(caption)>*>* {
            padding: 0.3rem 0.8rem;
        }
    </style>
    <?php
    if (isset($_GET['t'])) {
        $t = (int)$_GET['t'];

        _selectRowNoParam(
            "SELECT id, name, utga FROM strategy_time WHERE id=$t",
            $id,
            $name,
            $utga
        );
    ?>
</head>

<body>
    <div class="container-md" style="margin-top: 20px;">
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
        <div style="border: 3px solid #032c94;border-radius: 10px;padding: 10px;text-align: center;font-size: 24px;">
            <div style="font-weight: bold">
                <?= $name ?>
            </div>
            <div style="font-size: 20px;">
                <?= $utga ?>
            </div>
        </div>
        <div id="too" style="text-align: center;font-size: 18px;font-weight: bold;color: #1c1166; margin: 10px">
            <button onclick="clickSanal(1)" class="btn btn-primary btn-lg">ТИЙМ</button>
            <button onclick="clickSanal(2)" class="btn btn-success btn-lg">ҮГҮЙ</button>
        </div>
        <div>
            <h5>Ирсэн саналууд</h5>
            <?php
            _selectNoParam(
                $st,
                $co,
                "SELECT sanal FROM `strategy_time_sanal` WHERE time_id =$t",
                $sanal
            );
            while (_fetch($st)) {
                echo "<div> - $sanal</div>";
            }
            ?>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    let x;
    var now = 60;

    function clickSanal(sanal) {
        $.ajax({
            url: 'too',
            type: 'post',
            data: {
                sanalClickid: <?= $_GET['t'] ?>,
                sanal: sanal
            },
            success: function(data) {
                document.getElementById("too").innerHTML = data;
            }
        })
    }

    function ugui(sanalid) {
        let sanal = document.getElementById("ugui").value;
        if (sanal == "") {
            alert('Та мэдээлэл бичиж илгээнэ үү');
        } else {
            $.ajax({
                url: 'too',
                type: 'post',
                data: {
                    uguiid: sanalid,
                    sanal: sanal
                },
                success: function(data) {
                    document.getElementById("too").innerHTML = data;
                }
            })
        }
    }
</script>

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