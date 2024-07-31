<style>
    .badgem {
        margin-left: 10px !important;
        background-color: #fff;
        padding: 3px 10px 1px 10px;
        border-radius: 10px;
        color: #000;
        font-size: 10px;
    }

    .fix {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        background-color: #fffde2 !important;
    }

    #gal-listing {
        margin-top: 15px;
        padding-right: 30px;
        border-collapse: separate;
        font-size: 14px;
    }

    #gal-listing td,
    #gal-listing th {
        border: 1px solid #ddd;
        padding: 5px;
        white-space: nowrap;
    }

    #gal-listing th {
        background-color: #c4c4c4;
        text-align: center;
    }

    .table-responsive {
        overflow-y: auto;
    }

    .table td {
        padding: 5px 3px;
    }

    .dt-buttons {
        text-align: end;
        margin-bottom: 15px
    }
</style>

</head>
<?php

$columnNumber = 3;
_select(
    $stmtOrders,
    $countOrders,
    'SELECT payid, orders.id, display_name, wp_users.user_phone, orders.ognoo, orders.total, shipping, tulsun, batal FROM `orders` INNER JOIN wp_users ON orders.userid = wp_users.ID WHERE tuluv = ? ORDER BY id DESC',
    "i",
    ['1'],
    $payid,
    $oidOrders,
    $onameOrders,
    $ophoneOrders,
    $oognooOrders,
    $ototalOrders,
    $shippingOrders,
    $tulsunOrders,
    $batalOrders
);
_select(
    $stmtNopay,
    $countNopay,
    'SELECT payid, orders.id, display_name, wp_users.user_phone, orders.ognoo, orders.total, shipping, tulsun FROM `orders` INNER JOIN wp_users ON orders.userid = wp_users.ID WHERE tuluv = ?',
    "i",
    ['0'],
    $payidNopay,
    $oidNopay,
    $onameNopay,
    $ophoneNopay,
    $oognooNopay,
    $ototalNopay,
    $shippingNopay,
    $tulsunNopay
);
_selectRowNoParam(
    "SELECT count(itemhuuhed.id) FROM `itemhuuhed` INNER JOIN orders ON itemhuuhed.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooHuuhed
);
_selectRowNoParam(
    "SELECT count(itemzamd.id) FROM `itemzamd` INNER JOIN orders ON itemzamd.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooZamd
);
_selectRowNoParam(
    "SELECT count(itemdevter.id) FROM `itemdevter` INNER JOIN orders ON itemdevter.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooDevter
);
_selectRowNoParam(
    "SELECT count(itemmanal.id) FROM `itemmanal` INNER JOIN orders ON itemmanal.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooManal
);
_selectRowNoParam(
    "SELECT count(itemazjargal.id) FROM `itemazjargal` INNER JOIN orders ON itemazjargal.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooAz
);
_selectRowNoParam(
    "SELECT count(itemdeedes.id) FROM `itemdeedes` INNER JOIN orders ON itemdeedes.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooDeedes
);
_selectRowNoParam(
    "SELECT count(itemtenger.id) FROM `itemtenger` INNER JOIN orders ON itemtenger.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooSuvarga
);
_selectRowNoParam(
    "SELECT count(itemhushh.id) FROM `itemhushh` INNER JOIN orders ON itemhushh.orderid = orders.id WHERE tuluv = '1' and tuluvs = '0'",
    $tooHushuu
);
_selectRowNoParam(
    "SELECT count(itemtuluulun.id) FROM `itemtuluulun` INNER JOIN orders ON itemtuluulun.orderid = orders.id WHERE orders.tuluv = '1' and itemtuluulun.tuluv !='1'",
    $tooTuluulun
);
_selectRowNoParam(
    "SELECT count(zproducts.id) FROM `orders` INNER JOIN zproducts ON orders.id = zproducts.orderid INNER JOIN products ON zproducts.productid = products.id WHERE products.cateid = '1' and orders.tuluv = '1'",
    $tooAriun
);
_selectRowNoParam(
    "SELECT count(id) FROM `demchigch_h`",
    $tooDemjigch
);

