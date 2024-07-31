<?php require 'start.php'; ?>
<?php require 'header.php'; 
_selectRowNoParam(
    "SELECT count(id) FROM products",
    $sumPro);

_selectRowNoParam(
    "SELECT count(id) FROM products WHERE tuluv = '1'",
    $sumBPro);
_selectRowNoParam(
    "SELECT count(id) FROM orders WHERE ognoo >= '" . ognooday() . "' and ognoo <= '" . date('Y-m-d 00:00:00', strtotime(ognooday() . ' +1 day')) . "'",
    $sumTOrder);
_selectRowNoParam(
    "SELECT count(id) FROM orders WHERE tuluv='0'",
    $sumNOrder);
?>
<!-- partial -->
<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="row">
          <div class="col-12 col-xl-8 mb-4 mb-xl-0">
            <h3 class="font-weight-bold">Сайн байна уу? Тэндоү</h3>
          </div>
          <div class="col-12 col-xl-4">
            <div class="justify-content-end d-flex">
              <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                  <i class="mdi mdi-calendar"></i> Өнөөдөр <?=ognooday()?>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                  <a class="dropdown-item" href="#">January - March</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 grid-margin transparent">
        <div class="row">
          <div class="col-md-3 mb-3 stretch-card transparent">
            <div class="card card-tale">
              <div class="card-body">
                <p class="mb-4">Нийт бүтээгдэхүүн</p>
                <p class="fs-30 mb-2"><?=$sumPro?></p>
                <p>төрөл байна</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3 stretch-card transparent">
            <div class="card card-dark-blue">
              <div class="card-body">
                <p class="mb-4">Борлуулагдаж байгаа</p>
                <p class="fs-30 mb-2"><?=$sumBPro?></p>
                <p>төрлийн бүтээгдэхүүн байна</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3 stretch-card transparent">
            <div class="card card-light-blue">
              <div class="card-body">
                <p class="mb-4">Өнөөдөрийн захиалга</p>
                <p class="fs-30 mb-2"><?=$sumTOrder?></p>
                <p>захиалга хийгдсэн байна</p>
              </div>
            </div>
          </div>
          <div class="col-md-3 mb-3 stretch-card transparent">
            <div class="card card-light-danger">
              <div class="card-body">
                <p class="mb-4">Төлбөр хүлээгдэж байгаа</p>
                <p class="fs-30 mb-2"><?=$sumNOrder?></p>
                <p>захиалга байна</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title mb-0">ХАМГИЙН ИХ ХАНДАЛТ ХИЙСЭН ХЭРЭГЛЭГЧИД</p>
            <div class="table-responsive">
              <table class="table table-striped table-borderless">
                <thead>
                  <tr>
                    <th>Нэр</th>
                    <th>Утас</th>
                    <th>Email</th>
                    <th>Үйлдэл</th>
                  </tr>
                </thead>
                <tbody>
                    <?php
                    _selectNoParam(
                                    $rankstmt,
                                    $rankcount,
                                    "SELECT COUNT(loginlog.userid) as total, loginlog.userid, display_name, user_phone, user_email FROM `loginlog` INNER JOIN wp_users ON loginlog.userid = wp_users.ID GROUP BY userid ORDER BY total DESC LIMIT 10",
                                    $ranktoo,
                                    $rankid,
                                    $rankuser,
                                    $rankemail,
                                    $rankphone
                                );
                    while(_fetch($rankstmt)){
                        echo "<tr>
                                <td>$rankuser</td>
                                <td class='font-weight-bold'>$rankphone</td>
                                <td>$rankemail</td>
                                <td>";
                         $external_link = "https://tendou.mn/images/" . $rankid . ".jpg";
                        if (@getimagesize($external_link)) {
                            echo  '<img id="pro" src="'.$external_link.'" style="width: 50px;border-radius: 50px;height: 50px;object-fit: cover;border: 2px solid;margin: auto"/>';
                        } else {
                            echo  '<img id="pro" src="https://tendou.mn/images/none.jpg" style="width: 50px;border-radius: 50px;height: 50px;object-fit: cover;border: 2px solid;margin: auto"/>';
                        }
                        echo "</td>
                              </tr>";
                        
                    }
                    ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--
        <div class="row">
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <p class="card-title">Захиалгын статистик</p>
            <p class="font-weight-500">Захиалга</p>
            <div class="d-flex flex-wrap mb-5">
              <div class="mr-5 mt-3">
                <p class="text-muted">Order value</p>
                <h3 class="text-primary fs-30 font-weight-medium">12.3k</h3>
              </div>
              <div class="mr-5 mt-3">
                <p class="text-muted">Orders</p>
                <h3 class="text-primary fs-30 font-weight-medium">14k</h3>
              </div>
              <div class="mr-5 mt-3">
                <p class="text-muted">Users</p>
                <h3 class="text-primary fs-30 font-weight-medium">71.56%</h3>
              </div>
              <div class="mt-3">
                <p class="text-muted">Downloads</p>
                <h3 class="text-primary fs-30 font-weight-medium">34040</h3>
              </div>
            </div>
            <canvas id="order-chart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between">
              <p class="card-title">Худалдан авалтын</p>
              <a href="#" class="text-info">View all</a>
            </div>
            <p class="font-weight-500">Худалдан авалт</p>
            <div id="sales-legend" class="chartjs-legend mt-4 mb-2"></div>
            <canvas id="sales-chart"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>-->

  <?php require 'footer.php'; ?>
  <script src="/vendors/chart.js/Chart.min.js"></script>
  <script src="/vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <script src="/js/dataTables.select.min.js"></script>
  <script src="/js/dashboard.js"></script>
  <script src="/js/Chart.roundedBarCharts.js"></script>
  <script src="/js/Chart.roundedBarCharts.js"></script>
  <?php require 'end.php'; ?>