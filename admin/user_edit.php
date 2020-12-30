<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

$stmt=$pdo->prepare("SELECT role FROM users WHERE id=".$_SESSION['user_id']);
$stmt->execute();
$result=$stmt->fetchAll();

if($result[0]['role'] == 0){
  header('location: login.php');
}


if($_GET){
    $id=$_GET['id'];
    $stmt=$pdo->prepare('SELECT * FROM users WHERE id= 2');
    $stmt->execute();
    $result=$stmt->fetchAll();
}

if($_POST){
  if(empty($_POST['name']) || empty($_POST['mail']) || empty($_POST['password']) || empty($_POST['address']) || empty($_POST['phone'])){
    if(empty($_POST['name'])){
      $nameError="name cannot be Empty!";
    }
    if(empty($_POST['mail'])){
      $mailError="mail cannot be Empty!";
    }
    if(empty($_POST['mail'])){
        $mailError="mail cannot be Empty!";
    }
    if(empty($_POST['password'])){
      $passError="Pasword cannot be Empty!";
    }
    if(empty($_POST['address'])){
      $addressError="Address cannot be Empty!";
    }
    if(empty($_POST['phone'])){
      $phoneError="Phone cannot be Empty!";
    }
  }
  else{
      $name=$_POST['name'];
      $mail=$_POST['mail'];
      $password=$_POST['password'];
      $address=$_POST['address'];
      $phone=$_POST['phone'];

      if($_POST['admin']){
          $role= 1;
      }else{
          $role=0;
      }

      $stmt=$pdo->prepare("UPDATE users SET name='$name',email='$mail',password='$password',address='$address',phone='$phone',role='$role'");
      $result=$stmt->execute();
  
      if($result){
          echo "<script>alert('Successfully edit!');window.location.href='user.php';</script>";     
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
                <h3 class="card-title">CREATE Users</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <form action="" method="post">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                              <?php echo empty($nameError) ? '': "<p class='alert alert-danger'>" .$nameError."</p>" ?>
                            <input type="text" name="name" id="name" class="form-control" value="<?php echo $result[0]['name'] ?>">
                        </div>  
                        <div class="form-group">
                            <label for="mail">Mail</label>
                            <?php echo empty($mailError) ? '': "<div class='alert alert-danger' role='alert'>" .$mailError."</div>" ?>
                            <input type="text" name="mail" id="mail" class="form-control" value="<?php echo $result[0]['email'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="pass">password</label>
                              <?php echo empty($passError) ? '': "<p class='alert alert-danger'>" .$passError."</p>" ?>
                            <input type="password" name="password" id="pass" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                              <?php echo empty($addressError) ? '': "<p class='alert alert-danger'>" .$addressError."</p>" ?>
                            <input type="text" name="address" id="name" class="form-control" value="<?php echo $result[0]['address'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                              <?php echo empty($phoneError) ? '': "<p class='alert alert-danger'>" .$phoneError."</p>" ?>
                            <input type="text" name="phone" id="phone" class="form-control" value="<?php echo $result[0]['phone'] ?>">
                        </div>
                        <div class="form-group">
                            <label for="admin">Admin</label>
                            <input type="checkbox" name="admin" class="form-control" id="">
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