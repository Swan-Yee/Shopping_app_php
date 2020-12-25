<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

if($_POST){
  if(empty($_POST['name']) || empty($_POST['description'])){
    if(empty($_POST['name'])){
      $nameError="name cannot be Empty!";
    }
    if(empty($_POST['description'])){
      $descriptionError="description cannot be Empty!";
    }
  }
  else{
      $name=$_POST['name'];
      $description=$_POST['description'];

      $stmt=$pdo->prepare("INSERT INTO categories(name,description) VALUES (:name,:description)");
      $result=$stmt->execute(
          array(':name'=>$name,':description'=>$description)
      );
  
      if($result){
          echo "<script>alert('Successfully Add!');window.location.href='category.php';</script>";     
      }
    } 
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
                <h3 class="card-title">CREATE Category</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <form action="" method="post">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                              <?php echo empty($nameError) ? '': "<p class='alert alert-danger'>" .$nameError."</p>" ?>
                            <input type="text" name="name" id="name" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="Description">Description</label>
                            <?php echo empty($descriptionError) ? '': "<div class='alert alert-danger' role='alert'>" .$descriptionError."</div>" ?>
                            <textarea name="description" id="Description" class="form-control"></textarea>
                        </div>
                        <div class="form-group float-right">
                            <input type="submit" value="Submit" class="btn btn-primary">
                            <a href="index.php" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </form>
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