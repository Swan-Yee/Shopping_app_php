<?php 
session_start();
require 'config/common.php';
require 'config/config.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

$user_id=$_SESSION['user_id'];
$total=0;
foreach($_SESSION['card'] as $key => $qty){
    $id= str_replace('id','',$key);

    $stmt= $pdo->prepare('SELECT * FROM products WHERE id='.$id);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    $total += $result['price'] * $qty;
}

$stmt=$pdo->prepare("INSERT INTO sale_orders(user_id,total_price,order_date) VALUES (:userid,:total,:odate)");
$result=$stmt->execute(
    array(':userid'=>$user_id,':total'=>$total,':odate'=>date('Y-m-d H:i:s'))
);

if($result){
    $saleOrderId=$pdo->lastInsertId();

    foreach($_SESSION['card'] as $key => $qty){
        $id= str_replace('id','',$key);

        $stmt=$pdo->prepare("INSERT INTO sale_order_detail(sale_order_id,product_id,quantity) VALUES (:sid,:pid,:quantity)");
        $result=$stmt->execute(array(':sid'=>$saleOrderId,':pid'=>$id,':quantity'=>$qty));

        $qtyStmt=$pdo->prepare("SELECT * FROM products WHERE id=".$id);
        $qtyStmt->execute();
        $qResult=$qtyStmt->fetch(PDO::FETCH_ASSOC);

        $updateQty= $qResult['quantity']-$qty;

        $stmt=$pdo->prepare("UPDATE products SET quantity=:qty WHERE id=:pid");

        $result=$stmt->execute(
            array(':qty'=>$updateQty,':pid'=>$id)
        );

unset($_SESSION['card']);
        
    }
}
?>
<?php include('header.php') ?>
<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
			<div class="row order_d_inner">
				<div class="col-lg-12">
					<div class="details_item">
						<h4>Order Info</h4>
						<ul class="list">
							<li><a href="#"><span>Order number</span> : 60235</a></li>
							<li><a href="#"><span>Date</span> : Los Angeles</a></li>
							<li><a href="#"><span>Total</span> : USD 2210</a></li>
							<li><a href="#"><span>Payment method</span> : Check payments</a></li>
						</ul>
					</div>
                </div>
            </div>
        </div>
</section>
<?php include('footer.php') ?>
