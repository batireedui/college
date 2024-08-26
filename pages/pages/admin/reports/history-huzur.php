<?php require ROOT . '/pages/admin/start.php';?>
<?php require ROOT . '/pages/admin/header.php';

_selectNoParam(
    $stmttoo,
    $counttoo,
    "SELECT id, phone, name, hezee, uildel FROM loginhuzur",
    $id, $phone, $name, $hezee, $uildel 
);
?>

<div class="main-panel">
        <div class="content-wrapper">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Хөзрийн багш үйлдлийн түүх</h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th>#</th>
                            <th>Нэр</th>
                            <th>Утас</th>
                            <th>Үйлдэл</th>
                            <th>Огноо</th>
                        </tr>
                      </thead>
                      <tbody>
                            <?php
                            $n=1;
                            while(_fetch($stmttoo))
                            {
                                echo "<tr>
                                    <td>$n</td>
                                    <td>$name</td>
                                    <td>$phone</td>
                                    <td>$uildel</td>
                                    <td>$hezee</td>
                                </tr>";
                                $n++;
                            }
                            ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<?php require ROOT . '/pages/admin/footer.php';?>
<script src="/js/data-table.js"></script>