<?php 
session_start();
require 'config/config.php';
require 'config/common.php';

require 'header.php';

if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
    header('location: login.php');
}

?>
<!DOCTYPE html>
<html lang="zxx" class="no-js">

<head>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon-->
    <link rel="shortcut icon" href="img/fav.png">
    <!-- Author Meta -->
    <meta name="author" content="CodePixar">
    <!-- Meta Description -->
    <meta name="description" content="">
    <!-- Meta Keyword -->
    <meta name="keywords" content="">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title>Karma Shop</title>

    <!--
            CSS
            ============================================= -->
    <link rel="stylesheet" href="css/linearicons.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/nice-select.css">
    <link rel="stylesheet" href="css/nouislider.min.css">
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>

    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                    <?php 
                        if (!empty($_SESSION['card'])) : ?>
                    <table class="table w-100">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $total= 0;
                            foreach($_SESSION['card'] as $key => $qty) :
                                $id= str_replace('id','',$key);

                                $stmt= $pdo->prepare('SELECT * FROM products WHERE id='.$id);
                                $stmt->execute();
                                $result=$stmt->fetch(PDO::FETCH_ASSOC);

                                $total += $result['price'] * $qty;
                                
                         ?>
                            <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin/product_image/<?php echo $result['image'] ?>" alt="" width="150" height="150">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo escape($result['name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5>
                                        <p><?php echo escape($result['price']); ?></p>
                                    </h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                    <p><?php echo escape($qty); ?></p>
                                        
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['price'] * $qty)?></h5>
                                </td>
                                <td>
                                    <a href="clear_item_clear.php?id=<?php echo $result['id'] ?>" class="btn btn-outline-danger">Remove</a>
                                </td>
                            </tr>
                            <?php 
                                endforeach
                            ?>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td></td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo $total ?></h5>
                                </td>
                            </tr>
                            <tr class="out_button_area">
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td></td>
                                <td>
                                    <div class="checkout_btn_inner d-flex align-items-center">
                                        <a class="gray_btn mr-1" href="clear_all.php">Clear All</a>
                                        <a class="gray_btn" href="index.php">Continue Shopping</a>
                                        <a class="primary-btn" href="sale_order.php">Order confirm</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </section>
<?php 
require 'footer.php';
?>