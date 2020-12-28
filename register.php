<?php 
session_start();
require 'config/config.php';
require 'config/common.php';

if($_POST){
    if(empty($_POST['name']) || empty($_POST['mail']) || empty($_POST['phone']) || empty($_POST['address']) || empty($_POST['password']) || strlen($_POST['password']) <4 ){
        if(empty($_POST['name'])){
            $nameError="Name input box is required!";
        }
        if(empty($_POST['mail'])){
            $mailError="mail input box is required!";
        }
        if(empty($_POST['phone'])){
            $phoneError="phone input box is required!";
        }
        if(empty($_POST['address'])){
            $addressError="address input box is required!";
        }
        if(empty($_POST['password'])){
            $passwordError="password input box is required!";
        }elseif(strlen($_POST['password']) <4){
            $passwordLeError="password shoud be more than 4";
        }
    }
    else{
        $email= $_POST['mail'];
        $name= $_POST['name'];
        $phone= $_POST['phone'];
        $address= $_POST['address'];
        $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

	$stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
	$result=$stmt->execute(
		array(':email'=>$email)
    );
    $user=$stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        echo "<script>alert('Email already exit')</script>";
    }else{
        $stmt=$pdo->prepare('INSERT INTO users(name,email,phone,address,password) VALUES (:name,:email,:phone,:address,:password)');
        $result=$stmt->execute(
            array(':name'=>$name,':email'=>$email,':phone'=>$phone,':address'=>$address,":password"=>$password)
        );

        if($result){
            echo "<script>alert('successfull Reg')window.location.href='login.php';</script>";
		}
		else{
			echo "Not success!";die;
		}
	} 
}  
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
	<title>Shopping website</title>

	<!--
		CSS
		============================================= -->
	<link rel="stylesheet" href="css/linearicons.css">
	<link rel="stylesheet" href="css/owl.carousel.css">
	<link rel="stylesheet" href="css/themify-icons.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<link rel="stylesheet" href="css/nice-select.css">
	<link rel="stylesheet" href="css/nouislider.min.css">
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/main.css">
</head>

<body>

	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.html"><img src="img/logo.png" alt=""></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
				</div>
			</nav>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="category.html">Login/Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="login_form_inner">
						<h3>Register Here</h3>
						<form class="row login_form" action="" method="post" id="contactForm" novalidate="novalidate">
                        <input type="hidden" name="_token" value='<?php echo $_SESSION['_token']; ?>'>    
                        <div class="col-md-12 form-group">
							<?php echo empty($nameError) ? '': "<span class='text-danger'>*" .$nameError."</span>" ?>
								<input type="name" class="form-control" id="name" name="name" placeholder="name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div>
                            <div class="col-md-12 form-group">
							<?php echo empty($mailError) ? '': "<span class='text-danger'>*" .$mailError."</span>" ?>
								<input type="email" class="form-control" id="name" name="mail" placeholder="Email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email'">
                            </div>
                            <div class="col-md-12 form-group">
							<?php echo empty($phoneError) ? '': "<span class='text-danger'>*" .$phoneError."</span>" ?>
								<input type="number" class="form-control" id="name" name="phone" placeholder="phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone Number'">
                            </div>
                            <div class="col-md-12 form-group">
							<?php echo empty($addressError) ? '': "<span class='text-danger'>*" .$addressError."</span>" ?>
								<input type="address" class="form-control" id="name" name="address" placeholder="address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'">
							</div>
							<div class="col-md-12 form-group">
							<?php echo empty($passwordError) ? '': "<span class='text-danger'>*" .$passwordError."</span>" ?>
							<?php echo empty($passwordLeError) ? '': "<span class='text-danger'>*" .$passwordLeError."</span>" ?>	
							<input type="password" class="form-control" id="name" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" class="primary-btn">Register</button>
							</div>
							<div class="col-md-12 form-group">
                                <a href="login.php" class="primary-btn">Log in</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Login Box Area =================-->

	<!-- start footer Area -->
	<footer class="footer-area section_gap">
	<center>
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
</p>
	</center>		
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
	</footer>
	<!-- End footer Area -->


	<script src="js/vendor/jquery-2.2.4.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
	 crossorigin="anonymous"></script>
	<script src="js/vendor/bootstrap.min.js"></script>
	<script src="js/jquery.ajaxchimp.min.js"></script>
	<script src="js/jquery.nice-select.min.js"></script>
	<script src="js/jquery.sticky.js"></script>
	<script src="js/nouislider.min.js"></script>
	<script src="js/jquery.magnific-popup.min.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<!--gmaps Js-->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
	<script src="js/gmaps.min.js"></script>
	<script src="js/main.js"></script>
</body>

</html>