<?php
session_start();
require 'config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
      header('location: login.php');
}

    $stmt=$pdo->prepare("SELECT role FROM users WHERE id=".$_SESSION['user_id']);
    $stmt->execute();
    $result=$stmt->fetchAll();

    if($result[0]['role'] == 0){
      header('location: login.php');
    }
?>

<?php include 'header.html' ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper p-3">
    <!-- Content Header (Page header) -->   
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Orders Detail</h3>
              </div>
            <!-- /.card-header -->
            <div class="card-body">
                <a href="order.php" class="btn btn-outline-primary">Back</a>
                <br><br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                    <?php

                    $stmt=$pdo->prepare("SELECT * FROM sale_order_detail WHERE sale_order_id=".$_GET['id']);
                    $stmt->execute();
                    $result= $stmt->fetchAll();
                    ?>
                      <th style="width: 10px">#</th>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Order Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        if($result){
                          $i=1;
                          foreach($result as $value){
                           
                        $stmtPro=$pdo->prepare("SELECT * FROM products WHERE id=".$value['product_id']);
                        $stmtPro->execute();
                        $resultPro=$stmtPro->fetchAll();
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $resultPro[0]['name']; ?></td>
                      <td>
                        <?php echo $value['quantity']; ?>
                      </td>
                      <td><?php echo date('Y-m-d',strtotime($value['order_date'])) ?></td>
                    </tr>
                          <?php
                        $i++;
                          }
                        }
                    ?>
                  </tbody>
                </table>
              </div>

              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php include 'footer.html' ?>