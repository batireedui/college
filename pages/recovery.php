<?php
if(isset($_POST['username'])){
    _selectRowNoParam(
        "SELECT id FROM teacher WHERE email='".$_POST['username']."'",
        $rid
    );
    if(!empty($rid)){
        $pass = rand(1111,9999);

        $success = _exec(
            "UPDATE teacher SET pass = ? WHERE id = ?",
            'ss',
            [$pass, $rid],
            $count
        );
        $to = $_POST['username'];
        $subject = $pageTitle . ' - Нууц үг сэргээлээ';
        $message = 'Сайн байна уу! Нууц үг сэргээлээ. Таны нууц үг: ' . $pass;
        $headers = 'From: password@surgalt.uvcollege.edu.mn' . "\r\n" .
                   'Reply-To: password@surgalt.uvcollege.edu.mn' . "\r\n";
        
        if (mail($to, $subject, $message, $headers)) {
            $_SESSION['errors'] = [$_POST['username']  . ' цахим шууданд нууц үг илгээлээ! Цахим шуудангаа шалгаад нэвтэрч орно уу! SPAM фолдероо шалгаж үзэхээ мартуузай'];
            redirect('/login');
            exit;
        } else {
            $_SESSION['errors'] = ['Имэйл илгээхэд алдаа гарлаа. Дахин оролдоно уу!'];
        }
    }
    else {
        $_SESSION['errors'] = [$_POST['username']  . ' цахим шуудан бүртгэлээс олдсонгүй!'];
    }
}
?>
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
        .btn-outline-primary {
            --mdb-btn-active-bg: #386bc0;
            --mdb-btn-active-color: #fff;
        }

        [class*=btn-outline-] {
            --mdb-btn-border-width: 1px;
        }
    </style>
</head>

<body>
    <section class="w-100 p-4 d-flex justify-content-center pb-4">
        <form style="width: 22rem;" method="POST">
            <div class="w-100 p-4 d-flex justify-content-center">
                <img src="/images/logo.jpg" class="img-fluid rounded-circle" width="150px" />
            </div>

            <div class="form-outline mb-4">
                <input type="email" name="username" class="form-control" required />
                <label class="form-label" for="form2Example1">Бүртгэлтэй цахим шуудангаа оруулна уу!</label>
            </div>
            <?php if (!empty($_SESSION['errors'])) : ?>
                <div class="mb-3">
                    <ul>
                        <?php foreach ($_SESSION['errors'] as $error) : ?>
                            <li style="color:red; font-size: 12px;"><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php unset($_SESSION['errors']);
            endif; ?>
            <!-- Submit button -->
            <button type="submit" class="btn btn-primary btn-block mb-4">ИЛГЭЭХ</button>
        </form>
    </section>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
</body>

</html>