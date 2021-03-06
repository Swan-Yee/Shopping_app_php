<?php
session_start(); 
if (!empty($_POST['search'])) {
  setcookie('search',$_POST['search'], time() + (86400 * 30), "/");
}else{
  if (empty($_GET['pageno'])) {
    unset($_COOKIE['search']); 
    setcookie('search', null, -1, '/'); 
  }
}

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
	header('location: login.php');
}

?>
<?php include('header.php'); ?>
<?php
	require 'config/config.php';
	require 'config/common.php';

	if(isset($_GET['pageno'])){
		$pageno= $_GET['pageno'];
	}
	else{
	 $pageno=1;
	}
	
	$numOfRec=5;
	$offSet=($pageno -1 )* $numOfRec;
	
		if(empty($_POST['search']) && empty($_COOKIE['search'])){
			$stmt=$pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
			$stmt->execute();
			$rawResult= $stmt->fetchAll();
			$total_page= ceil(count($rawResult)/$numOfRec);
			
		  $stmt=$pdo->prepare("SELECT * FROM products WHERE quantity >0 ORDER BY id DESC LIMIT $offSet,$numOfRec");
		  $stmt->execute();
		  $result= $stmt->fetchAll();
		  	
			if(isset($_GET['cat'])){
				$catStmt=$pdo->prepare("SELECT id FROM categories WHERE id=".$_GET['cat']);
				$catStmt->execute();
				$catResult=$catStmt->fetchAll();

				$stmt=$pdo->prepare("SELECT * FROM products WHERE category_id=".$catResult[0][0]." AND quantity > 0");
				$stmt->execute();
				$result=$stmt->fetchAll();
				$total_page= ceil(count($result)/$numOfRec);
			}
		  }
		  else{
			$searchKey= $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
			  $stmt=$pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC");
			  $stmt->execute();
			  $rawResult= $stmt->fetchAll();
			  $total_page= ceil(count($rawResult)/$numOfRec);
	  
			$stmt=$pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC LIMIT $offSet,$numOfRec");
			$stmt->execute();
			$result= $stmt->fetchAll();
		  }
?>
<div class="container">
		<div class="row">
			<div class="col-xl-3 col-lg-4 col-md-5">
				<div class="sidebar-categories">
					<div class="head">Browse Categories</div>
					<ul class="main-categories">
						<li class="main-nav-list">
							<?php 
								$catStmt=$pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
								$catStmt->execute();
								$catResult=$catStmt->fetchAll();
							?>

							<?php 
								foreach ($catResult as $key => $value){
							?>
							<a href="?cat=<?php echo $value['id'] ?>"><?php echo escape($value['name']) ?></a>
							<?php 
								}
							?>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
			<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="pagination">
						<a <?php if($pageno <=1 ){echo 'disabled';} ?> href="?pageno=1" class="active">First</a>
							<a <?php if($pageno <=1 ){echo 'disabled';} ?> href="<?php if($pageno <=1 ){echo '#';}else{echo "?pageno=".($pageno-1);} ?>" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
							<a href="#" class="active"><?php echo $pageno; ?></a>
							<a <?php if($pageno >=$total_page ){echo 'disabled';} ?> href="<?php if($pageno >= $total_page ){echo '#';}else{echo "?pageno=".($pageno+1);} ?>" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
						<a <?php if($pageno >=$total_page ){echo 'disabled';} ?> href="?pageno=<?php echo $total_page ?>" class="active">Last</a>
					</div>
				</div>
				<!-- End Filter Bar -->

				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
						<?php 
							if($result){
								foreach ($result  as $key => $value){?>
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<img class="" src="admin/product_image/<?php echo $value['image'] ?>" alt="" width="300" height="300">
								<div class="product-details">
									<h6><?php echo escape($value['name']) ?></h6>
									<div class="price">
										<h6><?php echo escape($value['price']) ?></h6>
									</div>
									<div class="prd-bottom">
										<form action="add_to_card.php" method="post">
											<input type="hidden" name="_token" value="<?php echo $_SESSION['_token'] ?>">
											<input type="hidden" name="id" value="<?php echo $value['id'] ?>">
											<input type="hidden" name="qty" value="1">
										<a href="" class="social-info">
											<button type="submit" style="display:contents">
											<span class="ti-bag"></span>
											<p class="hover-text" style="left: 20px">add to bag</p>
											</button>
											</a>
										<a href="product_detail.php?id=<?php echo $value['id'] ?>" class="social-info">
											<span class="lnr lnr-move"></span>
											<p class="hover-text">view more</p>
										</a>
										</form>
									</div>
								</div>
							</div>
						</div>
								<?php
								}
							}
							?>
					</div>
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>
