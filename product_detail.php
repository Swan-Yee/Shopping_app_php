<?php 
require 'config/config.php';
require 'config/common.php';

if($_GET['id']){
    $stmt=$pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
    $stmt->execute();
    $result=$stmt->fetchAll();
}
?>

<?php include('header.php') ?>
<!--================Single Product Area =================-->
<div class="product_image_area">
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
            <li><a class="active"><span>Category</span><?php echo $catResult[0]['name'] ?></a></li>
          </ul>
          <p><?php echo $result[0]['description']; ?></p>
          <div class="product_count">
            <label for="qty">Quantity:</label>
            <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
            <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
             class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
          </div>
          <div class="card_area d-flex align-items-center">
            <a class="primary-btn" href="#">Add to Cart</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
