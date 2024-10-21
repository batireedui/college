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
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <!-- Container wrapper -->
      <div class="container-fluid">
        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar brand -->
          <a class="navbar-brand mt-2 mt-lg-0" href="/">
            <img src="/images/logo.jpg" height="35" loading="lazy" />
          </a>
          <!-- Left links -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/">ЭХЛЭЛ</a>
            </li>
            <?php
            if ($user_role == 1) {
              _selectRowNoParam(
                "SELECT COUNT(id) FROM `class` WHERE teacherid = '$user_id' and tuluv = 1",
                $myClass
              );
              if ($myClass > 0) {
            ?>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle <?php echo strpos($page, "/student") > -1 ? 'active' : ''; ?>" href="#" id="mcl" role="button" data-mdb-toggle="dropdown" aria-expanded="false">МАНАЙ АНГИ</a>
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
            } ?>
            <?php
            if ($user_role == 3) {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/student") > -1 ? 'active' : ''; ?>" href="#" id="mcl" role="button" data-mdb-toggle="dropdown" aria-expanded="false">БҮРТГЭЛ</a>
                <ul class="dropdown-menu" aria-labelledby="mcl">
                  <li>
                    <a class="dropdown-item <?php echo strpos($page, "/student") > -1 ? 'active' : ''; ?>" href="/student/list">СУРАЛЦАГЧИД</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php echo strpos($page, "/class/list") > -1 ? 'active' : ''; ?>" href="/class/list">АНГИ</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link <?php echo strpos($page, "/teacher") > -1 ? 'active' : ''; ?>" href="/teacher/list">БАГШ, АЖИЛТАН</a>
                  </li>
                </ul>
              </li>
            <?php
            }
            if ($user_role < 3) {
            ?>
              <li class="nav-item">
                <a class="nav-link <?php echo strpos($page, "/att/list") > -1 ? 'active' : ''; ?>" href="/att/list">ИРЦ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo strpos($page, "/tclass") > -1 ? 'active' : ''; ?>" href="/tclass/list">АНГИ</a>
              </li>
              <li class="nav-item">
                <a class="nav-link <?php echo strpos($page, "/lesson") > -1 ? 'active' : ''; ?>" href="/lesson/list">ХИЧЭЭЛ</a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/report") > -1 ? 'active' : ''; ?>" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  ТАЙЛАН
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
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
            <?php
            } else {
            ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/report") > -1 ? 'active' : ''; ?>" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  ТАЙЛАН
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="/report/att">АНГИЙН ИРЦ</a>
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
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle <?php echo strpos($page, "/noti") > -1 ? 'active' : ''; ?>" href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                  ЗАР
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                  <li>
                    <a class="dropdown-item" href="/noti/send">ИЛГЭЭСЭН ЗАР</a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="/noti/new">ЗАР ИЛГЭЭХ</a>
                  </li>
                </ul>
              </li>
            <?php
            }
            ?>
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
            <a class="dropdown-toggle d-flex align-items-center hidden-arrow" href="#" id="navbarDropdownMenuAvatar" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
              <img src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp" class="rounded-circle" height="25" alt="Black and White Portrait of a Man" loading="lazy" />
              <span class="m-2" style="font-size: 12px;"><?= substr(trim($user_fname), 0, 2) ?>.<?= $user_lname ?></span>
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