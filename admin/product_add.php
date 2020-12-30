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


if($_POST){
  if(empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price']) || empty($_POST['quantity']) || empty($_POST['category'])){
    if(empty($_POST['name'])){
      $nameError="name cannot be Empty!";
    }
    if(empty($_POST['description'])){
      $descriptionError="description cannot be Empty!";
    }
    if(empty($_POST['description'])){
        $descriptionError="description cannot be Empty!";
    }
    if(empty($_POST['price'])){
      $priceError="price cannot be Empty!";
    }
    if(empty($_POST['quantity'])){
      $quantityError="quantity cannot be Empty!";
    }
    if(empty($_POST['category'])){
        $categoryError="Category cannot be Empty!";
      }
  }
  else{
    if(empty($_FILES['image'])){
        $image=$_POST['oImage'];
      }
      else{

      }

    $file= 'product_image/'.($_FILES['image']['name']);
    $imgType=pathinfo($file,PATHINFO_EXTENSION);
  
    if($imgType == 'png' && $imgType == 'jpg' && $imgType == 'jpeg'){
          echo "<script>alert('image should be PNG JPG and JPEG')</script>";
    }
  else{

      $name=$_POST['name'];
      $description=$_POST['description'];
      $price=$_POST['price'];
      $quantity=$_POST['quantity'];
      $category=$_POST['category'];
      $image=$_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],$file);
  
      $stmt=$pdo->prepare("INSERT INTO products(name,description,price,quantity,category_id,image) VALUES (:name,:description,:price,:quantity,:category_id,:image)");
      $result=$stmt->execute(
          array(':image'=>$image,':name'=>$name,':description'=>$description,':price'=>$price,':quantity'=>$quantity,':category_id'=>$category)
      );
  
      if($result){
          echo "<script>alert('Successfully Add!');window.location.href='index.php';</script>";     
      }
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
                <h3 class="card-title">CREATE Products</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <form action="product_add.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                              <?php echo empty($nameError) ? '': "<p class='alert alert-danger'>" .$nameError."</p>" ?>
                            <input type="text" name="name" id="name" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="description">description</label>
                            <?php echo empty($descriptionError) ? '': "<div class='alert alert-danger' role='alert'>" .$descriptionError."</div>" ?>
                            <input type="text" name="description" id="description" class="form-control" value="">
                        </div>
                        <?php 
                          $catStmt=$pdo->prepare("SELECT * FROM categories");
                          $catStmt->execute();
                          $catResult=$catStmt->fetchAll();
                        ?>
                        <div class="form-group">
                            <label for="pass">Category</label>
                              <?php echo empty($categoryError) ? '': "<p class='alert alert-danger'>" .$categoryError."</p>" ?>
                              <select name="category" id="" class="form-control">
                                <?php foreach ($catResult as $value){ ?>
                                    <option value="<?php echo $value['id'] ?>"><?php echo $value['name'] ?></option>
                                <?php } ?>
                              </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">quantity</label>
                              <?php echo empty($quantityError) ? '': "<p class='alert alert-danger'>" .$quantityError."</p>" ?>
                              <?php echo empty($qError) ? '': "<p class='alert alert-danger'>" .$qError."</p>" ?>
                            <input type="number" name="quantity" id="name" class="form-control" value="" min=0>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                              <?php echo empty($priceError) ? '': "<p class='alert alert-danger'>" .$priceError."</p>" ?>
                            <input type="number" name="price" id="price" class="form-control" value="">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                              <?php echo empty($imageError) ? '': "<p class='alert alert-danger'>" .$imageError."</p>" ?>
                            <input type="file" name="image" id="image" class="form-control" value="">
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