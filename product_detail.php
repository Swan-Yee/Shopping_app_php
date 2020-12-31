<?php 
session_start();
require 'config/config.php';
require 'config/common.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header('location: login.php');
}

if($_GET['id']){
    $stmt=$pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
    $stmt->execute();
    $result=$stmt->fetchAll();
  }
?>

<?php include('header.php') ?>
<!--================Single Product Area =================-->
<div class="product_image_area p-0 m-0">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
            <img class="img-fluid" src="admin/product_image/<?php echo $result[0]['image'] ?>" alt="" width="500" height="500">   
        </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo $result[0]['name'] ?></h3>
          <h2><?php echo $result[0]['price'] ?></h2>
          <ul class="list">
          <?php   
              $catId=$result[0]['category_id'];
              $catStmt=$pdo->prepare("SELECT * FROM categories WHERE id=$catId");
              $catStmt->execute();
              $catResult=$catStmt->fetchAll();
          ?>
            <li><a class="active"><span>Category</span><?php echo escape($catResult[0]['name']) ?></a></li>
          </ul>
          <p><?php echo escape($result[0]['description']); ?></p>
          <form action="add_to_card.php" method="post">
            <input type="hidden" name="id" value="<?php echo $result[0]['id'] ?>">
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
             <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
               class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <button type="submit" class="primary-btn border-0">Add to Cart</button>
            <a class="primary-btn" href="index.php">Back</a>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
