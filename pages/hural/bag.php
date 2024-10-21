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
    if (isset($_GET['s'])) {
        $userid = (int)$_GET['s'];
        $zorilt = 0;
        switch ($userid) {
            case 1:
            case 2:
                $zorilt = 1;
                break;
            case 3:
            case 4:
                $zorilt = 2;
                break;
            case 5:
            case 6:
                $zorilt = 3;
                break;
            case 7:
            case 8:
                $zorilt = 4;
                break;
            case 9:
            case 10:
                $zorilt = 5;
                break;
            default:
                $zorilt = 0;
        }

        _selectRowNoParam(
            "SELECT id, name FROM strategy_zorilt WHERE id=$zorilt",
            $zid,
            $zname
        );

        _selectNoParam(
            $st,
            $co,
            "SELECT id, zorilt_id, body, huvi, tailbar FROM strategy_ajil WHERE zorilt_id=$zorilt",
            $ajilid,
            $zorilt_id,
            $body,
            $huvi,
            $tailbar
        );
    ?>
</head>

<body>
    <div class="container-md" style="margin-top: 30px;">
        <h5 style="text-align: center; color: #e00b0b">
            <img src="https://surgalt.uvcollege.edu.mn/images/logo.jpg" height="100" loading="lazy"><br><br>
            "Стратеги төлөвлөгөө 2021-2024"-ийн арга хэмжээнд дүгнэлт өгөх
        </h5>
        <h5 style="text-align: center; color: #032c94">
            Өвөрхангай аймаг дахь Политехник коллеж 2024.10.03
        </h5>
        <div class="m-3 text-center">
            <h3><?= $zname ?></h3>
        </div>
        <div style="text-align: center;" class="mb-3">
            <a href="https://uvcollege.edu.mn/"><button class="btn btn-danger">НҮҮР ХУУДАС</button></a>
        </div>
        <div class='m-5'>
            <table class='table table-bordered table-hover'>
                <tr>
                    <th>№</th>
                    <th>Арга хэмжээ</th>
                    <th>Хувь</th>
                    <th>Тайлбар</th>
                    <th>Санал, дүгнэлт</th>
                </tr>
                <?php
                $k = 1;
                while (_fetch($st)) {
                ?>
                    <tr>
                        <td><?= $k ?></td>
                        <td><?= $body ?></td>
                        <td><?= $huvi ?></td>
                        <td><?= $tailbar ?></td>
                        <td>
                            <?php
                            $sanal = "";
                            _selectRowNoParam(
                                "SELECT sanal FROM strategy_sanal WHERE ajil_id=$ajilid and userid=$userid",
                                $sanal
                            );
                            ?>
                            <div class='editcell' onblur='updateSanal(this, <?= $ajilid ?>, <?= $userid ?>)' contenteditable=''><?= $sanal ?></div>
                        </td>
                    </tr>

                <?php $k++;
                } ?>
            </table>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function updateSanal(element, ajilid, userid) {
        var value = element.innerText;
        console.log(ajilid + value + userid);
        $.ajax({
            url: 'save',
            type: 'post',
            data: {
                updateSanal: "ok",
                ajilid: ajilid,
                userid: userid,
                body: value
            },
            success: function(data) {
                console.log(data);
            }
        })
    }
</script>

</html>
<?php } else { ?>

    </head>

    <body>
        <div class="container-md" style="margin-top: 30px;">
            <h5 style="text-align: center; color: #032c94">
                <img src="https://surgalt.uvcollege.edu.mn/images/logo.jpg" height="100" loading="lazy"><br><br>
                Сургуулийн стратеги төлөвлөгөө - 2021-2024 (Санал дүгнэлт) - 2024.10.03
            </h5>
            <div style="text-align: center;" class="mb-3">
                <a href="https://uvcollege.edu.mn/"><button class="btn btn-danger">НҮҮР ХУУДАС</button></a>
            </div>
            <div class="m-3 text-center d-flex flex-wrap align-items-center justify-content-center">
                <?php
                $i = 1;
                while ($i < 11) { ?>
                    <div class="m-1"><a href="?s=<?= $i ?>"><button class='btn btn-success btn-lg'>БАГ-<?= $i ?></button></a></div>
                <?php $i++;
                }
                ?>
            </div>
        </div>
    </body>

    </html>

<?php }
?>