<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title><?=ucfirst(DOMAIN)?> :: Хувийн санхүү</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body class="auth-body-bg">
    <div class="container-fluid">
        <!-- Log In page -->
        <div class="row">
            <div class="col-lg-3 pr-0">
                <div class="card mb-0 shadow-none">
                    <div class="card-body">

                        <h3 class="text-center m-0">
                            <a href="index.html" class="logo logo-admin"><img src="assets/images/logo-sm.png"
                                    height="60" alt="logo" class="my-3"></a>
                        </h3>

                        <div class="px-2 mt-2">
                            <h4 class="text-muted font-size-18 mb-2 text-center">Яг одоо үнэгүй бүртгүүлээд</h4>
                            <p class="text-muted text-center">Өөрийн санхүүг хялбар хөтлөөрэй</p>

                            <!-- if, while, for, foreach, and switch.
 endif;, endwhile;, endfor;, endforeach; endswitch; -->

                            <?php if (!empty($_SESSION['errors'])): ?>
                            <ul>
                                <?php foreach ($_SESSION['errors'] as $error): ?>
                                <li style="color:red"><?=$error?></li>
                                <?php endforeach;?>
                            </ul>
                            <?php unset($_SESSION['errors']);endif;?>

                            <form class="form-horizontal my-4" action="/sign-up-save" method="POST">
                                <div class="form-group">
                                    <label for="username">Таны нэр</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class="far fa-user"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="Амараа" id="username"
                                            name="username" placeholder="Овог нэрээ бичнэ үү">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="username">Утас</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i
                                                    class=" fas fa-mobile-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="99554477" id="phone" name="phone"
                                            placeholder="Өөрийн утасны дугаараа оруул">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="username">Имэйл хаяг</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon2"><i
                                                    class="far fa-envelope"></i></span>
                                        </div>
                                        <input type="text" class="form-control" value="amaraa@gmail.com" id="email"
                                            name="email" placeholder="Хувийн имэйл хаягаа оруул">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="userpassword">Нууц үг</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon3"><i
                                                    class="fas fa-lock"></i></span>
                                        </div>
                                        <input type="password" class="form-control" value="1234" id="userpassword"
                                            name="userpassword" placeholder="Ашиглах нууц үгээ оруулна уу">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="userpassword">Нууц үгээ баталгаажуулах</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon4"><i
                                                    class="fas fa-key"></i></span>
                                        </div>
                                        <input type="password" class="form-control" value="1234" id="confirmpassword"
                                            name="confirmpassword" placeholder="Нууц үгээ дахин оруулна уу">
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="terms" name="terms">
                                        <label class="custom-control-label" for="terms">
                                            <span class="font-13 text-muted mb-0">Бүртгүүлснээр би <?=DOMAIN?> сайтын
                                                <a href="#">үйлчилгээний нөхцлийг</a> хүлээн зөвшөөрч байна</span>
                                        </label>
                                    </div>
                                </div>





                                <div class="form-group mb-0 row">
                                    <div class="col-12 mt-2">
                                        <button class="btn btn-primary btn-block waves-effect waves-light"
                                            type="submit">Бүртгүүлэх <i class="fas fa-sign-in-alt ml-1"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="m-2 text-center bg-light p-4 text-primary">
                            <h4 class="">Та бүртгэлтэй хэрэглэгч үү? </h4>
                            <p class="font-size-13">Яг одоо <span><?=DOMAIN;?></span> аккаунт руугаа нэвтрэх</p>
                            <a href="#" class="btn btn-primary waves-effect waves-light">Нэвтрэх</a>
                        </div>
                        <div class="mt-4 text-center">
                            <p class="mb-0">© 2021 <?=ucfirst(DOMAIN);?> :: Бүтээсэн <i
                                    class="mdi mdi-heart text-danger"></i>
                                1234.mn</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 p-0 vh-100  d-flex justify-content-center">
                <div class="accountbg d-flex align-items-center">
                    <div class="account-title text-center text-white">
                        <h4 class="mt-3 text-white">Хувийн санхүү <span
                                class="text-warning"><?=strtoupper(DOMAIN)?></span> </h4>
                        <h1 class="text-white">Супер хялбар!</h1>
                        <p class="mt-3 font-size-14">Гэр бүлийнхээ санхүүгийн байдлыг хамгийн хялбараар авч явж, харж
                            дүгнэж, ойлгохыг хүсч байна уу?</p>
                        <div class="border w-25 mx-auto border-warning"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Log In page -->
    </div>



    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>