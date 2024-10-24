<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $pageTitle ?> </title>
    <link rel="icon" type="image/x-icon" href="<?= $favi ?>" />
    <meta name="description" content='<?= $pageTitle ?>' />

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
        <form style="width: 22rem;" method="POST" action="/sign-in">
            <div class="w-100 p-4 d-flex justify-content-center">
                <img src="/images/logo.jpg" class="img-fluid rounded" width="150px" />
            </div>
            <div class="btn-group w-100 mb-4 justify-content-center " role="group">
                <input type="radio" class="btn-check" id="btn_student" autocomplete="off" name="user_role" value="1" checked="">
                <label class="btn btn-outline-primary d-flex align-items-center justify-content-center" for="btn_student">
                    Багш
                </label>
                <input type="radio" class="btn-check" id="btn_ajiltan" autocomplete="off" name="user_role" value="2">
                <label class="btn btn-outline-primary d-flex align-items-center justify-content-center" for="btn_ajiltan">
                    Ажилтан
                </label>
            </div>
            <!-- Email input -->
            <div class="form-outline mb-4">
                <input type="text" name="username" class="form-control" required />
                <label class="form-label" for="form2Example1">Нэвтрэх нэр</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-2">
                <input type="password" name="password" class="form-control" required />
                <label class="form-label" for="form2Example2">Нууц үг</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-2">
                <div class="col text-end">
                    <!-- Simple link -->
                    <a href="/recovery" style="font-size: 12px;">Нууц үгээ мартсан уу?</a>
                </div>
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
            <button type="submit" class="btn btn-primary btn-block mb-4">Нэвтрэх</button>
        </form>
    </section>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
</body>

</html>