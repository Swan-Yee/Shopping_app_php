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
                <h3 class="card-title">Product Listing</h3>
              </div>
              <div class="card-body">
                  <div class="">
                    <a href="product_add.php" class="btn btn-success">Create New Products</a>
                  </div>                <br>
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                    <?php
                    if(isset($_GET['pageno'])){
                        $pageno= $_GET['pageno'];
                    }
                    else{
                     $pageno=1;
                    }

                    $numOfRec=5;
                    $offSet=($pageno -1 )* $numOfRec;
                    
                    if(empty($_POST['search'])){
                      $stmt=$pdo->prepare("SELECT * FROM products ORDER BY id DESC");
                      $stmt->execute();
                      $rawResult= $stmt->fetchAll();
                      $total_page= ceil(count($rawResult)/$numOfRec);
                      
                    $stmt=$pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offSet,$numOfRec");
                    $stmt->execute();
                    $result= $stmt->fetchAll();
                    }
                    else{
                      $searchKey=$_POST['search'];
                        $stmt=$pdo->prepare("SELECT * FROM categories WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                        $stmt->execute();
                        $rawResult= $stmt->fetchAll();
                        $total_page= ceil(count($rawResult)/$numOfRec);
  
                      $stmt=$pdo->prepare("SELECT * FROM useres WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offSet,$numOfRec");
                      $stmt->execute();
                      $result= $stmt->fetchAll();
                    }

                    ?>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Description</th>
                      <th>Categroy_id</th>
                      <th>Qantity</th>
                      <th>Price</th>
                      <th>image</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                        if($result){
                          $i=1;
                          foreach($result as $value){?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value['name']; ?></td>
                      <td>
                        <?php echo substr($value['description'], 0, 100) ?>
                      </td>
                      <td><?php echo $value['category_id']; ?></td>
                      <td><?php echo $value['quantity']; ?></td>
                      <td><?php echo $value['price']; ?></td>
                      <td><?php echo $value['image']; ?></td> 
                      <td>
                        <div class="row">
                          <div class="btn-group">
                            <div class="container">
                              <a href="product_edit.php?id=<?php echo $value['id']; ?>" class="btn btn-warning">Edit</a>
                            </div>
                            <div class="container">
                              <a href="product_delete.php?id=<?php echo $value['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure To Detete')">Delete</a>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                          <?php
                        $i++;
                          }
                        }
                    ?>
                  </tbody>
                </table>

                <nav aria-label="Page navigation" class="mt-3 float-right">
                  <ul class="pagination">
                    <li class="page-item">
                      <a href="?pageno=1" class="page-link">First</a>
                    </li>
                    <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>">
                      <a href="<?php if($pageno <=1){echo '#';}else{echo '?pageno='.($pageno-1);} ?>" class="page-link">Previous</a>
                    </li>
                    <li class="page-item active">
                      <a href="" class="page-link"><?php echo $pageno ?></a>
                    </li>
                    <li class="page-item <?php if($pageno >= $total_page){echo 'disabled';} ?>">
                      <a href="<?php if($pageno >= $total_page){echo '#';}else{echo '?pageno='.($pageno+1);} ?>" class="page-link">Next</a>
                    </li>
                    <li class="page-item">
                      <a href="?pageno=<?php echo $total_page?>" class="page-link">Last</a>
                    </li>
                  </ul>
                </nav>
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