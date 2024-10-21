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
</head>

<body>
    <div class="container-md" style="margin-top: 30px;">
        <h5 style="text-align: center; color: #e00b0b">
            <img src="https://surgalt.uvcollege.edu.mn/images/logo.jpg" height="100" loading="lazy"><br><br>
            Стратеги төлөвлөгөөнд тусгагдах арга хэмжээнд санал хүсэлт авах
        </h5>
        <h5 style="text-align: center; color: #032c94">
            Өвөрхангай аймаг дахь Политехник коллеж 2024.10.03
        </h5>
        <div style="text-align: center;" class="mb-3">
            <a href="https://uvcollege.edu.mn/"><button class="btn btn-danger">НҮҮР ХУУДАС</button></a>
        </div>
        <div class="m-3 text-center">
            <h4>САНАЛ ХҮСЭЛТ ИЛГЭЭХ</h4>
            <form action='save' method='post'>
                <textarea row='3' class='form form-control' name='body' required placeholder="Энд өөрчлөх, стратеги төлөвлөгөөнд тусгах санал хүсэлтээ бичнэ үү"></textarea>
                <br>
                <button type="submit" class='btn btn-success' name='savesanal'>ИЛГЭЭХ</button>
            </form>
        </div>
        <div class='m-5' id="fill">
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function getSanal() {
        $.ajax({
            url: 'sanal_get',
            type: 'post',
            success: function(data) {
                $("#fill").html(data);
            }
        })
    }
    getSanal();

    window.onload = function() {
        setInterval(getSanal, 15000);
    };
</script>

</html>