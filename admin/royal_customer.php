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
                <h3 class="card-title">Royal User List</h3>
              </div>
              <div class="card-body">
                <table class="table table-bordered display" id="d-table" style="width:100%">
                  <thead>                  
                    <tr>
                    <?php         
                        $stmt=$pdo->prepare("SELECT * FROM sale_orders WHERE total_price>100000 ORDER BY id DESC");
                        $stmt->execute();
                          $result=$stmt->fetchAll();          
                    ?>
                      <th style="width: 10px">#</th>
                      <th>UserID</th>
                      <th>Total Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        if($result){
                          $i=1;
                          foreach($result as $value){
                            
                        $userStmt=$pdo->prepare("SELECT * FROM users WHERE id=".$value['user_id']); 
                        $userStmt->execute();
                        $userResult=$userStmt->fetchAll();
                            
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $userResult[0]['name']; ?></td>
                      <td>
                        <?php echo substr($value['total_price'], 0, 100) ?>
                      </td>
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