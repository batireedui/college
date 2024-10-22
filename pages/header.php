</head>
<?php $columnNumber = 3;

$ntoo = 0;
_selectRowNoParam(
  "SELECT count(id) FROM noti_user 
            WHERE noti_user.user_id = '$user_id' and see is null",
  $ntoo
);
?>

<body>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <a class="navbar-brand mt-2 mt-lg-0" href="/">
            <img src="/images/logo.jpg" height="35" loading="lazy" />
          </a>
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/"><i class="fa fa-home m-1" aria-hidden="true"></i>ЭХЛЭЛ</a>
            </li>
            <?php
            if (checkErh(13, $user_role, $user_id)) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/student") > -1 ? 'active' : ''; ?>" href="#" id="recordm" role="button" data-mdb-toggle="dropdown" aria-expanded="false"><i class="fa fa-address-book m-1" aria-hidden="true"></i>БҮРТГЭЛ</a>
                <ul class="dropdown-menu" aria-labelledby="recordm">
                  <li>
                    <a class="dropdown-item <?php echo strpos($page, "/student/list") > -1 ? 'active' : ''; ?>" href="/student/list">СУРАЛЦАГЧИД</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/class/list") > -1 ? 'active' : ''; ?>" href="/class/list">АНГИ</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/teacher") > -1 ? 'active' : ''; ?>" href="/teacher/list">БАГШ, АЖИЛТАН</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/student/graduate") > -1 ? 'active' : ''; ?>" href="/student/graduate">ТӨГСӨГЧ</a>
                  </li>
                </ul>
              </li>

            <?php
            }
            if ($user_role == 1) {
            ?>
              <li class="nav-item">
                <a class="nav-link <?php echo strpos($page, "/att/list") > -1 ? 'active' : ''; ?>" href="/att/list"><i class="fa fa-calendar-check m-1" aria-hidden="true"></i>ИРЦ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo strpos($page, "/tclass") > -1 ? 'active' : ''; ?>" href="/tclass/list"><i class="fa fa-pencil-square m-1" aria-hidden="true"></i>АНГИ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo strpos($page, "/lesson") > -1 ? 'active' : ''; ?>" href="/lesson/list"><i class="fa fa-file-text m-1" aria-hidden="true"></i>ХИЧЭЭЛ</a>
              </li>
            <?php }
            if (checkErh(12, $user_role, $user_id)) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/btime/teacher") > -1 ? 'active' : ''; ?>" href="#" id="mcl" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-business-time m-1"></i>
                  "Б" ЦАГ
                </a>
                <ul class="dropdown-menu" aria-labelledby="mcl">
                  <li>
                    <a class="dropdown-item" href="/btime/teacher/current">Тайлан бичих</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/btime/teacher/list">Тайлагийн түүх</a>
                  </li>
                </ul>
              </li>
            <?php }
            if (checkErh(11, $user_role, $user_id)) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/btime/work") > -1 ? 'active' : ''; ?>" href="#" id="mcl" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-business-time m-1"></i>
                  "Б" ЦАГ ТООЦОХ
                </a>
                <ul class="dropdown-menu" aria-labelledby="mcl">
                  <li>
                    <a class="dropdown-item" href="/btime/work/bodoh">"Б" цаг тооцох</a>
                  </li>
                  <?php if ($user_role > 1 && $user_role < 5 || checkErh(0, $user_role, $user_id)) { ?>
                    <li>
                      <a class="dropdown-item" href="/btime/work/add">Ажил үйлчилгээ</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="/btime/work/btime_report">Нэгтгэл хэвлэх</a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
            <?php
            _selectRowNoParam(
              "SELECT COUNT(id) FROM `class` WHERE teacherid = '$user_id' and tuluv = 1",
              $myClass
            );
            if ($myClass > 0) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/student") > -1 ? 'active' : ''; ?>" href="#" id="mcl" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-user m-1" aria-hidden="true"></i>
                  МАНАЙ АНГИ
                </a>
                <ul class="dropdown-menu" aria-labelledby="mcl">
                  <li>
                    <a class="dropdown-item" href="/student/list">Суралцагчдын бүртгэл</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/student/j-detial">Ирц бүртгэл</a>
                  </li>
                </ul>
              </li>

            <?php }
            if ($user_role == 1) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/report") > -1 ? 'active' : ''; ?>" href="#" id="remenu" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-file m-1" aria-hidden="true"></i>
                  ТАЙЛАН
                </a>
                <ul class="dropdown-menu" aria-labelledby="remenu">
                  <?php if ($myClass > 0) { ?>
                    <li>
                      <a class="dropdown-item" href="/report/att">АНГИЙН ИРЦ</a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="/report/tetgeleg">ТЭТГЭЛЭГ</a>
                    </li>
                  <?php  } ?>
                  <li>
                    <a class="dropdown-item" href="/report/cag">ЦАГИЙН ТООЦОО</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/report/list">ИРЦ БҮРТГЭЛ</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/report/jurnal">ЖУРНАЛ</a>
                  </li>
                </ul>
              </li>
            <?php }
            if (checkErh(9, $user_role, $user_id)) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/report") > -1 ? 'active' : ''; ?>" href="#" id="rem" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-file m-1" aria-hidden="true"></i>
                  ИРЦИЙН ТАЙЛАН
                </a>
                <ul class="dropdown-menu" aria-labelledby="rem">
                  <li>
                    <a class="dropdown-item" href="/report/att">АНГИЙН ИРЦ ХУВЬ</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/report/list">БАГШИЙН ИРЦ БҮРТГЭЛ</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/report/class">АНГИЙН ИРЦ БҮРТГЭЛ</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/report/jurnal">ЖУРНАЛ</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/report/tetgeleg">ТЭТГЭЛЭГ</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/report/class-percent">АНГИЙН ИРЦ ГҮЙЦЭТГЭЛ</a>
                  </li>
                </ul>
              </li>
            <?php
            }
            if (checkErh(1, $user_role, $user_id) == true || checkErh(2, $user_role, $user_id)) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/att_users") > -1 ? 'active' : ''; ?>" href="#" id="clock" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-clock m-1" aria-hidden="true"></i>
                  ЦАГ БҮРТГЭЛ
                </a>
                <ul class="dropdown-menu" aria-labelledby="clock">
                  <?php if (checkErh(1, $user_role, $user_id)) { ?>
                    <li>
                      <a class="dropdown-item" href="/att_users/attre">ТАЙЛАН ГАРГАХ</a>
                    </li>
                  <?php }
                  if (checkErh(2, $user_role, $user_id)) { ?>
                    <li>
                      <a class="dropdown-item" href="/att_users/add">ЦАГ БҮРТГЭХ</a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php }
            if (checkErh(3, $user_role, $user_id)) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/noti") > -1 ? 'active' : ''; ?>" href="#" id="zarm" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-comment m-1" aria-hidden="true"></i>
                  ЗАР
                </a>
                <ul class="dropdown-menu" aria-labelledby="zarm">
                  <li>
                    <a class="dropdown-item" href="/noti/send">ИЛГЭЭСЭН ЗАР</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/noti/new">ЗАР ИЛГЭЭХ</a>
                  </li>
                </ul>
              </li>
            <?php }
            if (checkErh(4, $user_role, $user_id)) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/setting") > -1 ? 'active' : ''; ?>" href="#" id="scl" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-cog m-1" aria-hidden="true"></i>ТОХИРГОО
                </a>
                <ul class="dropdown-menu" aria-labelledby="scl">
                  <li>
                    <a class="dropdown-item <?php echo strpos($page, "/setting/alba") > -1 ? 'active' : ''; ?>" href="/setting/alba">АЛБА ХЭЛТЭС</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/setting/teacher_normal") > -1 ? 'active' : ''; ?>" href="/setting/teacher_normal">БАГШИЙН ЗЭРЭГ, НОРМ</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/setting/lesson_att") > -1 ? 'active' : ''; ?>" href="/setting/lesson_att">ХИЧЭЭЛИЙН ЦАГ</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/setting/jil") > -1 ? 'active' : ''; ?>" href="/setting/jil">ХИЧЭЭЛИЙН ЖИЛ</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/setting/at") > -1 ? 'active' : ''; ?>" href="/setting/at">АЛБАН ТУШААЛ</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/setting/erh") > -1 ? 'active' : ''; ?>" href="/setting/erh">ХАНДАХ ЭРХ</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/setting/cag") > -1 ? 'active' : ''; ?>" href="/setting/cag">ЦАГ БҮРТГЭЛ</a>
                  </li>
                </ul>
              </li>
            <?php }
            if (checkErh(5, $user_role, $user_id)) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/news") > -1 ? 'active' : ''; ?>" href="#" id="sclnews" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-pencil m-1" aria-hidden="true"></i>МЭДЭЭ
                </a>
                <ul class="dropdown-menu" aria-labelledby="sclnews">
                  <li>
                    <a class="dropdown-item <?php echo strpos($page, "/news/list") > -1 ? 'active' : ''; ?>" href="/news/list">Мэдээнүүд</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/news/add") > -1 ? 'active' : ''; ?>" href="/news/add">Мэдээ нэмэх</a>
                  </li>
                </ul>
              </li>
            <?php } ?>
            <?php
            if (checkErh(8, $user_role, $user_id)) { ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/sudalgaa") > -1 ? 'active' : ''; ?>" href="#" id="sclnews" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-chart-pie m-1"></i>СУДАЛГАА
                </a>
                <ul class="dropdown-menu" aria-labelledby="sclnews">
                  <li>
                    <a class="dropdown-item <?php echo strpos($page, "/sudalgaa/shalguurlist") > -1 ? 'active' : ''; ?>" href="/sudalgaa/shalguurlist">Шалгуур үзүүлэлт</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/sudalgaa/statistics/stschool-detial") > -1 ? 'active' : ''; ?>" href="/sudalgaa/statistics/stschool-detial">Ангиуд</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/sudalgaa/statistics/stcompare") > -1 ? 'active' : ''; ?>" href="/sudalgaa/statistics/stcompare">Харьцуулалт</a>
                  </li>
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/sudalgaa/statistics/stnegtgel") > -1 ? 'active' : ''; ?>" href="/sudalgaa/statistics/stnegtgel">Нэгтгэл</a>
                  </li>
                  <!--
                  <li class="nav-item">
                    <a class="dropdown-item <?php echo strpos($page, "/sudalgaa/statistics/ersdel") > -1 ? 'active' : ''; ?>" href="/sudalgaa/statistics/ersdel">Эрсдлийн түвшин</a>
                  </li>
                  -->
                </ul>
              </li>
            <?php } ?>
          </ul>
        </div>

        <div class="d-flex align-items-center">
          <!-- Notifications -->
          <div class="dropdown">
            <a class="text-reset me-3 dropdown-toggle hidden-arrow" href="/noti/list" role="button">
              <i class="fas fa-bell"></i>
              <?php if ($ntoo > 0) { ?>
                <span class="badge rounded-pill badge-notification bg-danger"><?= $ntoo ?></span>
              <?php } ?>
            </a>
          </div>
          <!-- Avatar -->
          <div class="dropdown">
            <?php
            $img = "/images/user.jpg";
            $image_path = ROOT . "/www/images/users/$user_id-t.jpg";
            if (file_exists($image_path)) {
              $img = "/images/users/$user_id-t.jpg";
            }
            ?>
            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              <img src="<?= $img ?>" class="rounded-circle cover" height="30" width="30" loading="lazy" />
              <div class="d-flex flex-column m-2">
                <small><?= substr(trim($user_fname), 0, 2) ?>.<?= $user_lname ?></small>
                <small style="font-size: 0.7rem;" class="text-danger"><?= $_SESSION['user_at'] ?></small>
              </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuAvatar">
              <li>
                <a class="dropdown-item" href="/profile/info">Миний мэдээлэл</a>
              </li>
              <li>
                <a class="dropdown-item" href="/profile/password">Нууц үг солих</a>
              </li>
              <li>
                <a class="dropdown-item" href="/sign-out">Гарах</a>
              </li>
            </ul>
          </div>
        </div>
        <!-- Right elements -->
      </div>
      <!-- Container wrapper -->
    </nav>
  </div>
  <div class="container-fluid">