?>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="/"><img src="/images/logo.png" class="mr-2" alt="logo"></a>
                <a class="navbar-brand brand-logo-mini" href="/"><img src="/images/logo-mini.png" alt="logo" /></a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <?php echo $_SESSION['adminname']; ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="/admin/settings">
                                <i class="ti-settings text-primary"></i>
                                Тохиргоо
                            </a>
                            <a class="dropdown-item" href="/sign-out">
                                <i class="ti-power-off text-primary"></i>
                                Гарах
                            </a>
                        </div>
                    </li>
                    <li class="nav-item nav-settings d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            <i class="icon-bell mx-0"></i>
                        </a>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title">Эхлэл</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                            <i class="icon-layout menu-icon"></i>
                            <span class="menu-title">Бүтээгдэхүүн</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="ui-basic">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/admin/product">Бүртгэл</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/category">Ангилал</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/gal-avral">Аврал/Хүсэлт/Дэд суварга</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false" aria-controls="form-elements">
                            <i class="icon-columns menu-icon"></i>
                            <span class="menu-title">Захиалга</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="form-elements">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/nopay">Төлбөр хийгдээгүй<span class="badgem"><?= $countNopay ?></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/orders">Төлбөр хийгдсэн<span class="badgem"><?= $countOrders ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-ariun">Ариун хуудас<span class="badgem"><?= $tooAriun ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-gal">Галын тахилгат ёслол</a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-huuhed">Хүүхэд авралын бунхан<span class="badgem"><?= $tooHuuhed ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-zamd">Замд орох ёслол<span class="badgem"><?= $tooZamd ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-devter">Хүслийн дэвтэр<span class="badgem"><?= $tooDevter ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-manal">Манал бурхан<span class="badgem"><?= $tooManal ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-azjargal">Аз жаргалын бурхан<span class="badgem"><?= $tooAz ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-deedes">Өвөг дээдсийн ёслол<span class="badgem"><?= $tooDeedes ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-suvarga">Тэнгэрийн суварга<span class="badgem"><?= $tooSuvarga ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-tuluulun">Төлөөлөн<span class="badgem"><?= $tooTuluulun ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/zahialga/order-hushuu">ӨД-н гэрэлт хөшөө<span class="badgem"><?= $tooHushuu ?></span></a></li>
                                <li class="nav-item"><a class="nav-link" href="/admin/archive/archive">Архив</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                            <i class="icon-bar-graph menu-icon"></i>
                            <span class="menu-title">Хэрэглэгчид</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="charts">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/admin/users">Бүртгэл</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/att">Ирц бүртгэх</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/attshow">Ирц бүртгэлүүд</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/demjigch">Дэмжигчдийн холбоо</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/demjigch-h">ДХ элсэх хүсэлт (<?=$tooDemjigch?>)</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                            <i class="icon-grid-2 menu-icon"></i>
                            <span class="menu-title">Үйлдлийн түүх</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="tables">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"><a class="nav-link" href="/admin/reports/history-huzur">Хөзрийн багш</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                            <i class="icon-contract menu-icon"></i>
                            <span class="menu-title">Өвөг дээдсийн хөзөр</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="collapse" id="icons">
                            <ul class="nav flex-column sub-menu">
                                <li class="nav-item"> <a class="nav-link" href="/admin/huzur/order-huzur">Авсан цагууд</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/huzur/huzur">Цаг оруулах</a></li>
                                <li class="nav-item"> <a class="nav-link" href="/admin/huzur/teacher">Багш нар/Хөзрийн төрөл</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/menu/">
                            <i class="icon-head menu-icon"></i>
                            <span class="menu-title">Цэс</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/noti/noti">
                            <i class="icon-bell menu-icon"></i>
                            <span class="menu-title">Зар илгээх</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/settings">
                            <i class="ti-settings  menu-icon"></i>
                            <span class="menu-title">Тохиргоо</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" target="_blank" href="https://www.youtube.com/playlist?list=PLmsdsy0TbTSGa_pqkBKm_81ItyIY9sezn">
                            <i class="mdi mdi-comment-question-outline menu-icon"></i>
                            <span class="menu-title">Заавар</span>
                        </a>
                    </li>
                </ul>
            </nav>